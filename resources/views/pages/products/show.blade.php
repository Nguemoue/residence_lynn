@extends('layouts.frontend')

@php /** @var \App\Models\Product $product */ @endphp

@section('title', $product->name . ' – ' . config('app.name'))
@section('meta-description', Str::limit($product->short_description, 150))

@section('content')
    {{-- BREADCRUMB -----------------------------------------------------------}}
    <section class="bg-base-200 py-3">
        <div class="container mx-auto px-4">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('products.index') }}">Produits</a></li>
                    <li>{{ $product->name }}</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- PRODUCT DETAIL -------------------------------------------------------}}
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-4 grid lg:grid-cols-2 gap-12">
            {{-- Gallery with zoom --------------------------------------------------}}
            <div x-data="{active:'{{ $product->cover_image_url }}',showModal:false}"
                 @keydown.escape.window="showModal=false" class="space-y-4">
                {{-- Main image --}}
                <div class="relative w-full h-80 bg-base-200 rounded-box overflow-hidden cursor-zoom-in"
                     @click="showModal=true">
                    <img x-bind:src="active" alt="{{ $product->name }}" class="w-full h-full object-cover"/>
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black/30 opacity-0 hover:opacity-100 transition">
                        @svg('heroicon-o-magnifying-glass','w-10 h-10 text-base-100')
                    </div>
                </div>

                {{-- Thumbnails --}}
                <div class="flex gap-3 overflow-x-auto">
                    @foreach([$product->cover_image_url,...$product->gallery_url]  as $key => $img)
                        <img src="{{ $img }}" alt="thumb" @click="active='{{ $img }}'"
                             :class="{'ring-2 ring-primary': active==='{{ $img }}'}"
                             class="h-20 w-20 object-cover rounded cursor-pointer transition"/>
                    @endforeach
                </div>
                {{-- Modal --}}
                <template x-teleport="body">
                    <div x-show="showModal" x-transition x-cloak
                         class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center overflow-auto">
                        <div class="relative max-w-5xl max-h-4xl w-full">
                            <button class="absolute top-4 right-4 btn btn-circle btn-sm z-10" @click="showModal=false">
                                ✕
                            </button>
                            <img :src="active" alt="zoom" class=" h-auto object-contain rounded-box"/>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Info --------------------------------------------------------------}}
            <div class="space-y-6">
                <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                <p class="opacity-80">{{ $product->short_description }}</p>

                {{-- Rating --}}
                <div class="flex items-center gap-2">
                    <div class="rating rating-sm">
                        @for($i=1;$i<=5;$i++)
                            <input type="radio"
                                   class="mask mask-star-2 {{ $i <= round($product->rating) ? 'bg-primary' : 'bg-base-300' }}"
                                   disabled/>
                        @endfor
                    </div>
                    <span class="text-sm opacity-70">({{ number_format($product->rating,1) }})</span>
                </div>

                {{-- Price options --}}
                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 rounded-box border border-base-300 cursor-pointer">
                        <input type="radio" name="price" class="radio radio-primary" checked>
                        <span class="flex-1">Achat unique</span>
                        <div>
                            @if($product->discount_price)
                                <strong
                                    class="line-through m-2 text-red-500">{{ format_price($product->price) }}</strong>
                            @endif

                            <span @class(["font-semibold",$product->discount_price => "text-primary"])>
                                {{ format_price($product->effective_price) }}
                            </span>
                        </div>

                    </label>
                    @if($product->discount_price)
                        {{--<label class="flex items-center gap-3 p-3 rounded-box border border-base-300 cursor-pointer bg-primary/5">
                            <input type="radio" name="price" class="radio radio-primary">
                            <span class="flex-1">Pack 3 ( -20% )</span>
                            <span class="font-semibold">{{ format_price($product->discount_price*3) }}</span>
                        </label>--}}
                    @endif
                </div>

                <livewire:product.add-to-cart :product="$product"/>

                {{-- Payment icons --}}
                <div class="flex gap-4 items-center mt-4 opacity-80 text-xs">
                    <span>Paiement sécurisé :</span>
                    <span class="badge">Visa</span>
                    <span class="badge">Mastercard</span>
                    <span class="badge">PayPal</span>
                </div>

                {{-- Guarantees --}}
                <div class="flex gap-4 mt-6 text-sm">
                    <div class="flex items-center gap-2"><span
                            class="text-primary">@svg('heroicon-o-truck','w-5 h-5')</span> Livraison gratuite 49 €+
                    </div>
                    <div class="flex items-center gap-2"><span
                            class="text-primary">@svg('heroicon-o-shield-check','w-5 h-5')</span> Retour 30 j
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- DESCRIPTION ----------------------------------------------------------}}
    <section class="py-20 bg-base-200">
        <div class="container mx-auto px-4 max-w-4xl space-y-10">
            <h2 class="text-2xl font-bold text-center">Pourquoi vous allez adorer ?</h2>
            <p class="text-center opacity-80">{{ $product->description }}</p>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="card bg-base-100 p-6 text-center shadow">
                    @svg('heroicon-o-sparkles','w-8 h-8 mx-auto mb-3 text-primary')
                    <h3 class="font-semibold mb-2">{{__('product-detail.card_title1')}}</h3>
                    <p>{{__('product-detail.card_content1')}}</p>
                </div>
                <div class="card bg-base-100 p-6 text-center shadow">
                    @svg('heroicon-o-shield-check','w-8 h-8 mx-auto mb-3 text-primary')
                    <h3 class="font-semibold mb-2">{{__('product-detail.card_title2')}}</h3>
                    <p>{{__('product-detail.card_content2')}}</p>
                </div>
                <div class="card bg-base-100 p-6 text-center shadow">
                    @svg('heroicon-o-bolt','w-8 h-8 mx-auto mb-3 text-primary')
                    <h3 class="font-semibold mb-2">{{__('product-detail.card_title3')}}</h3>
                    <p>{{__('product-detail.card_content3')}}</p>
                </div>
                <div class="card bg-base-100 p-6 text-center shadow">
                    @svg('heroicon-o-arrow-path','w-8 h-8 mx-auto mb-3 text-primary')
                    <h3 class="font-semibold mb-2">{{__('product-detail.card_title4')}}</h3>
                    <p>{{__('product-detail.card_content4')}}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
