<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\View\View;

final class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.about',[
            'teams'=> Team::all()
        ]);
    }
}
