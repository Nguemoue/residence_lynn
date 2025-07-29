{{-- resources/views/pages/contact/create.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Contact – ' . config('app.name'))

@section('content')
    {{-- HERO ------------------------------------------------------------------}}
    <section class="hero min-h-[40vh] hero-image" >
        <div class="hero-overlay bg-black/60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h1 class="text-4xl font-bold mb-4">Nous contacter</h1>
                <p class="opacity-80">Besoin d'aide ? Notre équipe est là pour vous répondre.</p>
            </div>
        </div>
    </section>

    {{-- COORDONNÉES & FORMULAIRE ------------------------------------------------}}
    <section class="py-20 bg-base-100">
        <div class="container mx-auto px-4">
            {{-- Flash succès --}}
            @if(session('success'))
                <div class="alert alert-success shadow-lg mb-10" x-data="{show:true}" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition>
                    @svg('heroicon-o-check-circle','w-6 h-6')
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-12 items-start">
                {{-- Carte + Informations --}}
                <div class="space-y-8">
                    {{-- Google Map --}}
                    <div class="w-full h-64 rounded-box overflow-hidden shadow">
                        <iframe class="w-full h-full" loading="lazy"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.999391083523!2d2.2922926156746998!3d48.85837307928733!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fcd113f31d7%3A0xb912b7b0c7b76091!2sTour%20Eiffel!5e0!3m2!1sfr!2sfr!4v161555" allowfullscreen></iframe>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            @svg('heroicon-o-map-pin','w-6 h-6 text-primary')
                            <div>
                                <h4 class="font-semibold">Adresse</h4>
                                <p>{{config('project.about.address')}}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            @svg('heroicon-o-phone','w-6 h-6 text-primary')
                            <div>
                                <h4 class="font-semibold">Téléphone</h4>
                                <p>{{config('project.about.phone_number')}}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            @svg('heroicon-o-envelope','w-6 h-6 text-primary')
                            <div>
                                <h4 class="font-semibold">Email</h4>
                                <p>{{config('project.about.email')}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Formulaire --}}
                <form method="POST" action="{{ route('contact.store') }}" x-data="{loading:false}" @submit.prevent="loading=true; $el.submit()" class="space-y-6 w-full">
                    @csrf
                    <div>
                        <label class="label" for="name">
                            <span class="label-text">Nom</span>
                        </label>
                        <input type="text" id="name" name="name" class="input input-bordered w-full" required>
                    </div>

                    <div>
                        <label class="label" for="email">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" id="email" name="email" class="input input-bordered w-full" required>
                    </div>

                    <div>
                        <label class="label" for="subject">
                            <span class="label-text">Sujet</span>
                        </label>
                        <input type="text" id="subject" name="subject" class="input input-bordered w-full">
                    </div>

                    <div>
                        <label class="label" for="message">
                            <span class="label-text">Message</span>
                        </label>
                        <textarea id="message" name="message" rows="5" class="textarea textarea-bordered w-full" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full" :disabled="loading">
                        <span x-show="!loading">Envoyer</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <span class="loading loading-spinner"></span>
                            <span>Envoi...</span>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
