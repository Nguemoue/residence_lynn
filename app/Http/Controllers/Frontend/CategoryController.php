<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;

final class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->get();

        return view('pages.categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $category->load('products');

        return view('pages.categories.show', compact('category'));
    }
}
