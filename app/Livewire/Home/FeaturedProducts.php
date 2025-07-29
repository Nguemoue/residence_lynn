<?php
declare(strict_types=1);

namespace App\Livewire\Home;

use App\Enums\StockTypeEnum;
use App\Models\Category;
use App\Models\Product;
use App\Domain\Services\CartService;
use Livewire\Attributes\Url;
use Livewire\Component;

final class FeaturedProducts extends Component
{
    public function __construct()
    {
    }

    /** Catégorie slug sélectionnée (null = toutes) */
    #[Url(except: '')]
    public ?string $category = null;

    /** Nombre maximum d’articles affichés */
    public int $limit = 8;

    /* --------------------------------------------------------------------- */
    /*  COMPUTED                                                              */
    /* --------------------------------------------------------------------- */

    /** Liste des produits filtrés et limités */
    public function getProductsProperty()
    {
        return Product::published()
            ->with('category')
            ->when($this->category, fn ($q) =>
            $q->whereHas('category', fn ($c) => $c->where('slug', $this->category))
            )
            ->latest()
            ->take($this->limit)
            ->get();
    }

    /** Toutes les catégories avec au moins un produit publié */
    public function getCategoriesProperty()
    {
        return cache()->remember(
            'featured_categories',
            60,
            fn () => Category::whereHas('products', fn ($q) => $q->published())->orderBy('name')->get()
        );
    }

    /* --------------------------------------------------------------------- */

    public function addToCart(int $productId, int $quantity = 1): void
    {
        $product = Product::query()->findOrFail(id: $productId, columns: ['stock_type', 'quantity','is_active']);
        if ($product === null) {
            flash()->error("Le produit demande est inexistant");
            return;
        }

        // Check if product is valid for cart
        if (!$product->isValidForCart()) {
           flash()->flash( type: 'error', message: 'Ce produit n\'est pas disponible pour le panier.');
            return;
        }
        // Check quantity limits for limited stock products
        if ($product->stockIsLimited() ) {
            $cartService = app(CartService::class);
            $currentCartQuantity = $cartService->getQuantity($productId);
            $totalRequestedQuantity = $currentCartQuantity + $quantity;

            if ($totalRequestedQuantity > $product->quantity) {
                //$this->dispatch('notify', type: 'error', message: 'Quantité demandée dépasse le stock disponible.');
                flash()->warning(message: 'Quantité demandée dépasse le stock disponible.');
                return;
            }
        }

        // Add to cart
        app(CartService::class)->add($productId, $quantity);
        $this->dispatch('cart:item-added', id: $productId);
        flash()->preset('cart_added');
        //$this->dispatch('notify', type: 'success', message: 'Produit ajouté au panier !');
    }

    /* --------------------------------------------------------------------- */

    public function render()
    {
        return view('livewire.home.featured-products', [
            'products'   => $this->products,
            'categories' => $this->categories,
        ]);
    }
}
