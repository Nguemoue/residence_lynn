@extends('layouts.frontend')

@section('title', '{{ $type->name }} – ' . config('app.name'))
@section('meta-description', 'Découvrez tous les détails du type de logement {{ $type->name }} à Kribi, avec services, commodités et dates de réservation.')

@push('styles')
    <!-- lightGallery CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lightgallery-bundle.min.css" />

    <!-- Custom CSS -->
    <style>
        .gallery-grid {
            column-count: 1;
            column-gap: 1rem;
        }
        @media (min-width: 640px) {
            .gallery-grid { column-count: 2; }
        }
        @media (min-width: 768px) {
            .gallery-grid { column-count: 3; }
        }
        @media (min-width: 1024px) {
            .gallery-grid { column-count: 4; }
        }
        .gallery-item {
            display: inline-block;
            margin-bottom: 1rem;
            width: 100%;
            overflow: hidden;
            border-radius: 0.5rem;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }
        .gallery-item img:hover {
            transform: scale(1.05);
        }
        .gallery-caption {
            display: block;
            text-align: center;
            font-size: 0.875rem;
            color: #666666;
            padding-top: 0.5rem;
        }
    </style>
@endpush

@push('scripts')
    <!-- lightGallery JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/lightgallery.min.js"></script>

    <!-- lightGallery Lightbox Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lightGallery(document.getElementById('gallery-section'), {
                speed: 500,
                download: false,
                zoom: true,
                actualSize: false,
                thumbnail: false,
                mobileSettings: {
                    controls: true,
                    showCloseIcon: true
                },
                dynamic: true,
                dynamicEl: [
                        @foreach ($type->accommodations as $accommodation)
                    {
                        src: '{{ $accommodation->cover_image_url }}',
                        thumb: '{{ $accommodation->cover_image_url }}',
                        subHtml: '<h4>{{ $accommodation->code }}</h4>'
                    },
                    @endforeach
                ]
            });
        });
    </script>
@endpush

@section('content')
    <!-- HERO Section -->
    <section class="hero min-h-[60vh] bg-cover bg-center relative overflow-hidden"
             style="background-image: url({{ asset($type->cover_image_url) }});">
        <div class="hero-overlay bg-black/70 absolute inset-0"></div>
        <div class="hero-content text-center text-neutral-content relative z-10">
            <div class="max-w-3xl mx-auto px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg text-lyan-gray">
                    {{ $type->name }}
                </h1>
                <p class="text-lg md:text-xl opacity-90 mb-8">
                    Un logement pensé pour le confort et la sérénité à Kribi.
                </p>
                <a href="{{route('checkout.create',['accommodationType' => $type])}}" class="btn btn-primary btn-lg">Reservez maintenant</a>
            </div>
        </div>
    </section>

    <!-- Details Section -->
    <section id="details-section" class="py-20 bg-base-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-10 items-start">
                <!-- Description and Features -->
                <div>
                    <img src="{{ ($type->cover_image_url) }}" alt="{{ $type->name }}"
                         class="rounded-lg shadow w-full mb-6">
                    <p class="text-base-content text-justify leading-relaxed">{!! $type->description !!}</p>

                    <!-- Services -->
                    @if($type->services->count())
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg mb-2 text-lyan-gray">Services inclus :</h3>
                            <ul class="list-disc list-inside text-sm opacity-80">
                                @foreach($type->services as $service)
                                    <li>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Amenities -->
                    @if(count($type->amenities))
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg mb-2 text-lyan-gray">Commodités :</h3>
                            <ul class="list-disc list-inside text-sm opacity-80">
                                @foreach($type->amenities as $amenity)
                                    <li>{{ $amenity->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Available Accommodations Gallery -->
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-lyan-gray">Logements disponibles ({{ $type->accommodations->count() }})</h2>
                    <div id="gallery-section" class="gallery-grid">
                        @foreach ($type->accommodations as $accommodation)
                            <div class="gallery-item">
                                <a href="{{ $accommodation->cover_image_url }}" data-sub-html="<h4>{{ $accommodation->code }}</h4>">
                                    <img src="{{ $accommodation->cover_image_url }}" alt="{{ $accommodation->code }}"
                                         class="w-full h-48 object-cover">
                                </a>
                                <span class="gallery-caption">{{ $accommodation->code }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
