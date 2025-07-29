<?php

return [
    'default_currency' => env('DEFAULT_CURRENCY', \App\Payments\Enums\Currency::XAF->value),
    'promotional_text' => "📆 Dates flexibles · Confirmation immédiate · Réservation sans stress",
    'about' => [
        'name' => 'Residence Lynn',
        'phone_number' => '+32 465 73 74 12',
        'email' => 'contact@residencelynn.com',
        'support' => 'support@residencelynn.com',
        'address' => 'Kribi, Cameroun',
        'company_number' => "1010723370"
    ],

    'socials' => [
        'facebook' => "",
        'instagram' => '',
        'twitter' => '',
        'whatsapp' => '',
    ],

    'timelines' => [
        [
            'order' => 1,
            'year' => 2020,
            'title' => "L’idée germe",
            'description' => "Notre fondatrice, Aïssa, élabore un masque capillaire maison pour sauver ses boucles. Une révélation qui marque le début de l’aventure."
        ],
        [
            'order' => 2,
            'year' => 2021,
            'title' => "Lancement de Noveden",
            'description' => "Mise en ligne de la boutique officielle. Plus de 1 000 premières commandes en quelques semaines. La nature trouve sa voix."
        ],
        [
            'order' => 3,
            'year' => 2022,
            'title' => "Premiers partenariats éthiques",
            'description' => "Collaboration avec des coopératives locales pour la récolte durable des plantes ayurvédiques et des actifs végétaux."
        ],
        [
            'order' => 4,
            'year' => 2023,
            'title' => "50 000 clientes engagées",
            'description' => "La communauté #Noveden s’épanouit : plus de 50 000 femmes partagent leurs routines et témoignages de beauté naturelle."
        ],
        [
            'order' => 5,
            'year' => 2024,
            'title' => "Création du labo R&D interne",
            'description' => "Un pôle scientifique est lancé pour développer des compléments capillaires de nouvelle génération, toujours 100% naturels."
        ],
        [
            'order' => 6,
            'year' => 2025,
            'title' => "Vers l'international",
            'description' => "Déploiement progressif des produits Noveden en Europe francophone. Premiers revendeurs partenaires en Belgique et en Suisse."
        ],
    ],

    'accommodation_types'=>[
        [
            'name' => "Appartement",
            'price_per_night'=>80000,
            'description' => "Un appartement est un logement autonome situé dans un immeuble résidentiel, offrant une indépendance relative tout en bénéficiant des services partagés (ascenseur, gardiennage, etc.).",
            'is_available'=>true
        ],
        [
            'name' => "Studio",
            'price_per_night'=>40000,
            'description' => "Une maison est un logement autonome situé sur un terrain, offrant une indépendance totale et souvent un jardin ou une cour. Elle peut être une propriété ou une résidence secondaire.",
            'is_available'=>true
        ],
        [
            'name' => "Chambre",
            'price_per_night'=>20000,
            'description' => "Une maison est un logement autonome situé sur un terrain, offrant une indépendance totale et souvent un jardin ou une cour. Elle peut être une propriété ou une résidence secondaire.",
            'is_available'=>true
        ],
    ],
    'powered_by'=>[
        'company_name'=>"GoulBam Enterprises",
        "link"=>"https://goulbam.com"
    ],
    'services'=>[
        ['name' => 'Piscine', 'description' => 'Piscine extérieure pour détente et loisirs', 'cover_image' => 'piscine.jpg'],
        ['name' => 'Jardin', 'description' => 'Jardin paysager idéal pour se relaxer', 'cover_image' => 'jardin.jpg'],
        ['name' => 'Restaurant ouvert', 'description' => 'Restaurant accessible aux résidents et visiteurs', 'cover_image' => 'restaurant.jpg'],
        ['name' => 'Connexion Wi-Fi offerte', 'description' => 'Internet haut débit disponible gratuitement', 'cover_image' => 'wifi.jpg'],
        ['name' => 'Parking sécurisé', 'description' => 'Espace de stationnement protégé pour véhicules', 'cover_image' => 'parking.jpg'],
        ['name' => 'Groupe électrogène', 'description' => 'Système de secours pour l’alimentation électrique', 'cover_image' => 'generateur.jpg'],
        ['name' => 'Forage', 'description' => 'Approvisionnement autonome en eau potable', 'cover_image' => 'forage.jpg'],
        ['name' => 'Blanchisserie', 'description' => 'Service de nettoyage et entretien du linge', 'cover_image' => 'blanchisserie.jpg'],
    ]

];
