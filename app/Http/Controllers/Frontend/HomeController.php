<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AccommodationType;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'faqs' => Faq::orderBy('id', 'desc')->take(5)->get(),
            'accommodationTypes' => AccommodationType::all(),
            'services' => Service::query()->take(6)->get(),
            'testimonials'=>Testimonial::take(3)->get()
        ]);
    }
}
