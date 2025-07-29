<section id="about" class="py-16 bg-base-200">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-primary">Noveden – Beauté naturelle pour toutes</h2>
            <p class="text-base-content max-w-2xl mx-auto mt-4">
                Prenez soin de vos cheveux, de votre peau et de votre bien‑être avec nos produits naturels
                pensés pour les femmes, les enfants et tous les types de beauté. Des soins capillaires aux
                compléments, Noveden vous accompagne avec passion.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php($features = [
              ['icon' => 'heroicon-o-sparkles', 'title' => 'Excellence', 'text' => 'Formules naturelles et efficaces'],
              ['icon' => 'heroicon-o-truck', 'title' => 'Livraison rapide', 'text' => 'Offerte dès 49 € en Europe'],
              ['icon' => 'heroicon-o-shield-check', 'title' => 'Qualité garantie', 'text' => 'Satisfait ou remboursé'],
              ['icon' => 'heroicon-o-heart', 'title' => 'Engagement', 'text' => 'Une équipe passionnée à votre service'],
            ])
            @foreach ($features as $f)
                <div class="card bg-base-100 shadow text-center p-6">
                    <div class="text-primary mx-auto mb-4">
                        @svg($f['icon'], 'w-8 h-8')
                    </div>
                    <h3 class="text-lg font-semibold mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm">{{ $f['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
