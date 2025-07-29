<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ __('notifications.order_paid.subject') }}</title>
    <style type="text/css">
        /* Corps de l'email */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #F1ECE2; /* Couleur de fond claire */
            padding: 1rem;
            margin: 0;
            font-size: 1rem;
            color: #1F2937; /* Couleur du texte principal */
        }

        /* Container principal */
        table {
            width: 100%;
            max-width: 56.25rem;
            margin: auto;
            background-color: #ffffff; /* Fond blanc pour la carte */
            border: 1px solid #D1C9B8; /* Bordure claire pour la carte */
            padding: 1.25rem;
            border-radius: 0.625rem;
        }

        /* Titre principal */
        h1 {
            font-size: 1.5rem;
            color: #2F6D4A; /* Vert foncé pour le titre */
            margin: 0 0 1rem;
            text-align: center;
        }

        /* Paragraphe */
        p {
            font-size: 1rem;
            color: #1F2937; /* Texte principal */
            margin-bottom: 1rem;
            text-align: center;
        }

        /* Titre du modal */
        h2 {
            font-size: 1.125rem;
            color: #2F6D4A; /* Vert foncé pour le titre */
            margin-top: 1.875rem;
            font-weight: bold;
            text-align: center;
        }

        /* Liste des articles */
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        /* Style de chaque élément de produit */
        li {
            display: flex;
            justify-content: space-between;
            background-color: #E3DCCF; /* Fond léger pour les éléments */
            border-radius: 0.625rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #D1C9B8; /* Bordure claire pour séparer les éléments */
        }

        li div {
            width: 100%;
        }

        /* Alignement à gauche pour le nom du produit */
        .product-name {
            text-align: left;
            flex: 1;
        }

        /* Alignement à droite pour la quantité, le prix unitaire et le prix total */
        .product-info {
            text-align: right;
            flex: 1;
        }

        /* Séparateur entre les produits */
        li:not(:last-child) {
            border-bottom: 1px solid #D1C9B8; /* Bordure entre les éléments */
        }

        /* Boutons */
        .button {
            background-color: transparent;
            color: #2F6D4A; /* Vert foncé */
            border: 2px solid #2F6D4A; /* Bordure du bouton */
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 0.3125rem;
            display: inline-block;
            font-size: 1rem;
            margin: 0.5rem;
            text-align: center;
        }

        .button-secondary {
            color: #A4B28B; /* Olive doux */
            border: 2px solid #A4B28B; /* Bordure olive doux */
        }

        /* Footer */
        hr {
            margin: 2.5rem 0;
            border: none;
            border-top: 1px solid #D1C9B8; /* Bordure claire */
        }

        footer p {
            font-size: 0.75rem;
            color: #aaaaaa;
            text-align: center;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <td>
            <h1>{{ __('notifications.order_paid.greeting', ['name' => $order->full_name]) }}</h1>

            <p>{{ __('notifications.order_paid.intro') }}</p>

            <p>
                <strong>{{ __('notifications.order_paid.order_number', ['uuid' => $order->uuid]) }}</strong><br>
                {{ __('notifications.order_paid.order_date', ['date' => $order->created_at->format('d/m/Y')]) }}<br>
                {{ __('notifications.order_paid.total', ['total' => $formatPrice($order->total)]) }}
            </p>

            <h2>{{ __('notifications.order_paid.items') }}</h2>

            <ul>
                @foreach($order->items as $item)
                    <li>
                        <div class="product-name">
                            <strong>{{ $item->product ? $item->product->name : 'Produit supprimé (ID: ' . $item->product_id . ')' }}</strong>
                        </div>
                        <div class="product-info">
                            <p>{{ __('notifications.order_paid.quantity') }}: <strong>{{ $item->quantity }}</strong></p>
                            <p>{{ __('notifications.order_paid.unit_price') }}: <strong>{{ $formatPrice($item->unit_price) }}</strong></p>
                            <p>{{ __('notifications.order_paid.total_price') }}: <strong>{{ $formatPrice($item->total_price) }}</strong></p>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div style="text-align: center; margin: 1.875rem 0;">
                <a href="{{ route('orders.pdf', ['order' => $order]) }}" class="button">
                    {{ __('notifications.order_paid.download_order') }}
                </a>
                <a href="{{ route('orders.track.show', ['order' => $order]) }}" class="button button-secondary">
                    {{ __('notifications.order_paid.track_order') }}
                </a>
            </div>

            <p>{{ __('notifications.order_paid.thanks') }}</p>

            <p>{{ __('notifications.order_paid.contact', ['email' => config('project.about.support')]) }}</p>

            <hr>

            <footer>
                <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('notifications.order_paid.rights') }}</p>
            </footer>
        </td>
    </tr>
</table>

</body>
</html>
