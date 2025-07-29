<?php
declare(strict_types=1);

namespace App\Domain\Enums;

enum AccommodationTypeEnum: string
{
    case CHAMBRE = 'chambre';
    case APPARTEMENT = 'appartement';
    case STUDIO = 'studio';
}
