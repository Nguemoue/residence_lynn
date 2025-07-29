{{-- resources/views/pages/about/show.blade.php --}}
@extends('layouts.frontend')

@section('title', 'À propos – ' . config('app.name'))
@section('meta-description', 'Découvrez la mission, les valeurs et la vision de notre plateforme de réservation de logements à Kribi – pour des séjours confortables, durables et inoubliables.')

@section('content')
    {{-- HERO ------------------------------------------------------------------}}
    <section class="hero min-h-[50vh] hero-image" style="background-image: url('{{ asset('assets/images/kribi-header.jpg') }}');">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold mb-4">Notre histoire, votre séjour idéal à Kribi</h1>
                <p class="opacity-90">Depuis ma naissance, j'accueille voyageurs et curieux dans le confort et la chaleur de la ville de Kribi. Ici, tout est pensé pour vous faire sentir chez vous.</p>
            </div>
        </div>
    </section>

    {{-- NOTRE MISSION --------------------------------------------------------}}
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-bold">Bienvenue chez {{ app(\App\Settings\GeneralSetting::class)->name }}</h2>
                <div class="opacity-80 text-justify space-y-4">
                    <p>Nous sommes née d’un rêve simple : offrir à chaque visiteur une parenthèse de sérénité, entre plages dorées et hospitalité sincère. Mon cœur bat au rythme des vagues de Kribi, et chaque espace que j’abrite a été soigneusement pensé pour vous.</p>
                    <p>Ici, vous ne réservez pas seulement un logement. Vous entrez dans une atmosphère, un lieu vivant, un refuge loin du stress quotidien. Que vous choisissiez un studio douillet ou un appartement spacieux, je vous reçois avec les bras ouverts.</p>
                    <p>Ma mission est d'être cette maison loin de chez vous. Offrir à chacun un sentiment de sécurité, de liberté et de bien-être. Grâce à une technologie discrète mais efficace, je simplifie chaque étape de votre séjour.</p>
                    <p>Nous sommes fière de porter les valeurs de la communauté locale. Ensemble, nous construisons une expérience où chaque visite est une rencontre, chaque nuit un souvenir, chaque matin une promesse.</p>
                </div>
            </div>
            <img src="{{ asset('assets/images/detailed.jpg') }}" alt="Plage de Kribi" class="rounded-box shadow-lg object-cover w-full" />
        </div>
    </section>

    {{-- NOS VALEURS ----------------------------------------------------------}}
    <section class="py-16 bg-base-200">
        <div class="container mx-auto px-4 text-center space-y-10">
            <h2 class="text-3xl font-bold">Mes engagements envers vous</h2>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-home', 'w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Confort</h3>
                    <p class="text-sm opacity-80">Chaque logement est conçu pour être votre cocon : propre, meublé et prêt à vous accueillir.</p>
                </div>
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-check-badge', 'w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Fiabilité</h3>
                    <p class="text-sm opacity-80">Nous vous accompagne du clic de réservation jusqu’à la remise des clés, en toute confiance.</p>
                </div>
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-map', 'w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Localisation</h3>
                    <p class="text-sm opacity-80">Nous sommes idéalement située, entre les plages, les restaurants et les lieux incontournables de Kribi.</p>
                </div>
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-users', 'w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Communauté</h3>
                    <p class="text-sm opacity-80">En m’appuyant sur les talents locaux, je participe à faire rayonner Kribi bien au-delà de ses frontières.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CALL TO ACTION -------------------------------------------------------}}
    <section class="py-16 bg-primary text-white text-center">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-4">Et si je devenais votre prochain refuge ?</h2>
            <p class="mb-6">Parcourez mes logements, choisissez votre date, et laissez-moi vous offrir un séjour inoubliable.</p>
            <a href="{{ url('/#accommodations') }}" class="btn btn-outline bg-white text-primary hover:bg-white">Voir les hébergements</a>
        </div>
    </section>
@endsection
