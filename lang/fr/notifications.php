<?php

return [
    'order_paid' => [
        'subject' => 'Confirmation de paiement pour votre commande :code',
        'greeting' => 'Bonjour :name,',
        'intro' => 'Nous vous remercions pour votre commande ! Votre paiement a été reçu avec succès.',
        'order_number' => 'Numéro de commande : :uuid',
        'order_date' => 'Date de commande : :date',
        'total' => 'Total : :total',
        'items' => 'Articles commandés',
        'product' => 'Produit',
        'quantity' => 'Quantité',
        'unit_price' => 'Prix unitaire',
        'total_price' => 'Total',
        'download_order' => 'Telecharger la facture',
        'track_order' => 'Suivre ma commande',
        'thanks' => 'Merci de votre confiance en ' . config('app.name') . ' !',
        'contact' => 'Pour toute question, contactez notre service client à :email.',
        'rights' => 'Tous droits réservés.',
    ],
];
