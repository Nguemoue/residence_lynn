@extends('layouts.frontend')

@section('title', 'Galerie – ' . config('app.name'))
@section('meta-description', 'Explorez notre galerie de photos des hébergements à Kribi avec des images magnifiques et des descriptions personnalisées.')

@push('styles')
    <!-- lightGallery CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/css/lightgallery.min.css" integrity="sha512-QMCloGTsG2vNSnHcsxYTapI6pFQNnUP6yNizuLL5Wh3ha6AraI6HrJ3ABBaw6SIUHqlSTPQDs/SydiR98oTeaQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS for Gallery -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/lightgallery.min.js" integrity="sha512-n02TbYimj64qb98ed5WwkNiSw/i9Xlvv4Ehvhg0jLp3qMAMWCYUHbOMbppZ0vimtyiyw9NqNqxUZC4hq86f4aQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                        @foreach ($galleries as $gallery)
                    {
                        src: '{{ $gallery->image_url }}',
                        thumb: '{{ $gallery->image_url }}',
                        subHtml: '<h4>{{ $gallery->name }}</h4>'
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
             style="background-image: url({{ asset('assets/images/room1.jpg') }});">
        <div class="hero-overlay bg-black/70 absolute inset-0"></div>
        <div class="hero-content text-center text-neutral-content relative z-10">
            <div class="max-w-3xl mx-auto px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg text-lyan-gray">
                    Galerie des Hébergements
                </h1>
                <p class="text-lg md:text-xl opacity-90 mb-8">
                    Découvrez nos plus belles images de Kribi.
                </p>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery-section" class="py-20 bg-gradient-to-b from-base-100 to-base-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-primary mb-12">Nos Photos</h2>
            <div class="gallery-grid">
                @foreach ($galleries as $gallery)
                    <div class="gallery-item">
                        <a href="{{ $gallery->image_url }}" data-sub-html="<h4>{{ $gallery->name }}</h4>">
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->name }}">
                        </a>
                        <span class="gallery-caption">{{ $gallery->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
