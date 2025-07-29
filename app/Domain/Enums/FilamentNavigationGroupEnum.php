<?php

namespace App\Domain\Enums;

enum FilamentNavigationGroupEnum: string
{
    case PRODUCTS = 'Produits';
    case BLOG = 'Blogs';
    case ORDER = 'Commandes';

    case ADMINISTRATION = 'administration';

}
