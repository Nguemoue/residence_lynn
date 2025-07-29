<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Domain\Services\CartService;
use App\Payments\DTO\PaymentRequestDTO;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function show(): View
    {
        $cartItems = $this->cart->items(); // Collection
        $subtotal  = $this->cart->subtotal();
        $shipping  = $this->cart->shipping();
        $total     = $this->cart->total();
        $cartCount = $this->cart->totalItems(); // pour le badge navbar

        return view('pages.cart.show', compact(
            'cartItems', 'subtotal', 'shipping', 'total', 'cartCount'
        ));
    }


    public function update(Request $request, int $item): RedirectResponse
    {
        $quantity = (int) $request->validate(['quantity' => ['required','integer','min:1']])['quantity'];

        $this->cart->update($item, $quantity);

        return back()->with('success', 'Quantité mise à jour.');
    }

    public function destroy(int $item): RedirectResponse
    {
        $this->cart->remove($item);

        return back()->with('success', 'Article retiré.');
    }

}
