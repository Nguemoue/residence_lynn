<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home',[
            'faqs' => Faq::orderBy('id','desc')->take(5)->get(),
        ]);
    }
}
