@extends('layouts.frontend')

@php
    use App\Domain\Enums\OrderStatusEnum;

    $current = $order->status->step();
@endphp

@section('title', 'Commande ' . $order->code)

@section('content')
    {{-- BREADCRUMB ----------------------------------------------------------- --}}
    <section class="bg-base-200 py-3">
        <div class="container mx-auto px-4">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('orders.track.index') }}">Suivi de commande</a></li>
                    <li>{{ $order->code }}</li>
                </ul>
            </div>
        </div>
    </section>
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4 space-y-12">
            {{-- Récapitulatif ---------------------------------------------------- --}}
            <div class="card bg-base-200 shadow">
                <div class="card-body">
                    <h1 class="text-xl font-bold mb-4 flex justify-between">
                        <span>Commande numero #{{ $order->code }}</span>
                        <a href="{{route('orders.pdf',['order' => $order])}}" class="btn btn-sm btn-neutral"> <x-heroicon-c-cloud-arrow-down class="w-5 h-5" /> Telecharger ma facture </a>
                    </h1>

                    {{-- Timeline ------------------------------------------------ --}}
                    <ul class="steps steps-horizontal w-full mb-6">
                        @foreach(OrderStatusEnum::cases() as $enum)
                            <li class="step {{ $current >= $enum->step() ? 'step-primary' : '' }}">{{__('status.'.$enum->value)}}</li>
                        @endforeach
                    </ul>

                    <p class="mb-2">
                        <span class="font-semibold">Etat actuel :</span>
                        <span class="badge {{ $order->status->badgeColor() }}">
                        {{ __('status.'.$order->status->value) }}
                    </span>
                    </p>
                    <p class="text-sm">
                        Passée le {{ $order->created_at->translatedFormat('d F Y à H:i') }}
                    </p>
                </div>
            </div>

            {{-- Lignes description ----------------------------------------------- --}}

            <div class="card bg-base-200 shadow overflow-x-auto">
                <div class="card-body p-0">
                    <h1 class="text-xl p-4 font-bold mb-4">
                        Description.
                    </h1>
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Etape</th>
                                <th>Description.</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->status_note??[] as $key => $description)
                            <tr>
                                <th>{{ $loop->index + 1 }}</th>
                                <th>{{ __('status.'.$key) }}</th>
                                <th>{{$description}}</th>
                            </tr>
                            @break($key === $order->status->value)
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Lignes produit --------------------------------------------------- --}}
            <div class="card bg-base-200 shadow overflow-x-auto">
                <div class="card-body p-0">
                    <table class="table table-zebra">
                        <thead>
                        <tr>
                            <th>Produit</th>
                            <th class="text-right">Quantite</th>
                            <th class="text-right">Prix unitaire.</th>
                            <th class="text-right">Sous-total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <th class="flex items-center gap-3">
                                    <img src="{{ $item->product->cover_image_url }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-12 h-12 object-cover rounded">
                                    <a href="{{ route('products.show', $item->product) }}" class="link">
                                        {{ $item->product->name }}
                                    </a>
                                </th>
                                <th class="text-right">{{ $item->quantity }}</th>
                                <th class="text-right">{{ format_price($item->unit_price) }}</th>
                                <th class="text-right">{{ format_price($item->subtotal) }}</th>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="font-semibold">
                            <th colspan="3" class="text-right">Sous-total</th>
                            <th class="text-right">{{ format_price($order->subtotal) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Frais de port</th>
                            <th class="text-right">{{ format_price($order->shipping_total) }}</th>
                        </tr>
                        <tr class="font-bold">
                            <th colspan="3" class="text-right">Total payé</th>
                            <th class="text-right">{{ format_price($order->total) }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- CTA retour catalogue ------------------------------------------- --}}
            <div class="text-center pt-8">
                <a href="{{ route('products.index') }}" class="btn btn-outline btn-primary">
                    Continuer vos achats
                </a>
            </div>
        </div>
    </section>
@endsection
