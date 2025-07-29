{{-- resources/views/pages/cart/show.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Mon Panier – ' . config('app.name'))

@php /** @var \Illuminate\Support\Collection<int,array{product:App\Models\Product,quantity:int,subtotal:float}> $cartItems */ @endphp

@section('content')
    {{-- HERO --}}
    <section class="hero min-h-[30vh] hero-image" >
        <div class="hero-overlay bg-black/60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-lg">
                <h1 class="text-4xl font-bold mb-4">Votre panier</h1>
                <p class="opacity-80">Vérifiez vos articles avant de passer commande</p>
            </div>
        </div>
    </section>

    {{-- PANIER --}}
    <livewire:cart.show-cart />
@endsection
