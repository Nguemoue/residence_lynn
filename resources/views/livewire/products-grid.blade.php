<div class="space-y-10" x-data="{ search: '', loading: false }">

    {{-- Filtres ------------------------------------------------------------------}}
    <div class="text-center">
        <div class="flex flex-wrap justify-center gap-3">
            <button wire:click="$set('category', null)"
                    class="btn btn-outline btn-sm {{ $category ? '' : 'btn-active' }}">
                Tous les produits
            </button>
            @foreach($this->categories as $cat)
                <button wire:key="{{$cat->slug}}" wire:click="$set('category', '{{ $cat->slug }}')"
                        class="btn btn-outline btn-sm {{ $category === $cat->slug ? 'btn-active' : '' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>
    {{-- Search Bar ------------------------------------------------------------------}}
    <div class="text-center">
        <div class="max-w-2xl mx-auto mb-6 ">
            <div class="input-group flex">
                <input type="text"
                       x-model="search"
                       placeholder="Rechercher des produits..."
                       class="input input-bordered w-full focus:ring focus:ring-primary focus:ring-opacity-50"
                       aria-label="Rechercher des produits"
                       @keyup.enter="$wire.set('search', search); loading = true"
                       x-on:input="if (!search) { $wire.set('search', ''); loading = false }"/>
                <button class="btn btn-primary"
                        x-on:click="$wire.set('search', search); loading = true"
                        :disabled="loading || !search"
                        x-on:livewire:navigated="loading = false">
                    Rechercher
                    <template x-if="loading">
                        <span class="loading loading-spinner loading-sm"></span>
                    </template>
                    <template x-if="!loading">
                        @svg('heroicon-o-magnifying-glass', 'w-6 h-6')
                    </template>
                </button>
            </div>
        </div>
    </div>

    {{-- Catalogue ------------------------------------------------------------------}}
    <div
        wire:loading.class="opacity-40"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 transition-opacity duration-300"
        x-show.transition.opacity.duration.300ms="!loading"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        @forelse($this->products as $product)
            @php
                $isValidForCart = $product->isValidForCart();
                $stockMessage = $product->stock_message;
            @endphp

            <div id="product-{{ $product->id }}" wire:key="{{$product->id}}"
                 class="card bg-base-100 shadow-md transition-transform"
                 x-on:mouseenter="$el.classList.add('scale-[1.02]')"
                 x-on:mouseleave="$el.classList.remove('scale-[1.02]')">

                <figure class="relative group">
                    <img src="{{ $product->cover_image_url }}" alt="{{ $product->name }}"
                         class="w-full h-52 object-cover"/>

                    {{-- Overlay --}}
                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center gap-3
                                opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="btn btn-circle btn-secondary">
                            @svg('heroicon-o-eye','w-6 h-6')
                        </a>
                        <button wire:click="addToCart({{ $product->id }})"
                                class="btn btn-circle btn-primary"
                                @if(!$isValidForCart)
                                    disabled
                            @endif>
                            @svg('heroicon-o-shopping-cart','w-6 h-6')
                        </button>
                    </div>
                </figure>

                <div class="card-body">
                    <section>
                        <a href="{{route('products.show',['product' => $product])}}">
                            <div class="flex justify-end items-center text-xs font-medium mb-1">
                                @if($product->discount_price)
                                    <span class="badge badge-warning">Promo</span>
                                @endif
                            </div>
                            <h3 class="card-title text-base">{{ $product->name }}</h3>
                            <p class="text-sm opacity-70 line-clamp-2">{{ $product->short_description }}</p>


                            <div class="font-semibold mt-2">
                                <span class="text-primary">{{ format_price($product->effective_price) }}</span>
                                @if($product->discount_price)
                                    <span
                                        class="line-through text-sm text-red-500 ml-1 opacity-60">{{ format_price($product->price) }}</span>
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

                    <button wire:click="addToCart({{ $product->id }})"
                            class="btn btn-primary btn-block mt-3"
                            @if(!$isValidForCart)
                                disabled
                        @endif>
                        {{ $isValidForCart ? 'Ajouter au panier' : 'Rupture de stock' }}
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-lg">Aucun produit trouvé pour cette catégorie ou recherche.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination ------------------------------------------------------------------}}
    <div class="text-center">
        {{ $this->products->links() }}
    </div>
</div>

@script

<script>
    document.addEventListener('alpine:init', () => {
        Livewire.on('cart:item-added', id => {
            const el = document.getElementById('product-' + id)
            if (el) {
                el.classList.add('ring', 'ring-success', 'ring-offset-2')
                setTimeout(() => el.classList.remove('ring', 'ring-success', 'ring-offset-2'), 500)
            }
        })
    })
</script>
@endscript
