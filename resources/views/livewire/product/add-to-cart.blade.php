<div>
    <button
        wire:click="addToCart"
        wire:loading.attr="disabled"
        class="btn btn-primary w-full lg:w-auto relative overflow-hidden">

        {{-- spinner lors du traitement --}}
        <span wire:loading
              wire:target="addToCart"
              class="absolute inset-0 flex items-center justify-center bg-black/20">
            <span class="loading loading-spinner"></span>
        </span>

        {{-- libellé normal --}}
        @svg('heroicon-o-shopping-cart', 'w-5 h-5 mr-2')
        <span class="whitespace-nowrap">Ajouter au panier</span>
    </button>
</div>
