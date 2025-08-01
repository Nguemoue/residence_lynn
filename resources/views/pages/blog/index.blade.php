{{-- resources/views/pages/blog/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Blog – ' . config('app.name'))
@section('meta-description', 'Conseils, guides pratiques et actualités autour de la beauté naturelle par Noveden')

@section('content')
    {{-- HERO ------------------------------------------------------------------}}
    <section class="hero min-h-[60vh] bg-cover bg-center"
             style="background-image: url({{ asset('assets/images/room2.jpg') }});">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold mb-4">Le blog {{app(\App\Settings\GeneralSetting::class)->name}}</h1>
                <p class="opacity-90">Conseils d'expert·e·s, astuces naturelles et actualités pour révéler votre beauté.</p>
                <div class="mt-6 h-1 w-24 bg-primary mx-auto rounded-full"></div>
            </div>
        </div>
    </section>

    {{-- LIVEWIRE BLOG LIST ---------------------------------------------------}}
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4">
            <livewire:blog.list-posts />
        </div>
    </section>
@endsection
