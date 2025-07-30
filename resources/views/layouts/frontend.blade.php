<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Noveden – Beauté naturelle')</title>
    <meta name="description"
          content="@yield('meta-description', 'Cosmétiques capillaires & compléments naturels Noveden')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Fonts : Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <script>
        // Cache le loader après le chargement complet
        window.addEventListener('load', () => {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.classList.add('opacity-0');
                setTimeout(() => loader.remove(), 500);
            }
        });
    </script>
    {{-- Vite (Tailwind 4 + daisyUI) --}}
    @vite(['resources/css/app.css', 'resources/js/frontend.js'])
    @livewireStyles
    @stack('styles')
    <style>
        .hero-image{
            background-image: url('{{ asset('assets/images/room2.jpg') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: -10% 0;
            aspect-ratio: 16/7;
        }
    </style>
</head>

<body class="antialiased">

{{-- Loader plein écran --}}
<div id="page-loader"
     class="fixed inset-0 z-[999] flex items-center justify-center bg-base-100 transition-opacity duration-500">
    <span class="loading loading-spinner loading-xl text-primary"></span>
</div>

{{-- Top-banner & Navbar --}}
@include('partials.top-banner')
{{--@include('partials.navbar')--}}
<livewire:navbar />
<main>

    @yield('content')
</main>

@includeIf('partials.footer')
@livewireScriptConfig
{{-- Scripts supplémentaires --}}
@stack('scripts')
</body>
</html>
