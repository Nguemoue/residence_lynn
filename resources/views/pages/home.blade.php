{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.frontend')

@section('title', config('app.name'))

@section('content')

    {{-- HERO --}}
    <section class="hero min-h-[60vh] hero-image">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-xl">


                <h1 class="mb-5 text-5xl font-bold">Naturel, efficace, essentiel.</h1>
                <p class="mb-5">Noveden réinvente le soin avec des formules végétales pures, sans effort ni compromis</p>
                <a href="#products" class="btn btn-primary">Découvrir nos produits</a>
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-primary">Noveden - Beauté naturelle pour toutes</h2>
                <p class="text-base-content max-w-4xl mx-auto mt-4 line-clamp-6">
                    Plus qu’une marque, une vision

                    Noveden, c’est un retour à l’essentiel.
                    À ce que la nature a de plus précieux.
                    À une beauté durable, consciente, moderne, et profondément alignée.

                    Nos soins cosmétiques et nos compléments alimentaires ont été pensés pour se compléter et s’harmoniser.
                    Pour offrir des rituels à la fois efficaces, sensoriels et  respectueux de notre peau et de nos cheveux.

                    Chaque formule est élaborée autour :

                    d’actifs végétaux rigoureusement sélectionnés,

                    de technologies dermo-cosmétiques avancées,

                    et d’une composition saine, pure, inspirée par la nature.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-sparkles', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Excellence</h3>
                    <p class="text-sm">Des formules efficaces et naturelles pour des résultats visibles</p>
                </div>
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-truck', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Livraison rapide</h3>
                    <p class="text-sm">Offerte dès 49€ d'achat en Europe</p>
                </div>
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-shield-check', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Qualité garantie</h3>
                    <p class="text-sm">Satisfait ou remboursé sous 30 jours</p>
                </div>
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-heart', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Engagement</h3>
                    <p class="text-sm">Une équipe passionnée à votre service, avec amour</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-16 bg-base-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-primary">Nos produits phares</h2>
                <p class="text-base-content max-w-2xl mx-auto mt-4">
                    Découvrez notre collection de soins capillaires, compléments alimentaires et accessoires
                    pensés pour le bien-être naturel de toute la famille.
                </p>
            </div>

            <livewire:home.featured-products :limit="6" />
        </div>
    </section>

    <!-- FAQ Section -->
    <x-frontend.faq-section :faqs="$faqs"/>

    <!-- Newsletter Section -->
    <livewire:newsletter-form/>

@endsection
