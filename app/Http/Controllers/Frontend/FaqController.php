<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\View\View;

final class FaqController extends Controller
{
    public function __invoke(): View
    {
        $faqs = Faq::query()->where('is_active', true)->get();

        return view('pages.faq.index', compact('faqs'));
    }
}
