<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function __invoke()
    {
        return view('pages.gallery.index',[
            'galleries' => \App\Models\Gallery::all(),
        ]);
    }

}
