<?php

return [
    // Filter Form
    'filters' => 'Filtres',
    'start_date' => 'Date de début',
    'end_date' => 'Date de fin',

    // Product Stats Widget
    'product_stats' => [
        'total_products' => 'Total des produits',
        'total_products_desc' => 'Nombre total de produits dans le catalogue',
        'active_products' => 'Produits actifs',
        'active_products_desc' => 'Produits actuellement disponibles à la vente',
        'out_of_stock' => 'Produits en rupture',
        'out_of_stock_desc' => 'Produits avec stock épuisé',
    ],

    // Order Stats Widget
    'order_stats' => [
        'total_orders' => 'Total des commandes',
        'total_orders_desc' => 'Nombre total de commandes passées',
        'total_revenue' => 'Chiffre d\'affaires',
        'total_revenue_desc' => 'Revenus totaux des commandes',
        'pending_orders' => 'Commandes en attente',
        'pending_orders_desc' => 'Commandes en attente de traitement',
    ],

    // Contact Stats Widget
    'contact_stats' => [
        'total_contacts' => 'Total des contacts',
        'total_contacts_desc' => 'Nombre total de contacts enregistrés',
        'recent_contacts' => 'Contacts récents',
        'recent_contacts_desc' => 'Contacts ajoutés au cours des 7 derniers jours',
    ],

    // Post Stats Widget
    'post_stats' => [
        'total_posts' => 'Total des articles',
        'total_posts_desc' => 'Nombre total d\'articles de blog',
        'published_posts' => 'Articles publiés',
        'published_posts_desc' => 'Articles actuellement publiés',
        'average_read_time' => 'Temps de lecture moyen',
        'average_read_time_desc' => 'Temps moyen pour lire un article',
    ],

    // Tag Stats Widget
    'tag_stats' => [
        'total_tags' => 'Total des tags',
        'total_tags_desc' => 'Nombre total de tags utilisés',
        'most_used_tag' => 'Tag le plus utilisé',
        'most_used_tag_desc' => 'Tag associé à {count} article(s)',
        'none' => 'Aucun',
    ],

    // Recent Orders Table Widget
    'recent_orders' => [
        'uuid' => 'ID de commande',
        'customer' => 'Client',
        'total' => 'Total',
        'status' => 'Statut',
        'created_at' => 'Date de création',
    ],

    // Order Status Enum (assuming OrderStatusEnum values)
    'received' => 'Reçue',
    'pending' => 'En attente',
    'processing' => 'En cours de traitement',
    'shipped' => 'Expédiée',
    'delivered' => 'Livrée',
    'cancelled' => 'Annulée',
];
