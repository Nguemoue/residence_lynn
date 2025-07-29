{{-- resources/views/livewire/blog/list-posts.blade.php --}}
<div class="space-y-16">

    {{-- FILTRES ----------------------------------------------------------------}}
    <div class="text-center">
        <div class="flex flex-wrap justify-center gap-3">
            <button wire:click="$set('category', null)"
                    class="btn btn-sm btn-outline {{ $category ? '' : 'btn-active' }}">
                Tous les articles
            </button>
            @foreach($this->categories as $cat)
                <button wire:key="cat-{{ $cat->id }}"
                        wire:click="$set('category', '{{ $cat->slug }}')"
                        class="btn btn-sm btn-outline {{ $category === $cat->slug ? 'btn-active' : '' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- ARTICLE VEDETTE (uniquement page 1) ----------------------------------}}
    @if($posts->currentPage() === 1 && $posts->count())
        @php($featured = $posts->first())
        <article class="grid lg:grid-cols-2 gap-10 items-center">
            <figure class="relative group">
                <img src="{{ $featured->cover_image_url }}" alt="{{ $featured->title }}"
                     class="w-full h-72 lg:h-96 object-cover rounded-box" />
                <span class="absolute top-4 left-4 badge badge-primary">Article vedette</span>
            </figure>

            <div class="space-y-4">
                <div class="text-sm opacity-70 flex items-center gap-2">
                    <span class="badge badge-outline">{{ $featured->category->name }}</span>
                    •
                    <time datetime="{{ $featured->published_at->toDateString() }}">
                        {{ $featured->published_at->translatedFormat('d F Y') }}
                    </time>
                </div>

                <h2 class="text-2xl font-bold">
                    <a href="{{ route('blog.show', $featured) }}" class="link-hover">
                        {{ $featured->title }}
                    </a>
                </h2>

                <p class="opacity-80">{{ Str::limit($featured->excerpt, 160) }}</p>
                <div class="flex items-center gap-4 text-xs opacity-70">
                    <div class="flex">
                        @svg('heroicon-o-clock','w-4 h-4')  &nbsp;{{ $featured->read_time }} min
                    </div>
                    <div class="flex">
                    @svg('heroicon-o-eye','w-4 h-4') &nbsp;{{ $featured->views }}
                    </div>
                </div>

                <a href="{{ route('blog.show', $featured) }}" class="btn btn-primary">Lire l’article</a>
            </div>
        </article>
    @endif

    {{-- GRILLE ARTICLES ------------------------------------------------------}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8"
         wire:loading.class="opacity-50 transition">
        @foreach($posts->skip($posts->currentPage() === 1 ? 1 : 0) as $post)
            <article wire:key="post-{{ $post->id }}" class="card bg-base-100 shadow">
                <figure class="relative group">
                    <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}"
                         class="w-full h-52 object-cover rounded-t-box" />
                    <a href="{{ route('blog.show', $post) }}"
                       class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0
                              group-hover:opacity-100 transition rounded-t-box">
                        @svg('heroicon-o-arrow-right','w-8 h-8 text-base-100')
                    </a>
                </figure>

                <div class="card-body">
                    <div class="text-xs opacity-70 flex items-center gap-2">
                        <span class="badge badge-outline">{{ $post->category->name }}</span>
                        •
                        <time datetime="{{ $post->published_at->toDateString() }}">
                            {{ $post->published_at->translatedFormat('d M Y') }}
                        </time>
                    </div>

                    <h3 class="font-semibold">
                        <a href="{{ route('blog.show', $post) }}" class="link-hover">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <p class="text-sm opacity-80 line-clamp-3">{{ $post->excerpt }}</p>

                    <div class="flex items-center gap-3 text-xs opacity-70">
                        <div class="flex">
                            @svg('heroicon-o-clock','w-4 h-4')  &nbsp;{{ $featured->read_time }} min
                        </div>
                        <div class="flex">
                            @svg('heroicon-o-eye','w-4 h-4') &nbsp;{{ $featured->views }}
                        </div>

                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- BOUTON CHARGER PLUS --------------------------------------------------}}
    @if($posts->hasMorePages())
        <div class="text-center">
            <button wire:click="loadMore" wire:loading.attr="disabled" class="btn btn-outline">
                <span wire:loading wire:target="loadMore" class="loading loading-spinner mr-2"></span>
                Charger plus d'articles
            </button>
        </div>
    @endif
</div>
