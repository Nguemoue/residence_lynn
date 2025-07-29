<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AccommodationType;
use App\Models\Category;
use Illuminate\Contracts\View\View;

final class AccommodationTypeController extends Controller
{
    public function index(): View
    {
        return view('pages.accommodation_types.index', [
            'accommodationTypes' => AccommodationType::withCount('accommodations')->get(),
        ]);
    }

    public function show(AccommodationType $accommodationType): View
    {
        return view('pages.accommodation_types.show', [
            'type' => $accommodationType,
            'disabledDates' => []
        ]);
    }
}
