{{-- resources/views/livewire/home/featured-products.blade.php --}}
<div x-data="{cat:'all'}" class="space-y-10">

    {{-- Filtres catégories ------------------------------------------------ --}}
    @php
        $cats = $products->pluck('category')->unique('id');
    @endphp
    <div class="flex flex-wrap justify-center gap-3">
        <button class="btn btn-outline btn-sm"
                :class="cat==='all' && 'btn-active'"
                @click="cat='all'">
            Tous les produits
        </button>

        @foreach($cats as $cat)
            <button class="btn btn-outline btn-sm"
                    :class="cat==='{{ $cat->slug }}' && 'btn-active'"
                    @click="cat='{{ $cat->slug }}'">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>

    {{-- Grille produits --------------------------------------------------- --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $p)
            @php
                $isValidForCart = $p->isValidForCart();
                $stockMessage = $p->stock_message;
            @endphp

            <div x-show="(cat==='all') || cat=='{{ $p->category->slug }}'"
                 x-transition.duration.100ms
                 x-data="{
                    loading: false,
                    init() {
                        Livewire.on('cart:item-added', id => {
                            if (id == {{ $p->id }}) {
                                this.loading = false;
                            }
                        });
                    },
                    add() {
                        @if($isValidForCart)
                            this.loading = true;
                            $wire.addToCart({{ $p->id }});
                            setTimeout(() => { this.loading = false }, 1000);
                        @endif
                    }
                  }"
                 id="hp-prod-{{ $p->id }}"
                 wire:key="hp-{{ $p->id }}"
                 class="card bg-base-100 shadow-md overflow-hidden group">

                {{-- Image + overlay --}}
                <figure class="relative h-52">
                    <img src="{{ $p->cover_image_url }}" alt="{{ $p->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"/>

                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center gap-3
                                opacity-0 group-hover:opacity-100 transition">
                        {{-- Voir --}}
                        <a href="{{ route('products.show', $p) }}"
                           class="btn btn-circle btn-ghost text-base-100">
                            @svg('heroicon-o-eye', 'w-6 h-6')
                        </a>

                        {{-- Ajout rapide --}}
                        <button class="btn btn-circle btn-primary relative"
                                @click.prevent="add"
                                :disabled="loading || {{ $isValidForCart ? 'false' : 'true' }}">
                            <template x-if="loading">
                                <span class="loading loading-spinner loading-xs"></span>
                            </template>
                            <template x-if="!loading">
                                @svg('heroicon-o-shopping-cart', 'w-6 h-6')
                            </template>
                        </button>
                    </div>
                </figure>

                {{-- Infos --}}
                <div class="card-body">
                    <section>
                        <a href="{{route('products.show',['product' => $p])}}">
                            <div class="flex justify-between items-center text-xs font-medium mb-1">
                                <span class="badge badge-accent">{{ $p->is_featured ? 'Populaire' : 'Nouveau' }}</span>
                                @if($p->discount_price)
                                    <span class="badge badge-warning">Promo</span>
                                @endif
                            </div>


                            <h3 class="card-title text-base line-clamp-2">{{ $p->name }}</h3>
                            <p class="text-sm opacity-70 line-clamp-2">{{ $p->short_description }}</p>


                            <div class="font-semibold mt-2 ">
                                <span class="text-primary">{{ format_price($p->effective_price) }}</span>
                                @if($p->discount_price)
                                    <span
                                        class="line-through text-sm text-red-500 ml-1 opacity-60">{{ format_price($p->price) }}</span>
                                @endif
                            </div>

                            {{-- Stock Status --}}
                            <div class="text-sm mt-2">
                        <span class="{{ $isValidForCart ? 'text-success' : 'text-error' }}">
                            {{ $stockMessage }}
                        </span>
                            </div>
                        </a>
                    </section>

                    {{-- Bouton principal --}}
                    <button class="btn btn-primary btn-block mt-3 flex items-center justify-center gap-2"
                            @click.prevent="add"
                            :disabled="loading || {{ $isValidForCart ? 'false' : 'true' }}">
                        <span x-show="loading" class="loading loading-spinner loading-xs"></span>
                        <span
                            x-text="loading ? 'Ajout…' : {{ $isValidForCart ? '\'Ajouter au panier\'' : '\'Rupture de stock\'' }}"></span>
                    </button>
                </div>
            </div>

        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-lg">Aucun produit disponible…</p>
            </div>
        @endforelse
    </div>

    {{-- CTA catalogue --}}
    <div class="text-center">
        <a href="{{ route('products.index') }}" class="btn btn-outline btn-primary">
            Voir tous les produits
        </a>
    </div>
</div>
