<?php
declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use App\Domain\Services\CartService;

class Navbar extends Component
{
    public int $cartCount = 0;

    protected $listeners = [
        'cart:updated' => 'refreshCart',
        'cart:item-added' => 'refreshCart',
        'cart:item-removed' => 'refreshCart',
    ];

    public function mount(CartService $cart): void
    {
        $this->cartCount = $cart->totalItems();
    }

    public function refreshCart(CartService $cart): void
    {
        $this->cartCount = $cart->totalItems();
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
