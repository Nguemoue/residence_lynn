@extends('layouts.frontend')

@section('title', 'Paiement annulé – ' . config('app.name'))

@section('content')
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
    <section class="min-h-[80vh] flex items-center justify-center bg-base-100 px-4">
        <div class="text-center max-w-md">
            @svg('heroicon-o-x-circle', 'w-20 h-20 text-error mx-auto mb-4')
            <h1 class="text-3xl font-bold mb-4 text-error">Paiement annulé</h1>
            <p class="text-base opacity-80 mb-6">
                Le processus de paiement a été interrompu. Aucun montant n’a été débité.
            </p>
            <a href="{{ route('cart.show') }}" class="btn btn-primary">Revenir au panier</a>
        </div>
    </section>
@endsection
