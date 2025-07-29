<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture de commande {{ $order->uuid }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 0;
            width: 100vw;
            padding: 0 ;
            min-width: 100vw
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        .border-primary {
            border-color: green !important;
        }

        .text-primary {
            color: green !important;
        }

        .bg-primary {
            background-color: green !important;
        }
    </style>
</head>
<body class="text-dark bg-white">
<div class="container my-3">
    <!-- Header -->
    <header class="mb-3 pb-3 border-bottom border-primary">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 font-weight-bold text-primary">
{{--                    {{app(\App\Settings\GeneralSetting::class)->name}}--}}
                    <img src="{{public_path('assets/images/logo_noveden.png')}}" alt="logo noveden" width="200" height="auto">
                </h1>
                <p class="small text-muted">Facture de commande <strong>#{{ $order->code }}</strong></p>
                <div class="small text-muted">Reference de commande: <strong>{{ $order->uuid }}</strong></div>
                <div class="small text-muted">Émise le {{ $order->created_at->format('d/m/Y') }}</div>
            </div>
            <div class="text-right">
                <div class="small font-weight-bold">{{app(\App\Settings\GeneralSetting::class)->name}}</div>
                <div class="small text-muted">{{app(\App\Settings\GeneralSetting::class)->email}}</div>
                <div class="small text-muted">{{app(\App\Settings\GeneralSetting::class)->phoneNumber}}</div>
            </div>
        </div>
    </header>

    <!-- Order Details -->
    <section class="mb-5 ">
        <!-- Customer Information -->
        <div class="mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 font-weight-bold text-dark mb-3">Informations du client</h2>
                    <p class="small font-weight-medium mb-1">Nom Complet:  {{ $order->full_name }}</p>
                    <p class="small mb-1">Address de livraison:  {{ $order->address_line1 }}</p>
                    @if($order->address_line2)
                        <p class="small mb-1">{{ $order->address_line2 }}</p>
                    @endif
                    <p class="small mb-1">BP/Ville/Pays: {{ $order->postal_code }} {{ $order->city }}, {{ $order->country }}</p>
                    <p class="small mb-1">Email : {{ $order->email }}</p>
                    <p class="small mb-0">Téléphone : {{ $order->phone }}</p>
                </div>
            </div>
        </div>
        <!-- Order Information -->
        <div class="mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 font-weight-bold text-dark mb-3">Détails de la commande</h2>
                    <p class="small mb-1">Statut : {{ ucfirst(__($order->status->value)) }}</p>
                    @if($order->stripe_payment_intent)
                        <p class="small mb-1">Référence de paiement : {{ $order->stripe_payment_intent }}</p>
                    @endif
                    <p class="small mb-1">Sous-total : {{ Number::currency($order->subtotal) }}</p>
                    <p class="small mb-1">Frais de livraison
                        : {{ $order->shipping_total === 0 ? 'Gratuite' : Number::currency($order->shipping_total) }}</p>
                    @if($order->discount > 0)
                        <p class="small mb-1">Remise : {{ Number::currency($order->discount) }}</p>
                    @endif
                    <p class="small font-weight-bold text-primary mb-0">Total
                        : {{ Number::currency($order->total) }}</p>
                </div>
            </div>
        </div>

    </section>

    <!-- Order Items -->
    <section class="mb-5">
        <h2 class="h5 font-weight-bold text-dark mb-4">Articles commandés</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark bg-primary text-white">
                <tr>
                    <th scope="col" class="text-left py-2 px-3">Produit</th>
                    <th scope="col" class="text-right py-2 px-3">Quantité</th>
                    <th scope="col" class="text-right py-2 px-3">Prix unitaire</th>
                    <th scope="col" class="text-right py-2 px-3">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="py-2 px-3">
                            {{ $item->product ? $item->product->name : 'Produit supprimé (ID: ' . $item->product_id . ')' }}
                        </td>
                        <td class="py-2 px-3 text-right">x{{ $item->quantity }}</td>
                        <td class="py-2 px-3 text-right">{{ Number::currency($item->unit_price) }}</td>
                        <td class="py-2 px-3 text-right font-weight-medium">{{ Number::currency($item->total_price) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center border-top pt-4">
        <p class="small font-weight-bold">Merci pour votre confiance en {{ config('app.name') }} !</p>
        <p class="small">Pour toute question concernant votre commande, contactez notre service client à <a
                href="mailto:{{app(\App\Settings\GeneralSetting::class)->support}}" class="text-primary">{{app(\App\Settings\GeneralSetting::class)->support}}</a>.</p>
        <p class="small">Retrouvez toutes nos offres sur <a href="{{ config('app.url') }}" class="text-primary">{{ config('app.url') }}</a>.</p>
    </footer>
</div>
</body>
</html>
