{{-- resources/views/pages/faq/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'FAQ – ' . config('app.name'))
@section('meta-description', 'Les réponses aux questions les plus fréquentes sur les produits et services Noveden')

@php /** @var \Illuminate\Support\Collection<int,\App\Models\Faq> $faqs */ @endphp

@section('content')
    {{-- HERO ------------------------------------------------------------------}}
    <section class="hero min-h-[40vh] hero-image">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-lg">
                <h1 class="text-5xl font-bold mb-4">Foire aux questions</h1>
                <p class="opacity-80">Tout ce que vous devez savoir sur nos soins naturels et votre commande.</p>
            </div>
        </div>
    </section>

    {{-- FAQ LIST -------------------------------------------------------------}}
    <x-frontend.faq-section :faqs="$faqs"/>
@endsection
