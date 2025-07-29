<?php

declare(strict_types=1);

namespace App\Livewire\Product;

use App\Domain\Services\CartService;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

final class AddToCart extends Component
{
    #[Locked] // évite la modification client
    public Product $product;

    public int $qty = 1;   // quantité à ajouter

    public function addToCart(CartService $cart): void
    {
        //check that the quantity is not higher thant the available
        if ($this->product->stock_type === 'limited') {
            $cartService = app(CartService::class);
            $currentCartQuantity = $cartService->getQuantity($this->product->id);
            $totalRequestedQuantity = $currentCartQuantity + $this->qty;
            if ($totalRequestedQuantity > $this->product->quantity) {
                //$this->dispatch('notify', type: 'error', message: 'Quantité demandée dépasse le stock disponible.');
                flash()->warning(message: 'Quantité demandée dépasse le stock disponible.');
                return;
            }
        }
        //flash the success message
        \Flasher\Prime\flash()->preset('cart_added');

        //add to cart
        $cart->add($this->product->id, $this->qty);

        // feedback visuel global (ex. toast + navbar)
        $this->dispatch('cart:item-added', id: $this->product->id);
        $this->dispatch('cart:updated');
    }

    public function render(): View
    {
        return view('livewire.product.add-to-cart');
    }
}
