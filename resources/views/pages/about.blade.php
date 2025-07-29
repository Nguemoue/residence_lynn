{{-- resources/views/pages/about/show.blade.php --}}
@extends('layouts.frontend')

@section('title', 'À propos – ' . config('app.name'))
@section('meta-description', 'Découvrez la mission, les valeurs et l\'histoire de Noveden – cosmétiques capillaires et compléments naturels pour toute la famille.')

@section('content')
    {{-- HERO ------------------------------------------------------------------}}
    <section class="hero min-h-[50vh] hero-image">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold mb-4">Notre histoire, votre beauté naturelle</h1>
                <p class="opacity-90">Depuis 2020, Noveden s'engage à révéler l'éclat naturel des cheveux et de la peau grâce à la puissance des plantes.</p>
            </div>
        </div>
    </section>

    {{-- MISSION & VISION -----------------------------------------------------}}
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-bold">À propos de {{app(\App\Settings\GeneralSetting::class)->name}}</h2>
                <div class="opacity-80 text-justify">
                    <p class="py-2">✨ À propos de Noveden</p>

                    <p class="py-2">Noveden est né d’un désir profond : celui de revenir à l’essence même de la beauté — pure, naturelle, vivante.</p>
                    <p >Un retour aux origines, à ce que la nature nous offre de plus précieux.</p>
                    <p >Comme un écho à l’Éden.</p>
                    <p >Un jardin originel où chaque plante, chaque fruit, chaque racine porte en elle une promesse de soin, de douceur, de transformation.</p>

                    <p class="py-2">✨ Notre marque, est la rencontre entre la science végétale, les rituels ancestraux, et une vision moderne de la beauté — consciente, sensorielle, essentielle.</p>

                    <p class="py-2">Chez Noveden, nous croyons que la beauté véritable ne se limite pas à l’apparence.</p>
                    <p class="py-2">Elle naît d’un équilibre subtil entre ce que nous nourrissons à l’intérieur… et ce que nous révélons à l’extérieur.</p>

                    <p class="py-2">C’est pourquoi nous avons imaginé une approche holistique, où les soins cosmétiques et les compléments beauté se complètent, et s’harmonisent pour révéler une beauté profonde, équilibrée et durable.</p>

                    <p class="py-2">De cette vision est née une gamme complète de soins capillaires, cosmétiques et de compléments alimentaires, fondée sur une alliance unique :</p>
                    <p class="py-2">👉 la puissance des actifs végétaux,<br>
                        👉 la richesse de la science dermo-cosmétique,<br>
                        👉 et une approche profondément sensorielle et naturelle.</p>

                    <p class="py-2">Chaque formule est conçue pour renforcer la peau et les cheveux de l’intérieur, tout en offrant à l’extérieur des textures raffinées, des actifs ciblés et des résultats visibles.</p>

                    <p class="py-2">Chez Noveden, chaque ingrédient a un sens. Chaque soin a une intention :</p>
                    <p class="py-2">✨ révéler la beauté naturelle,<br>
                        ✨ restaurer l’équilibre,<br>
                        ✨ et nourrir durablement notre peau et nos cheveux.</p>

                    <p class="py-2">🌿 Naturel. Sensoriel. Moderne. Essentiel.</p>
                    <p class="py-2">Bienvenue dans notre nouveau jardin.</p>

                </div>

            </div>
            <img src="{{ asset('assets/images/about-section.jpg') }}" alt="Récolte d'ingrédients naturels" class="rounded-box shadow-lg object-cover  w-full" />
        </div>
    </section>

    {{-- VALEURS --------------------------------------------------------------}}
    <section class="py-16 bg-base-200">
        <div class="container mx-auto px-4 text-center space-y-10">
            <h2 class="text-3xl font-bold">Nos valeurs fondamentales</h2>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-paper-clip','w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Nature</h3>
                    <p class="text-sm opacity-80">Formules à ≥95&nbsp;% d'origine végétale, sans sulfate, silicone ni parabène.</p>
                </div>
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-hand-raised','w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Éthique</h3>
                    <p class="text-sm opacity-80">Commerce équitable, transparence de la filière et cruelty‑free.</p>
                </div>
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-globe-alt','w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Durabilité</h3>
                    <p class="text-sm opacity-80">Emballages recyclables et bilan carbone compensé à 100&nbsp;%.</p>
                </div>
                <div class="card bg-base-100 shadow p-6">
                    @svg('heroicon-o-sparkles','w-10 h-10 mx-auto mb-4 text-primary')
                    <h3 class="font-semibold mb-2">Innovation</h3>
                    <p class="text-sm opacity-80">Recherche continue d'actifs botanique brevetés pour des résultats visibles.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- HISTOIRE / TIMELINE --------------------------------------------------}}
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-3xl font-bold text-center mb-12">Quelques dates clés</h2>
            <ul class="timeline timeline-vertical">
                @foreach(config()->array('project.timelines') as $timeline)
                    <li class="my-2">
                        <div class="timeline-start">{{$timeline['year']}}</div>
                        <div class="timeline-middle">@svg('heroicon-o-light-bulb','w-5 h-5 text-primary')</div>
                        <div class="timeline-end mb-10 lg:mb-0">
                            <h3 class="font-semibold">{{str($timeline['title'])->toHtmlString()}}</h3>
                            <p class="text-sm opacity-80">{{str($timeline['description'])->toHtmlString()}}</p>
                        </div>
                        <hr/>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ÉQUIPE ---------------------------------------------------------------}}
    <section class="py-16 bg-base-200">
        <div class="container mx-auto px-4 text-center space-y-10">
            <h2 class="text-3xl font-bold">Une équipe passionnée</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($teams as $team)
                    <div class="card bg-base-100 shadow hover:shadow-lg transition">
                        <figure><img src="{{ $team->photo_url }}" alt="{{ $team->name }}" class="h-56 w-full object-cover" /></figure>
                        <div class="card-body">
                            <h3 class="font-semibold">{{ $team->name }}</h3>
                            <p class="text-sm opacity-70">{{ $team->role }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CALL TO ACTION -------------------------------------------------------}}
    <livewire:newsletter-form/>
@endsection
