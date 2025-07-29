{{-- resources/views/pages/blog/show.blade.php --}}
@extends('layouts.frontend')

@php /** @var \App\Models\Post $post */ @endphp

@section('title', $post->title . ' – ' . config('app.name'))
@section('meta-description', Str::limit($post->excerpt, 150))

@section('content')
    {{-- BARRE DE PROGRESSION LECTURE ----------------------------------------- --}}
    <div x-data="readingProgress()" class="fixed top-0 left-0 w-full h-1 bg-base-200 z-[60]">
        <div class="h-full bg-primary" :style="{width: progress + '%'}"></div>
    </div>

    {{-- BREADCRUMB ----------------------------------------------------------- --}}
    <section class="bg-base-200 py-3">
        <div class="container mx-auto px-4">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li>{{ $post->title }}</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- ARTICLE ---------------------------------------------------------------- --}}
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4 grid lg:grid-cols-12 gap-12">

            {{-- CONTENU PRINCIPAL ------------------------------------------------ --}}
            <article class="lg:col-span-8 space-y-10">

                {{-- EN‑TÊTE --}}
                <header class="space-y-6">
                    <div class="flex flex-wrap items-center gap-2 text-sm opacity-70">
                        <span class="badge badge-outline">{{ $post->category->name }}</span>
                        •
                        <time datetime="{{ $post->published_at->toDateString() }}">
                            {{ $post->published_at->translatedFormat('d F Y') }}
                        </time>
                    </div>

                    <h1 class="text-4xl font-bold leading-tight">{{ $post->title }}</h1>

                    <div class="flex flex-wrap items-center gap-4 text-sm opacity-70">
                        @svg('heroicon-o-clock','w-4 h-4') {{ $post->read_time }} min
                        @svg('heroicon-o-eye','w-4 h-4') {{ $post->views }} vues
                    </div>

                    {{-- AUTEUR --}}
                    <div class="flex items-center gap-4">
                        <img src="{{ $post->author->avatar }}" alt="{{ $post->author->name }}"
                             class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="font-semibold">{{ $post->author->name }}</h4>
                            <span class="text-sm opacity-70">{{ $post->author->title ?? 'Auteur' }}</span>
                        </div>
                    </div>
                </header>

                {{-- IMAGE DE COUVERTURE --}}

                <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}" class="rounded-box w-full h-96 object-cover">

                {{-- CONTENU HTML (md→html mis en base) --}}
                {!! str($post->content)->sanitizeHtml() !!}

                {{-- TAGS --}}
                @if($post->tags->isNotEmpty())
                    <div>
                        <h5 class="font-semibold mb-2">Tags :</h5>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <span class="badge badge-outline">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- PARTAGE SOCIAL (sans likes) --}}
                <div class="space-y-2">
                    <h5 class="font-semibold">Partager :</h5>
                    <div class="flex gap-3">
                        <a href="#" class="btn btn-sm btn-ghost" aria-label="Facebook">
                            @svg('heroicon-o-facebook','w-5 h-5')
                        </a>
                        <a href="#" class="btn btn-sm btn-ghost" aria-label="X">
                            @svg('heroicon-o-x-circle','w-5 h-5')
                        </a>
                        <a href="#" class="btn btn-sm btn-ghost" aria-label="LinkedIn">
                            @svg('heroicon-o-link','w-5 h-5')
                        </a>
                        <button class="btn btn-sm btn-ghost" x-data="{copied:false}" @click="navigator.clipboard.writeText(window.location.href);copied=true;setTimeout(()=>copied=false,2000)">
                            <span x-show="!copied">@svg('heroicon-o-document-duplicate','w-5 h-5')</span>
                            <span x-show="copied" class="text-xs">Lien copié !</span>
                        </button>
                    </div>
                </div>
            </article>

            {{-- SIDEBAR ---------------------------------------------------------- --}}
            <aside class="lg:col-span-4 space-y-8" x-data="{openToc:true}">
                {{-- Sommaire --}}
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <button class="font-semibold flex items-center justify-between w-full" @click="openToc=!openToc">
                            <span>Sommaire</span>
                            <span x-text="openToc ? '–' : '+'"></span>
                        </button>
                        <nav x-show="openToc" x-transition class="mt-4 space-y-2 text-sm">
                            @foreach($toc as $anchor => $text)
                                <a href="#{{ $anchor }}" class="link block">{{ $text }}</a>
                            @endforeach
                        </nav>
                    </div>
                </div>

                {{-- Produits recommandés --}}
                @if($relatedProducts->isNotEmpty())
                    <div class="card bg-base-100 shadow">
                        <div class="card-body space-y-4">
                            <h4 class="font-semibold">Produits recommandés</h4>
                            @foreach($relatedProducts as $rp)
                                <div class="flex gap-3">
                                    <img src="{{ $rp->cover_image }}" alt="{{ $rp->name }}" class="w-16 h-16 object-cover rounded">
                                    <div class="flex-1">
                                        <h5 class="text-sm font-semibold line-clamp-2">{{ $rp->name }}</h5>
                                        <p class="text-primary text-sm font-medium">{{ format_price($rp->effective_price) }}</p>
                                        <a href="{{ route('products.show', $rp) }}" class="link text-xs">Voir le produit</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Articles récents --}}
                @if($recentPosts->isNotEmpty())
                    <div class="card bg-base-100 shadow">
                        <div class="card-body space-y-4">
                            <h4 class="font-semibold">Articles récents</h4>
                            @foreach($recentPosts as $recent)
                                <div class="flex gap-3">
                                    <img src="{{ $recent->cover_image_url }}" alt="{{ $recent->title }}" class="w-16 h-16 object-cover rounded">
                                    <div class="flex-1">
                                        <a href="{{ route('blog.show', $recent) }}" class="link line-clamp-2 text-sm font-semibold">{{ $recent->title }}</a>
                                        <span class="text-xs opacity-70">{{ $recent->published_at->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Newsletter --}}
                <livewire:newsletter-form design="2"/>
            </aside>
        </div>
    </section>

    {{-- ARTICLES SIMILAIRES -------------------------------------------------- --}}
    @if($related->isNotEmpty())
        <section class="py-20 bg-base-200">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold text-center mb-10">Articles similaires</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($related as $rel)
                        <a href="{{ route('blog.show', $rel) }}" class="card bg-base-100 shadow group">
                            <figure class="relative">
                                <img src="{{ $rel->cover_image_url }}" alt="{{ $rel->title }}" class="h-40 w-full object-cover rounded-t-box">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition rounded-t-box flex items-center justify-center">
                                    @svg('heroicon-o-arrow-right','w-8 h-8 text-base-100')
                                </div>
                            </figure>
                            <div class="card-body">
                                <h3 class="font-semibold mb-1 line-clamp-2">{{ $rel->title }}</h3>
                                <span class="text-xs opacity-70">{{ $rel->published_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        function readingProgress(){
            return {
                progress: 0,
                update(){
                    const total = document.body.scrollHeight - window.innerHeight;
                    this.progress = Math.round((window.scrollY / total) * 100);
                },
                init(){
                    this.update();
                    window.addEventListener('scroll', () => this.update());
                }
            }
        }
    </script>
@endpush
