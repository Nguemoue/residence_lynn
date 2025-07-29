<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class OrderTrackingController extends Controller
{
    /** Formulaire de recherche */
    public function index(): View
    {
        return view('pages.orders.track.index');
    }

    /** Soumet le n° de commande (UUID) et redirige vers la page de suivi */
    public function search(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'exists:orders,uuid'],
        ]);

        return redirect()->route('orders.track.show', $data['code']);
    }

    /** Affiche le détail + état d’avancement */
    public function show(Order $order): View
    {
        // Charge les lignes produits
        $order->load(['items.product']);

        return view('pages.orders.track.show', compact('order'));
    }
}
