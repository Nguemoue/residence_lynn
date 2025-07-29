<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function __invoke(int $id)
    {
        $booking = Booking::findOrFail($id);
        return view('pages.booking.show',['booking'=>$booking]);
    }

}
