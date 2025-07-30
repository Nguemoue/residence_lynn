{{-- resources/views/pages/accommodation-types/show.blade.php --}}
@extends('layouts.frontend')

@section('title', $type->name . ' – ' . config('app.name'))
@section('meta-description', 'Découvrez tous les logements disponibles de type ' . $type->name . ' à Kribi, ainsi que les services, commodités et dates de réservation.')

@section('content')
    {{-- HERO IMAGE --}}
    <section class="hero min-h-[60vh] bg-cover bg-center"
             style="background-image: url({{ asset('assets/images/room2.jpg') }});">
        <div class="hero-overlay bg-black/50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-2xl animate__animated animate__fadeInDown">
                <h1 class="text-5xl font-bold mb-4">{{ $type->name }}</h1>
                <p class="opacity-90">Un logement pensé pour le confort, le calme, et la sérénité à Kribi.</p>
            </div>
        </div>
    </section>

    {{-- DESCRIPTION --}}
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-10 items-start">
            <div>
                <img src="{{ $type->cover_image_url }}" alt="{{ $type->name }}" class="rounded-lg shadow w-full">
                <p class="mt-6 text-base-content text-justify leading-relaxed">{!! $type->description !!}</p>

                {{-- Services --}}
                @if($type->services->count())
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg mb-2">Services inclus :</h3>
                        <ul class="list-disc list-inside text-sm opacity-80">
                            @foreach($type->services as $service)
                                <li>{{ $service->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Commodités --}}
                @if($type->amenities)
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg mb-2">Commodités :</h3>
                        <ul class="list-disc list-inside text-sm opacity-80">
                            @foreach($type->amenities as $amenity)
                                <li>{{ $amenity }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- RÉSERVATION RAPIDE --}}
            <div class="bg-base-200 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">📆 Choisissez votre période</h2>
                <form method="POST" action="{{ route('checkout.store') }}" class="space-y-4">
                    @csrf
                    <div class="form-control">
                        <label class="label mb-2">Date d'arrivée</label>
                        <input type="text" id="start_date" name="start_date" class="input input-bordered w-full flatpickr">
                        @error('start_date') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label mb-2">Date de départ</label>
                        <input type="text" id="end_date" name="end_date" class="input input-bordered w-full flatpickr">
                        @error('end_date') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label mb-2">Nombre de personnes</label>
                        <input type="number" id="guest_number" name="guest_number" min="1" value="1" class="input input-bordered w-full" >
                        @error('guest_number') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label mb-2">Numero de telephone</label>
                        <input type="tel" id="phone" name="phone" min="1" value="{{old('phone',auth()->user()->phone ?? '')}}" class="input input-bordered w-full" >
                        @error('phone') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label mb-2">Nom complet</label>
                        <input type="text" id="name" name="name"  value="{{old('name',auth()->user()->name ?? '')}}" class="input input-bordered w-full" >
                        @error('name') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label mb-2">Adresse e-mail</label>
                        <input type="email" id="email" name="email" min="1" value="{{old('email',auth()->user()->email ?? '')}}" class="input input-bordered w-full" >
                        @error('email') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label mb-2">Choisir votre local</label>
                        {{-- select that list all available accommodations for this type --}}
                        <select name="accommodation_id" class="select select-bordered w-full">
                            @foreach($type->accommodations as $accommodation)
                                <option value="{{ $accommodation->id }}">{{ $accommodation->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- make sur the user is authenticated if not redirect to login page--}}
                    @auth
                        <button type="submit" class="btn btn-primary w-full mt-4">Réserver maintenant</button>
                    @endauth
                    @guest
                        <a href="{{ url('dashboard') }}" class="btn btn-primary w-full mt-4">Connectez-vous pour réserver</a>
                    @endguest
                </form>

                <div class="mt-6 text-sm text-center text-base-content/70">
                    <p>✔️ Réservation sécurisée • Annulation flexible • Assistance locale</p>
                </div>
            </div>
        </div>
    </section>

    {{-- LOGEMENTS DISPONIBLES --}}
    <section class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10">Logements disponibles ({{ $type->accommodations->count() }})</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($type->accommodations as $accommodation)
                    <div class="card bg-base-100 shadow hover:shadow-lg transition">
                        <figure><img src="{{ $accommodation->cover_image_url }}" alt="Logement" class="h-100 w-full object-cover"></figure>
                        <div class="card-body">
                            <h3 class="text-lg font-semibold">{{ $accommodation->code }}</h3>
                            <p class="text-sm opacity-80">{{ str($accommodation->description)->toHtmlString() }}</p>
                            <a href="{{ route('accommodations.show', $accommodation->id) }}" class="btn btn-sm btn-outline mt-3">Voir les détails</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split('T')[0];
            flatpickr(".flatpickr", {
                minDate: today,
                dateFormat: "Y-m-d",
                disable: @json($disabledDates ?? []),
                locale: "fr"
            });
        });
    </script>
@endpush
