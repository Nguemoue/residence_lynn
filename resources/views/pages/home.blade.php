{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.frontend')

@section('title', config('app.name'))

@section('content')

    {{-- HERO --}}
    <section class="hero min-h-[80vh] bg-cover bg-center hero-image animate__animated animate__fadeIn"
             style="background-image: url('{{ asset('assets/images/banner_price.jpg') }}');">
        <div class="hero-overlay bg-black/60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-2xl">
                <h1 class="mb-6 text-5xl font-bold">Séjournez à Kribi avec Confort et Sérénité</h1>
                <p class="mb-6 text-lg">
                    Studios, chambres ou appartements meublés, profitez d’une expérience authentique et reposante au cœur de la ville balnéaire du Cameroun.
                </p>
                <a href="#accommodations" class="btn btn-primary">Réservez dès maintenant</a>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-20 bg-base-200 animate__animated animate__fadeInUp">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary">Pourquoi choisir Kribi pour vos séjours ?</h2>
                <p class="text-base-content max-w-4xl mx-auto mt-4">
                    Kribi, joyau côtier du Cameroun, est reconnu pour ses plages paradisiaques, ses cascades mythiques et son hospitalité légendaire. Que vous soyez en quête de repos, d'aventure ou de découvertes culinaires, Kribi est votre destination idéale.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-home-modern', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Logements équipés</h3>
                    <p class="text-sm">Studios, chambres ou appartements avec tout le nécessaire pour un séjour paisible.</p>
                </div>
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-map-pin', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Localisation idéale</h3>
                    <p class="text-sm">À quelques pas des plages, commerces et lieux d’activités à Kribi.</p>
                </div>
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-lock-closed', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Sécurité garantie</h3>
                    <p class="text-sm">Nos logements sont situés dans des quartiers calmes et surveillés.</p>
                </div>
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg('heroicon-o-clock', 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Réservation rapide</h3>
                    <p class="text-sm">Choisissez votre logement, sélectionnez vos dates, et réservez en quelques clics.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section id="gallery" class="py-20 bg-base-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary">Aperçu de nos hébergements</h2>
                <p class="text-base-content max-w-2xl mx-auto mt-4">
                    Immergez-vous dans l’ambiance chaleureuse et apaisante de nos logements à travers cette galerie.
                </p>
            </div>
            <div class="owl-carousel owl-theme">
                <div><img src="{{ asset('assets/images/room1.jpg') }}" class="rounded-lg shadow-md"></div>
                <div><img src="{{ asset('assets/images/room2.jpg') }}" class="rounded-lg shadow-md"></div>
                <div><img src="{{ asset('assets/images/room3.jpg') }}" class="rounded-lg shadow-md"></div>
                <div><img src="{{ asset('assets/images/room4.jpg') }}" class="rounded-lg shadow-md"></div>
            </div>
        </div>
    </section>

    {{-- Accommodations Section --}}
    <section id="accommodations" class="py-20 bg-base-200 animate__animated animate__fadeInUp">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary">Nos types de logements</h2>
                <p class="text-base-content max-w-2xl mx-auto mt-4">
                    Découvrez notre sélection de logements prêts à vous accueillir à Kribi. Chaque type a été pensé pour répondre à des besoins spécifiques.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($accommodationTypes??[] as $type)
                    <div class="card bg-base-100 shadow">
                        <figure>
                            <img src="{{ $type->cover_image_url }}" alt="{{ $type->name }}" class="w-full h-auto object-cover">
                        </figure>
                        <div class="card-body">
                            <h3 class="card-title text-lg font-semibold">{{ $type->name }}</h3>
                            <p class="text-sm line-clamp-3">{!!  $type->description  !!}</p>
                            <a href="{{ route('accommodation_types.show', $type->slug) }}" class="btn btn-sm btn-primary mt-4">Voir les {{ $type->name }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Services Section --}}
    <section id="services" class="py-20 bg-base-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary">Services inclus</h2>
                <p class="text-base-content max-w-2xl mx-auto mt-4">
                    Pour rendre votre séjour encore plus agréable, nous vous offrons une gamme de services sur-mesure.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($services??[] as $service)
                    <div class="card bg-base-100 shadow text-center p-6">
                        <h3 class="text-lg font-semibold mb-2">{{ $service->name }}</h3>
                        <p class="text-sm">{{ $service->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Témoignages --}}
    <section id="testimonials" class="py-20 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary">Ils ont séjourné chez nous</h2>
                <p class="text-base-content max-w-2xl mx-auto mt-4">
                    Découvrez ce que nos visiteurs disent de leur passage dans nos hébergements.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($testimonials??[] as $testimonial)
                    <div class="bg-base-100 p-6 rounded shadow">
                        <p class="italic">“{{ $testimonial->content }}”</p>
                        <p class="font-bold mt-4">— {{ $testimonial->author }}, {{ $testimonial->location }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <x-frontend.faq-section :faqs="$faqs"/>

    {{-- Newsletter --}}
    {{-- <livewire:newsletter-form /> --}}

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    responsive: {
                        0: { items: 1 },
                        600: { items: 2 },
                        1000: { items: 3 }
                    }
                });
            });
        </script>
    @endpush

@endsection
