@php
    $fakeProducts = [
      [
        'img'   => 'https://images.pexels.com/photos/4315474/pexels-photo-4315474.jpeg?auto=compress&cs=tinysrgb&w=400',
        'title' => 'Kit soins naturels 5 en 1',
        'badge' => ['Populaire', 'Promo'],
        'price' => '49,00 €',
        'old'   => '69,00 €',
      ],
      // … ajoute d’autres produits ou boucle sur $products (prop)
    ];
@endphp
<section id="products" class="py-16 bg-base-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-primary">Nos produits phares</h2>
            <p class="text-base-content max-w-2xl mx-auto mt-4">
                Découvrez notre collection de soins capillaires, compléments alimentaires et accessoires.
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <button class="btn btn-outline btn-sm">Tous</button>
            <button class="btn btn-outline btn-sm">Soins capillaires</button>
            <button class="btn btn-outline btn-sm">Compléments</button>
            <button class="btn btn-outline btn-sm">Accessoires</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($fakeProducts as $p)
                <div class="card bg-base-100 shadow-md">
                    <figure class="relative group">
                        <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" class="w-full h-52 object-cover" />
                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition">
                            <button class="btn btn-circle btn-sm btn-ghost text-base-100">@svg('heroicon-o-eye', 'w-5 h-5')</button>
                            <button class="btn btn-circle btn-sm btn-primary">@svg('heroicon-o-shopping-cart', 'w-5 h-5')</button>
                        </div>
                    </figure>
                    <div class="card-body">
                        <div class="flex justify-between items-center text-sm">
                            @foreach ($p['badge'] as $b)
                                <span class="badge badge-{{ $loop->first ? 'accent' : 'warning' }}">{{ $b }}</span>
                            @endforeach
                        </div>
                        <h3 class="card-title text-base mt-2">{{ $p['title'] }}</h3>
                        <div class="text-primary font-semibold mt-2">
                            {{ $p['price'] }} <span class="line-through text-sm text-base-content ml-2">{{ $p['old'] }}</span>
                        </div>
                        <button class="btn btn-primary btn-block mt-4">Ajouter au panier</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <button class="btn btn-outline btn-primary">Voir tous les produits</button>
        </div>
    </div>
</section>
