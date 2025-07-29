<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Enums\StockTypeEnum;
use App\Exceptions\CartItemNotFoundException;
use App\Exceptions\InvalidCartException;
use App\Models\Product;
use Illuminate\Session\Store;
use Illuminate\Support\Collection;

/**
 * Service de gestion du panier (stocké en session).
 *
 * Structure session :
 *   [
 *       12 => 2,   // product_id => quantity
 *       37 => 1,
 *   ]
 */
final class CartService
{
    private const SESSION_KEY = 'cart';

    public function __construct(private readonly Store $session) {}

    /**
     * Valide le panier pour le paiement.
     *
     * Vérifie que :
     * - Le panier n'est pas vide.
     * - Tous les produits existent et sont actifs.
     * - Pour les produits à stock limité, la quantité demandée ne dépasse pas le stock disponible.
     *
     * @throws InvalidCartException Si une règle de validation échoue.
     */
    public function validateCart(): void
    {
        $cart = $this->session->get(self::SESSION_KEY, []);

        // Vérifier si le panier est vide
        if (empty($cart)) {
            throw InvalidCartException::emptyCart();
        }

        // Récupérer les IDs des produits
        $productIds = array_keys($cart);

        // Charger les produits en une seule requête
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Vérifier chaque article du panier
        foreach ($cart as $productId => $quantity) {
            // Vérifier si le produit existe
            if (!isset($products[$productId])) {
                throw InvalidCartException::productNotFound($productId);
            }

            $product = $products[$productId];

            // Vérifier si le produit est actif
            if (!$product->is_active) {
                throw InvalidCartException::productNotActive($product->name);
            }

            // Vérifier le stock pour les produits à stock limité
            if ($product->stockIsLimited()  && $quantity > $product->quantity) {
                throw InvalidCartException::insufficientStock($product->name, $quantity, $product->quantity);
            }
        }
    }

    /**
     * Collection des lignes de panier enrichies.
     *
     * @return Collection<int,array{
     *     product: Product,
     *     quantity: int,
     *     unit_price: float,
     *     subtotal: float
     * }>
     */
    public function items(): Collection
    {
        /** @var array<int,int> $cart */
        $cart = $this->session->get(self::SESSION_KEY, []); // [id => qty]

        return collect($cart)
            ->map(function (int $qty, int $productId) {
                $product = Product::find($productId);
                if (!$product) {
                    return null;               // Produit supprimé en BD
                }

                $price = $product->effective_price ?? $product->price;

                return [
                    'product'    => $product,
                    'quantity'   => $qty,
                    'unit_price' => $price,
                    'subtotal'   => $price * $qty,
                ];
            })
            ->filter()   // retire les null (produits manquants)
            ->values();
    }

    /* --------------------------------------------------------------------- */
    /* Actions CRUD                                                          */
    /* --------------------------------------------------------------------- */

    /** Ajoute une quantité (+1 par défaut) */
    public function add(int $productId, int $qty = 1): void
    {
        $cart = $this->session->get(self::SESSION_KEY, []);
        $cart[$productId] = ($cart[$productId] ?? 0) + $qty;
        $this->session->put(self::SESSION_KEY, $cart);
    }

    /** Met à jour la quantité d’un article */
    public function update(int $productId, int $qty): void
    {
        $cart = $this->session->get(self::SESSION_KEY, []);

        if (!isset($cart[$productId])) {
            throw CartItemNotFoundException::becauseItemMissing();
        }

        $cart[$productId] = $qty;
        $this->session->put(self::SESSION_KEY, $cart);
    }

    /** Supprime un article du panier */
    public function remove(int $productId): void
    {
        $cart = $this->session->get(self::SESSION_KEY, []);
        unset($cart[$productId]);
        $this->session->put(self::SESSION_KEY, $cart);
    }

    /** Vide complètement le panier */
    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    /* --------------------------------------------------------------------- */
    /* Calculs                                                               */
    /* --------------------------------------------------------------------- */

    /** Sous-total (€) */
    public function subtotal(): float
    {
        return $this->items()->sum(fn ($line) => $line['subtotal']);
    }

    /** Frais de port (gratuit ≥ 49 €) */
    public function shipping(float $threshold = 49): float
    {
        return $this->subtotal() >= $threshold ? 0.0 : 5.90;
    }

    /** Total (€) */
    public function total(): float
    {
        return $this->subtotal() + $this->shipping();
    }

    /** Nombre total d’articles */
    public function count(): int
    {
        return $this->items()->sum('quantity');
    }

    /** Alias rétro-compatibilité */
    public function totalItems(): int
    {
        return $this->count();
    }

    /**
     * Retrieve the quantity of a specific product in the cart.
     *
     * This method checks the session-stored cart for the given product ID and
     * returns the associated quantity. If the product is not in the cart, it
     * returns 0. The cart structure is expected to be an array where keys are
     * product IDs and values are quantities (e.g., [12 => 2, 37 => 1]).
     *
     * @param int $productId The ID of the product to check.
     * @return int The quantity of the product in the cart, or 0 if not present.
     */
    public function getQuantity(int $productId): int
    {
        $cart = $this->session->get(self::SESSION_KEY, []);
        return isset($cart[$productId]) ? (int) $cart[$productId] : 0;
    }
}
