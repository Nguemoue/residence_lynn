{{-- PANIER -----------------------------------------------------------------}}
<section class="py-16 bg-base-100">
    <div class="container mx-auto px-4">

        @if($this->items->isEmpty())
            <div class="text-center py-20">
                @svg('heroicon-o-shopping-cart','w-20 h-20 mx-auto text-primary mb-4')
                <p class="text-lg mb-6">Votre panier est vide pour le moment.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Continuer mes achats</a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-10" x-data>
                {{-- Lignes panier --------------------------------------------------}}
                <div class="lg:col-span-2 space-y-6">
                    @foreach($this->items as $line)
                        @php($p = $line['product'])
                        <div class="card card-side bg-base-200 shadow p-4 items-center">
                            <figure>
                                <img src="{{ $p->cover_image_url }}"
                                     alt="{{ $p->name }}"
                                     class="w-24 h-24 object-cover rounded-xl"/>
                            </figure>

                            <div class="card-body p-4">
                                <h3 class="card-title text-base">
                                    <a href="{{ route('products.show', $p) }}" class="hover:underline">
                                        {{ $p->name }}
                                    </a>
                                </h3>
                                <p class="text-sm opacity-70">{{ $p->short_description }}</p>

                                {{-- Quantité --}}
                                <div class="flex items-center gap-3 mt-3">
                                    <input type="number"
                                           wire:change.debounce.300ms="updateQuantity({{ $p->id }}, $event.target.value)"
                                           min="1"
                                           value="{{ $line['quantity'] }}"
                                           class="input input-bordered w-20"/>
                                    <div class="flex gap-2 ml-auto">
                                        <span>
                                            {{format_price($p->effectivePrice)}} x {{$line['quantity']}}
                                        </span>
                                        <span>=</span>
                                        <span class="font-semibold ml-auto">
                                            {{ format_price($line['subtotal']) }}
                                        </span>
                                    </div>

                                </div>
                            </div>

                            {{-- Supprimer --}}
                            <button wire:click="removeItem({{ $p->id }})"
                                    class="btn btn-sm btn-circle btn-error ml-4" wire:loading.attr="disabled">
                                @svg('heroicon-o-trash','w-5 h-5')
                            </button>
                        </div>
                    @endforeach
                </div>

                {{-- Récapitulatif --------------------------------------------------}}
                <div class="card bg-base-200 shadow p-6 sticky top-24 self-start">
                    <h2 class="text-xl font-bold mb-4">Récapitulatif</h2>

                    <div class="flex justify-between mb-2">
                        <span>Sous-total</span>
                        <span>{{ format_price($this->subtotal) }}</span>
                    </div>

                    <div class="flex justify-between mb-4">
                        <span>Livraison</span>
                        <span>{{ $this->shipping == 0.0 ? 'Gratuite' : format_price($this->shipping) }}</span>
                    </div>

                    <div class="flex justify-between text-lg font-semibold mb-6">
                        <span>Total</span>
                        <span>{{ format_price($this->total) }}</span>
                    </div>

                    <a href="{{ route('checkout.show') }}" class="btn btn-primary btn-block"
                       wire:loading.attr="disabled" wire:loading.class="ring">
                        Passer au paiement
                    </a>

                    <a href="{{ route('products.index') }}" class="btn btn-ghost btn-block mt-2">
                        Continuer mes achats
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
