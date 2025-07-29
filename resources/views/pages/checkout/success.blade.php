@extends('layouts.frontend')

@section('title', 'Commande réussie – ' . config('app.name'))

@section('content')
    {{-- BREADCRUMB -----------------------------------------------------------}}
    <section class="bg-base-200 py-3">
        <div class="container mx-auto px-4">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('products.index') }}">Panier</a></li>
                    <li>Paiement finalise</li>
                </ul>
            </div>
        </div>
    </section>
    <section class="min-h-[50vh] flex items-center justify-center bg-base-100 px-4">
        <div class="text-center max-w-md">
            @svg('heroicon-o-check-circle', 'w-20 h-20 text-success mx-auto mb-4')
            <h1 class="text-3xl font-bold mb-4 text-success">Merci pour votre commande !</h1>
            <p class="text-base opacity-80 mb-6">
                Votre paiement a été confirmé. Vous recevrez un e-mail de confirmation avec les détails de votre commande.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary">Retour à l’accueil</a>
        </div>
    </section>
@endsection
