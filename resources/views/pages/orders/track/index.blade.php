@extends('layouts.frontend')

@section('title', 'Suivi de commande – ' . config('app.name'))

@section('content')
    {{-- BREADCRUMB ----------------------------------------------------------- --}}
    <section class="bg-base-200 py-3">
        <div class="container mx-auto px-4">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li>Suivi de commande</li>
                </ul>
            </div>
        </div>
    </section>
    <section class="py-24 bg-base-100 flex items-center"
             x-data="{
                        loading:false,
                        submit() {
                            this.loading = true;
                            this.$refs.trackForm.submit();
                        }
    }">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body space-y-6">
                    <h1 class="text-2xl font-bold text-center">Suivre ma commande</h1>
                    <p class="text-sm text-center opacity-70">
                        Renseignez le numéro de suivi reçu par e-mail pour connaître l’état de votre commande.
                    </p>

                    <form x-ref="trackForm" method="POST" action="{{ route('orders.track.search') }}" class="space-y-4">
                        @csrf
                        <input type="text"
                               name="code"
                               placeholder="Reference de la commande"
                               value="{{ old('code') }}"
                               class="input input-bordered w-full"
                               required/>

                        @error('code') <p class="text-error text-sm">{{ $message }}</p>@enderror

                        <div class="max-w-4xl w-full mx-auto">
                            <button type="button"
                                    class="btn btn-primary w-full mt-4"
                                    :disabled="loading"
                                    @click="submit">
                                <span class="flex" x-show="!loading">@svg('heroicon-o-magnifying-glass','w-5 h-5 mr-2') Rechercher</span>
                                <span x-show="loading"><span class="flex items-center gap-2"><span class="loading loading-spinner"></span><span>Traitement…</span></span></span>
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
