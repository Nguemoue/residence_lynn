{{-- resources/views/pages/checkout/show.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Paiement – ' . config('app.name'))

@php /** @var \Illuminate\Support\Collection<int,array{product:App\Models\Product,quantity:int,unit_price:float,subtotal:float}> $cart */ @endphp

@section('content')
    {{-- HERO --}}
    <section class="hero min-h-[30vh]" style="background-image:url('{{ asset('assets/checkout-hero.jpg') }}')">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-lg">
                <h1 class="text-4xl font-bold mb-4">Finalisez votre commande</h1>
                <p class="opacity-80">Renseignez vos informations et payez en toute sécurité.</p>
            </div>
        </div>
    </section>

    {{-- CHECKOUT --}}
    <section class="py-16 bg-base-100"
             x-data="checkoutForm(@js($errors->toArray()), @js(old()))">
        {{-- ➜ NE PAS AJOUTER de x-data sur le <form> lui-même, Alpine perd le scope en cas de submit --}}
        <form x-ref="payForm"
              id="payForm"
              method="POST"
              action="{{ route('checkout.store') }}"
              class="space-y-10">
            @csrf

            <div class="container mx-auto px-4 grid lg:grid-cols-3 gap-10">
                <!-- COLONNE GAUCHE -->
                <div class="lg:col-span-2 space-y-10">
                    {{-- Informations de livraison --}}
                    <div class="card border border-base-300">
                        <div class="card-body space-y-6">
                            <h2 class="card-title">Informations de livraison</h2>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Prénom -->
                                <x-checkout.input
                                    field="surname"
                                    label="Prénom"
                                    type="text"
                                    required
                                />
                                <!-- Nom -->
                                <x-checkout.input
                                    field="name"
                                    label="Nom"
                                    type="text"
                                    required
                                />
                            </div>

                            <x-checkout.input
                                field="address"
                                label="Adresse de livraison"
                                type="text"
                                required
                            />

                            <div class="grid md:grid-cols-2 gap-4">
                                <x-checkout.input field="city"   label="Ville"        type="text" required/>
                                <x-checkout.input field="postal_code" label="Code postal" type="text" required/>
                            </div>

                            <x-checkout.input field="phone" type="tel"   label="Téléphone" required/>
                            <x-checkout.input field="email" type="email" label="Email"     required/>
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE -->
                <div class="card bg-base-200 border border-base-300 sticky top-24 self-start"
                     x-on:mouseenter="$el.classList.add('scale-[1.02]','shadow-xl')"
                     x-on:mouseleave="$el.classList.remove('scale-[1.02]','shadow-xl')">
                    <div class="card-body space-y-4">
                        <h2 class="card-title"> Résumé de la commande</h2>

                        <ul class="space-y-4 max-h-60 overflow-y-auto pr-2">
                            @foreach($cart as $line)
                                <li class="flex items-start gap-4">
                                    <img class="w-16 h-16 object-cover rounded"
                                         src="{{ $line['product']->cover_image_url }}"
                                         alt="{{ $line['product']->name }}">
                                    <div class="flex-1">
                                        <p class="font-semibold">{{ $line['product']->name }}</p>
                                        <p class="text-xs opacity-70">x{{ $line['quantity'] }}</p>
                                    </div>
                                    <span class="font-semibold">{{ format_price($line['subtotal']) }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="divider my-2"></div>
                        @php
                            $subtotal = $cart->sum('subtotal');
                            $shipping = app(\App\Domain\Services\CartService::class)->shipping();
                            $total    = $subtotal + $shipping;
                        @endphp
                        <div class="flex justify-between text-sm">
                            <span>Sous-total</span><span>{{ format_price($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Livraison</span>
                            <span>{{ $shipping === 0 ? 'Gratuite' : format_price($shipping) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-base-300 pt-4">
                            <span>Total</span><span>{{ format_price($total) }}</span>
                        </div>

                        <button type="button"
                                class="btn btn-primary w-full mt-4"
                                :disabled="loading"
                                @click="submit">
                            <span x-show="!loading">Payer maintenant</span>
                            <span x-show="loading">
                            <span class="flex items-center gap-2">
                                <span class="loading loading-spinner"></span>
                                <span>Traitement…</span>
                            </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>



@endsection

@push('scripts')
    <script>
        function checkoutForm(serverErrors = {}, old = {}) {
            return {
                /* état */
                loading: false,
                form: {
                    surname:      old.surname      ?? '',
                    name:         old.name         ?? '',
                    address:      old.address      ?? '',
                    city:         old.city         ?? '',
                    postal_code:  old.postal_code  ?? '',
                    phone:        old.phone        ?? '',
                    email:        old.email        ?? '',
                },
                /* erreurs (clé ➜ message) */
                errors: {...serverErrors},

                /* règles très simples */
                rules: {
                    surname:     v => v.length > 1   || 'Prénom requis',
                    name:        v => v.length > 1   || 'Nom requis',
                    address:     v => v.length > 4   || 'Adresse invalide',
                    city:        v => v.length > 1   || 'Ville requise',
                    postal_code: v => v.length > 1 || 'Code postal invalide',
                    phone:       v => v.length >= 6  || 'Téléphone invalide',
                    email:       v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) || 'Email invalide',
                },

                /**
                 * Valide un champ unique
                 */
                validateField(field) {
                    const validator = this.rules[field];
                    if (!validator) return true;

                    const result = validator(this.form[field] ?? '');
                    if (result === true) {
                        delete this.errors[field];
                        return true;
                    }
                    this.errors[field] = result; // message
                    return false;
                },

                /**
                 * Valide tout le formulaire
                 */
                validateAll() {
                    let ok = true;
                    Object.keys(this.rules).forEach(key => {
                        if (!this.validateField(key)) ok = false;
                    });
                    return ok;
                },

                /**
                 * Au clic sur “payer”
                 */
                submit() {
                    if (!this.validateAll()) {
                        /* scroll vers le premier champ en erreur */
                        this.$nextTick(() => {
                            const firstError = this.$root.querySelector('.input-error');
                            firstError?.scrollIntoView({behavior: 'smooth', block: 'center'});
                        });
                        return;
                    }
                    this.loading = true;
                    this.$refs.payForm.submit();
                },
            }
        }
    </script>
@endpush
