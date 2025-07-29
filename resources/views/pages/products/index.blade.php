@extends('layouts.frontend')

@section('title', 'Produits – ' . config('app.name'))

@section('content')
    {{-- HERO --}}
    <section class="hero min-h-[40vh] hero-image" >
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-xl">
                <h1 class="mb-4 text-4xl font-bold">Nos Produits</h1>
                <p class="mb-6">Soins capillaires, compléments et accessoires pour révéler votre beauté naturelle.</p>
                <a href="#catalogue" class="btn btn-primary">Découvrir le catalogue</a>
            </div>
        </div>
    </section>

    {{-- BLOC LIVEWIRE --}}
    <section id="catalogue" class="py-16 bg-base-100">
        <div class="container mx-auto px-4">
            <livewire:products-grid />
        </div>
    </section>
@endsection
