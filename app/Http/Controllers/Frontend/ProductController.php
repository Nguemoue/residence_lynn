<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Domain\Contracts\ProductRepositoryContract;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class ProductController extends Controller
{
    public function __construct(private readonly ProductRepositoryContract $products)
    {
    }

    public function index(Request $request): View
    {
        $query = Product::with('category')->latest();

        // Optionnel : filtrage par catégorie si `category` présent dans la query string
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        $products = $query->paginate(12);
        $categories = Category::select('name', 'slug')->orderBy('name')->get();

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show(Product $product): View
    {
        return view('pages.products.show', compact('product'));
    }
}
