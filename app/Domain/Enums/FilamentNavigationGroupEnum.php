<?php

namespace App\Domain\Enums;

enum FilamentNavigationGroupEnum: string
{
    case Reservation = 'Accommodations';
    case Blog = 'Blogs';
    case Booking = 'Bookings';

    case Administration = 'administration';

}
