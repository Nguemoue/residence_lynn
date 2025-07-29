<?php
// app/Livewire/Cart/ShowCart.php
declare(strict_types=1);

namespace App\Livewire\Cart;

use App\Domain\Services\CartService;
use App\Enums\StockTypeEnum;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class ShowCart extends Component
{
    private readonly CartService $cartService;

    public function __construct()
    {
        $this->cartService = app(CartService::class);
    }

    /** Liste enrichie des lignes du panier */
    #[Computed]
    public function items(): Collection
    {
        return $this->cartService->items();        // ↑ Collection<int,array{product:Product,quantity:int,subtotal:float}>
    }

    /** Sous-total, livraison, total */
    #[Computed] public function subtotal(): float
    {
        return $this->cartService->subtotal();
    }

    #[Computed] public function shipping(): float
    {
        return $this->cartService->shipping();
    }

    #[Computed] public function total(): float
    {
        return $this->cartService->total();
    }

    /* --------------------------------------------------------------------- */
    /* Actions                                                               */
    /* --------------------------------------------------------------------- */

    /** + / – ou saisie directe */
    public function updateQuantity(int $productId, int $qty = 1): void
    {
        Validator::make(
            ['qty' => $qty],
            ['qty' => ['required', 'integer', 'min:1']]
        )->validate();

        $product = Product::query()->findOrFail(id: $productId, columns: ['stock_type', 'quantity']);
        if ($product === null) {
            flash()->error("Le produit demande est inexistant");
            return;
        }

        // Check quantity limits for limited stock products
        if ($product->stockIsLimited() ) {
            $cartService = app(CartService::class);
            if ($qty > $product->quantity) {
                //$this->dispatch('notify', type: 'error', message: 'Quantité demandée dépasse le stock disponible.');
                flash()->warning(message: 'Quantité demandée dépasse le stock disponible.');
                return;
            }
        }
        $this->cartService->update($productId, $qty);
        $this->dispatch('cart:updated', total: $this->cartService->count());
    }

    /** Retirer une ligne */
    public function removeItem(int $productId): void
    {
        $this->cartService->remove($productId);
        $this->dispatch('cart:updated', total: $this->cartService->count());
    }

    /** Vider le panier */
    public function clear(): void
    {
        $this->cartService->clear();
        $this->dispatch('cart:updated', total: 0);
    }

    public function render()
    {
        return view('livewire.cart.show-cart')
            ->title('Mon Panier – ' . config('app.name'));
    }
}
