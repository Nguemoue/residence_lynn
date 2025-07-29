<div>
    {{-- premier style utiliser dans la page d'acceuil --}}
    @if($design ===1)
        <section class="p-16 bg-primary text-primary-content">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto">

                    @svg('heroicon-o-envelope', 'w-10 h-10 mx-auto mb-4')

                    <h2 class="text-3xl font-bold mb-2">Inscrivez-vous à la newsletter</h2>

                    <p class="mb-6">
                        Bénéficiez de 10% de réduction immédiate et recevez nos conseils, offres et nouveautés
                        bien-être.
                    </p>

                    @if (session()->has('success'))
                        <div class="alert alert-success shadow-lg mb-4">
                            @svg('heroicon-o-check-circle', 'w-5 h-5')
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <form wire:submit.prevent="subscribe" class="join w-full max-w-md mx-auto">
                        <input type="email" wire:model.defer="email" placeholder="Votre e-mail"
                               class="input input-bordered w-full text-gray-700 join-item @error('email') input-error @enderror"
                               required/>

                        <button  class="btn btn-secondary join-item" wire:loading.attr="disabled">
                            <span wire:loading wire:target="subscribe" class="loading loading-spinner"></span>
                            S'inscrire
                        </button>
                    </form>

                    @error('email')
                    <span class="text-sm text-red-200 block mt-2">{{ $message }}</span>
                    @enderror

                    <p class="text-xs opacity-70 mt-4">
                        En vous inscrivant, vous acceptez de recevoir nos communications. Vous pouvez vous désinscrire à
                        tout moment.
                    </p>
                </div>
            </div>
        </section>
    @else
        {{-- utilise dans la page de blog --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h4 class="font-semibold mb-2">Newsletter</h4>
                <p class="text-sm mb-4">Recevez nos derniers conseils et offres.</p>
                <form wire:submit.prevent="subscribe">
                    <input type="email" wire:model.defer="email" required placeholder="Votre email"
                           class="input input-bordered w-full mb-3"/>
                    <button class="btn btn-primary w-full" wire:loading.attr="disabled">
                        <span wire:loading wire:target="subscribe" class="loading loading-spinner mr-2"></span>
                        S'abonner
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
