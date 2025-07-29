<?php

return [
    'default_currency' => env('DEFAULT_CURRENCY', \App\Payments\Enums\Currency::EUR->value),
    'promotional_text' => "🎁 Livraison offerte dès 49€ d’achat · Paiement sécurisé · Retour gratuit sous 30 jours ·Satisfait ou remboursé",
    'about' => [
        'name' => 'Noveden',
        'phone_number' => '+32 465 73 74 12',
        'email' => 'contact@noveden.com',
        'support' => 'support@noveden.com',
        'address' => 'Belgique',
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

    'powered_by'=>[
        'company_name'=>"GoulBam Enterprises",
        "link"=>"https://goulbam.com"
    ]

];
