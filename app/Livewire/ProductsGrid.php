<?php
declare(strict_types=1);

namespace App\Livewire;

use App\Enums\StockTypeEnum;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use App\Domain\Services\CartService;

class ProductsGrid extends Component
{
    use WithPagination;

    #[Url(history: true)] // Persist category filter in URL
    public ?string $category = null;

    #[Url(history: true)] // Persist search query in URL
    public ?string $search = null;

    public int $perPage = 12;

    /** Catégories (pour les filtres) */
    #[Computed]
    public function categories()
    {
        return Category::select('name', 'slug')->orderBy('name')->get();
    }

    /** Produits paginés selon les filtres */
    #[Computed]
    public function products()
    {
        $query = Product::with('category')->where('is_active', true)->latest();

        if ($this->category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
        }

        if ($this->search) {

            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('short_description', 'like', '%' . $this->search . '%');
            });
        }

        return $query->paginate($this->perPage);
    }

    /** Ajouter au panier + dispatch événement navbar */
    public function addToCart(int $productId, CartService $cart): void
    {
        $product = Product::query()->findOrFail(id: $productId, columns: ['stock_type', 'quantity','is_active']);
        if ($product === null) {
            flash()->error("Le produit demande est inexistant");
            return;
        }
        // Check if product is valid for cart
        if (!$product->isValidForCart()) {
            $this->dispatch('notify', type: 'error', message: 'Ce produit n\'est pas disponible pour le panier.');
            return;
        }

        // Check quantity limits for limited stock products
        if ($product->stockIsLimited() ) {
            $currentCartQuantity = $cart->getQuantity($productId);
            $totalRequestedQuantity = $currentCartQuantity + 1;
            if ($totalRequestedQuantity > $product->quantity) {
                $this->dispatch('notify', type: 'error', message: 'Quantité demandée dépasse le stock disponible.');
                flash()->warning('Quantité demandée dépasse le stock disponible.');
                return;
            }
        }

        // Add to cart
        $cart->add($productId, 1);
        $this->dispatch('cart:updated'); // Informe la Navbar
        $this->dispatch('cart:item-added', id: $productId); // Pour l'animation
        //$this->dispatch('notify', type: 'success', message: 'Article ajouté 👍');
        flash()->preset('cart_added');
    }

    public function render()
    {
        return view('livewire.products-grid');
    }
}
