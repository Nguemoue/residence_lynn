@extends('layouts.frontend')

@section('title', 'Réservation #' . $booking->id . ' – ' . config('app.name'))
@section('meta-description', 'Consultez les détails de votre réservation pour ' . $booking->accommodation->code . ' à Kribi, incluant les dates, services et commodités.')

@section('content')
    <!-- Including GSAP, Swiper, and Alpine.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- HERO Section -->
    <section class="hero min-h-[70vh] bg-cover bg-center relative overflow-hidden"
             style="background-image: url('{{ $booking->accommodation->cover_image_url ?? $booking->accommodation->type->cover_image_url }}');">
        <div class="hero-overlay bg-black/70 absolute inset-0"></div>
        <div class="hero-content text-center text-neutral-content relative z-10">
            <div class="max-w-3xl mx-auto px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg animate-fade-in">
                    Réservation #{{ $booking->id }}
                </h1>
                <p class="text-lg md:text-xl opacity-90 mb-8 animate-slide-up">
                    Votre séjour à {{ $booking->accommodation->code }} est confirmé ! Découvrez les détails ci-dessous.
                </p>
                <a href="#booking-details" class="btn btn-primary btn-lg animate-bounce-in">Voir les détails</a>
            </div>
        </div>
    </section>

    <!-- Booking Details Section -->
    <section id="booking-details" class="py-20 bg-gradient-to-b from-base-100 to-base-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-primary mb-12 animate-fade-in">Détails de votre réservation</h2>
            <div x-data="{ showServices: false, showAmenities: false }" class="bg-base-200 rounded-xl shadow-2xl overflow-hidden opacity-0"
                 data-gsap="fade-up" data-delay="0.2">
                <div class="flex flex-col lg:flex-row">
                    <!-- Accommodation Image Carousel -->
                    <div class="lg:w-1/2 relative">
                        <div class="swiper booking-swiper h-[400px]">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ $booking->accommodation->cover_image_url ?? $booking->accommodation->accommodationType->cover_image_url }}"
                                         alt="{{ $booking->accommodation->code }}"
                                         class="w-full h-full object-cover">
                                </div>
                                @if($booking->accommodation->gallery)
                                    @foreach($booking->accommodation->gallery as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image }}"
                                                 alt="{{ $booking->accommodation->code }} - Image"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <!-- Booking Information -->
                    <div class="lg:w-1/2 p-8">
                        <h3 class="text-3xl font-bold text-primary mb-4">{{ $booking->accommodation->code }}</h3>
                        <p class="text-base-content opacity-80 mb-6">
                            Type: {{ $booking->accommodation->accommodationType->name }}
                        </p>
                        <div class="space-y-4">
                            <p><span class="font-semibold">Réservation #:</span> {{ $booking->id }}</p>
                            <p><span class="font-semibold">Date d'arrivée:</span> {{ $booking->start_date->format('d/m/Y') }}</p>
                            <p><span class="font-semibold">Date de départ:</span> {{ $booking->end_date->format('d/m/Y') }}</p>
                            <p><span class="font-semibold">Nombre de personnes:</span> {{ $booking->guest_number }}</p>
                            <p><span class="font-semibold">Statut:</span>
                                <span class="badge {{ $booking->status === 'pending' ? 'badge-warning' : ($booking->status === 'confirmed' ? 'badge-success' : 'badge-error') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                            <p><span class="font-semibold">Nom:</span> {{ $booking->name }}</p>
                            <p><span class="font-semibold">Email:</span> {{ $booking->email }}</p>
                            <p><span class="font-semibold">Téléphone:</span> {{ $booking->phone }}</p>
                        </div>

                        <!-- Toggle Services -->
                        @if($booking->accommodation->services->count())
                            <div class="mt-6">
                                <button @click="showServices = !showServices"
                                        class="btn btn-ghost btn-sm mb-2"
                                        :class="{ 'btn-active': showServices }">
                                    <span x-text="showServices ? 'Masquer les services' : 'Voir les services inclus'"></span>
                                </button>
                                <div x-show="showServices"
                                     x-transition:enter="transition ease-out duration-500"
                                     x-transition:enter-start="opacity-0 max-h-0"
                                     x-transition:enter-end="opacity-100 max-h-[500px]"
                                     x-transition:leave="transition ease-in duration-300"
                                     x-transition:leave-start="opacity-100 max-h-[500px]"
                                     x-transition:leave-end="opacity-0 max-h-0">
                                    <ul class="list-disc list-inside text-sm opacity-80 space-y-1">
                                        @foreach($booking->accommodation->services as $service)
                                            <li>{{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Toggle Amenities -->
                        @if(\Illuminate\Support\Collection::wrap($booking->accommodation->amenities)->count())
                            <div class="mt-6">
                                <button @click="showAmenities = !showAmenities"
                                        class="btn btn-ghost btn-sm mb-2"
                                        :class="{ 'btn-active': showAmenities }">
                                    <span x-text="showAmenities ? 'Masquer les commodités' : 'Voir les commodités'"></span>
                                </button>
                                <div x-show="showAmenities"
                                     x-transition:enter="transition ease-out duration-500"
                                     x-transition:enter-start="opacity-0 max-h-0"
                                     x-transition:enter-end="opacity-100 max-h-[500px]"
                                     x-transition:leave="transition ease-in duration-300"
                                     x-transition:leave-start="opacity-100 max-h-[500px]"
                                     x-transition:leave-end="opacity-0 max-h-0">
                                    <ul class="list-disc list-inside text-sm opacity-80 space-y-1">
                                        @foreach(\Illuminate\Support\Collection::wrap($booking->accommodation->acommodationType)->amenities as $amenity)
                                            <li>{{ $amenity->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="mt-6 flex flex-wrap gap-4">
                            <a href="{{ route('accommodation_types.show', $booking->accommodation->accommodationType->slug) }}"
                               class="btn btn-outline btn-primary btn-sm hover:scale-105 transition-transform">
                                Voir le type de logement
                            </a>
                            @if($booking->status === 'pending')
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm hover:scale-105 transition-transform"
                                            onclick="return confirm('Voulez-vous vraiment annuler cette réservation ?')">
                                        Annuler la réservation
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Animations and Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // Hero animations
            gsap.from('.hero-content h1', { opacity: 0, y: 50, duration: 1, ease: 'power3.out' });
            gsap.from('.hero-content p', { opacity: 0, y: 50, duration: 1, delay: 0.3, ease: 'power3.out' });
            gsap.from('.hero-content .btn', { opacity: 0, y: 50, duration: 1, delay: 0.6, ease: 'power3.out' });

            // Booking details animation
            gsap.to('.bg-base-200', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.bg-base-200',
                    start: 'top 80%',
                }
            });

            // Initialize Swiper
            new Swiper('.booking-swiper', {
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
    </script>

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

        .bg-base-200 {
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
@endsection
