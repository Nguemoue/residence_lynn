@extends('layouts.frontend')

@section('title', 'Types de logements – ' . config('app.name'))
@section('meta-description', 'Explorez tous les types de logements disponibles à Kribi : studios, chambres, appartements. Comparez les services, commodités et disponibilités.')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
@endpush
@section('content')
    <!-- Including GSAP, Swiper, and Alpine.js -->

    <!-- HERO Section -->
    <section class="hero min-h-[60vh] bg-cover bg-center"
             style="background-image: url({{ asset('assets/images/room2.jpg') }});">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content relative z-10">
            <div class="max-w-3xl mx-auto px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg animate-fade-in">Quel logement pour votre séjour à Kribi ?</h1>
                <p class="text-lg md:text-xl opacity-90 mb-8 animate-slide-up">Découvrez une sélection unique de logements offrant confort, intimité et sérénité pour une expérience inoubliable.</p>
                <a href="#accommodations" class="btn btn-primary btn-lg animate-bounce-in">Explorer maintenant</a>
            </div>
        </div>
    </section>

    <!-- Accommodation Types Section -->
    <section id="accommodations" class="py-20 bg-gradient-to-b from-base-100 to-base-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-primary mb-12 animate-fade-in">Nos Types de Logements</h2>
            <div class="space-y-12">
                @foreach($accommodationTypes as $index => $type)
                    <div x-data="{ isOpen: false }" class="accommodation-card bg-base-200 rounded-xl  transition-all duration-200 hover:shadow-3xl opacity-0"
                         data-gsap="fade-up" data-delay="{{ $index * 0.1 }}">
                        <!-- Accommodation Type Header -->
                        <div class="flex flex-col lg:flex-row">
                            <!-- Image Carousel -->
                            <div class="lg:w-1/2 relative">
                                <div class="swiper accommodation-swiper h-[400px]">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="{{ $type->cover_image_url }}" alt="{{ $type->name }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <!-- Add more images if available -->
                                        @if($type->gallery_urls)
                                            @foreach($type->gallery_urls as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ $image }}" alt="{{ $type->name }} - Image"
                                                         class="w-full h-full object-cover">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <!-- Swiper Navigation -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="lg:w-1/2 p-8">
                                <h3 class="text-3xl font-bold text-primary mb-4">{{ $type->name }}</h3>
                                <p class="text-base-content opacity-80 mb-6">{!! $type->description !!}</p>

                                <!-- Services -->
                                @if($type->services->count())
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-lg text-base-content">Services inclus :</h4>
                                        <ul class="list-disc list-inside text-sm opacity-80 space-y-1">
                                            @foreach($type->services as $service)
                                                <li>{{ $service->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Amenities -->
                                @if($type->amenities)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-lg text-base-content">Commodités :</h4>
                                        <ul class="list-disc list-inside text-sm opacity-80 space-y-1">
                                            @foreach($type->amenities as $amenity)
                                                <li>{{ $amenity }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Availability -->
                                <p class="text-base font-semibold mb-6">
                                    <span class="text-primary">{{ $type->accommodations_count }}</span> logement(s) disponible(s)
                                </p>

                                <!-- Actions -->
                                <div class="flex flex-wrap gap-4">
                                    <a href="{{ route('accommodation_types.show', $type) }}" class="btn btn-outline btn-secondary btn-sm hover:scale-105 transition-transform">Details</a>
                                    <a href="{{ route('checkout.create', $type) }}" class="btn btn-outline btn-primary btn-sm hover:scale-105 transition-transform">Reservez</a>
                                    <button @click="isOpen = !isOpen"
                                            class="btn btn-ghost btn-sm"
                                            :class="{ 'btn-active': isOpen }">
                                        <span x-text="isOpen ? 'Masquer les logements' : 'Voir les logements disponibles'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Available Accommodations (Collapsible with Alpine.js) -->
                        <div x-show="isOpen"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 max-h-0"
                             x-transition:enter-end="opacity-100 max-h-[1000px]"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 max-h-[1000px]"
                             x-transition:leave-end="opacity-0 max-h-0"
                             class="accommodations-list p-8 bg-base-100 border-t border-base-300 overflow-hidden">
                            <h4 class="text-xl font-semibold text-primary mb-6">Logements disponibles</h4>
                            @if($type->accommodations->count())
                                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($type->accommodations as $accommodation)
                                        <div class="card bg-base-200 shadow-md hover:shadow-lg transition-all duration-300">
                                            <figure>
                                                <img src="{{ $accommodation->image_url ?? $type->cover_image_url }}"
                                                     alt="{{ $accommodation->code }}"
                                                     class="w-full h-auto object-cover">
                                            </figure>
                                            <div class="card-body p-4">
                                                <h5 class="text-lg font-semibold">{{ $accommodation->code }}</h5>
                                                <p class="text-sm opacity-80">{!!   $accommodation->description !!}</p>
                                                <p class="text-sm font-semibold mt-2">
                                                    Prix : {{ $accommodation->accommodationType->price_per_night }} XAF/nuit
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-base-content opacity-80">Aucun logement disponible pour ce type.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('scripts')

        <!-- JavaScript for GSAP and Swiper -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                gsap.registerPlugin(ScrollTrigger);

                // Hero animations
                gsap.from('.hero-content h1', { opacity: 0, y: 50, duration: 1, ease: 'power3.out' });
                gsap.from('.hero-content p', { opacity: 0, y: 50, duration: 1, delay: 0.3, ease: 'power3.out' });
                gsap.from('.hero-content .btn', { opacity: 0, y: 50, duration: 1, delay: 0.6, ease: 'power3.out' });

                // Card animations
                document.querySelectorAll('.accommodation-card').forEach((card, index) => {
                    gsap.to(card, {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        delay: card.dataset.delay || 0,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 80%',
                        }
                    });
                });

                // Initialize Swiper
                document.querySelectorAll('.accommodation-swiper').forEach(swiperEl => {
                    new Swiper(swiperEl, {
                        loop: true,
                        autoplay: {
                            delay: 3000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        }
                    });
                });
            });
        </script>

    @endpush

    @push('styles')
        <!-- Custom CSS -->
        <style>
            .animate-fade-in {
                animation: fadeIn 1s ease-out forwards;
            }

            .animate-slide-up {
                animation: slideUp 1s ease-out forwards;
            }

            .animate-bounce-in {
                animation: bounceIn 1s ease-out forwards;
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideUp {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes bounceIn {
                0% { opacity: 0; transform: scale(0.8); }
                60% { opacity: 1; transform: scale(1.1); }
                100% { transform: scale(1); }
            }

            .accommodation-card {
                transform: translateY(50px);
            }

            .swiper {
                width: 100%;
                height: 100%;
            }

            .swiper-slide img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }

            .swiper-button-prev,
            .swiper-button-next {
                color: #fff;
                background: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .swiper-pagination-bullet {
                background: #fff;
                opacity: 0.7;
            }

            .swiper-pagination-bullet-active {
                background: #3b82f6;
                opacity: 1;
            }
        </style>
    @endpush
@endsection
