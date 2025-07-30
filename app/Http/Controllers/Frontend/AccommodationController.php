<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Domain\Contracts\ProductRepositoryContract;
use App\Models\Accommodation;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class AccommodationController extends Controller
{


    public function show(Accommodation $accommodation): View
    {
        return view('pages.accommodation.show', [
            'accommodation'=>$accommodation
        ]);
    }
}
