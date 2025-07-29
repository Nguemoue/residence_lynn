<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CheckoutActionCancelController extends Controller
{
    public function __invoke()
    {
        return view('pages.checkout.cancel');
    }
}
