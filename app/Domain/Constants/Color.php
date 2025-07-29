<?php

namespace App\Domain\Constants;

class Color
{
    public const APP_COLOR = [
        50 => 'oklch(0.985 0 0)',          // White background (#FFFFFF)
        100 => 'oklch(0.967 0.001 286.375)', // Very light gray (#F6F6F6)
        200 => 'oklch(0.92 0.004 286.32)',  // Light gray (#E9E9E9)
        300 => 'oklch(0.871 0.006 286.286)', // Medium-light gray (#DDD)
        400 => 'oklch(0.70 0.14 40.0)',     // Orange base (#F28C38, from logo)
        500 => 'oklch(0.60 0.13 40.0)',     // Slightly darker orange (#D67A2F)
        600 => 'oklch(0.50 0.12 40.0)',     // Darker orange-gray blend (leaf accent)
        700 => 'oklch(0.44 0.02 0)',        // Gray outline (#666666, neutral)
        800 => 'oklch(0.30 0.01 0)',        // Dark gray (#4D4D4D)
        900 => 'oklch(0.21 0.006 285.885)', // Very dark gray (#353535)
        950 => 'oklch(0.141 0.005 285.823)',// Near-black gray (#242424)
    ];
}
