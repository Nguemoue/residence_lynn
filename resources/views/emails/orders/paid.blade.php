@component('mail::message')
    @component('mail::layout')
        {{-- Header --}}
        @slot('header')
            @component('mail::header', ['url' => config('app.url')])
                {{ config('app.name') }}
            @endcomponent
        @endslot

        {{-- Body --}}
        # {{ __('notifications.order_paid.greeting', ['name' => $order->full_name]) }}

        {{ __('notifications.order_paid.intro') }}

        @component('mail::panel')
            **{{ __('notifications.order_paid.order_number', ['uuid' => $order->uuid]) }}**
            {{ __('notifications.order_paid.order_date', ['date' => $order->created_at->format('d/m/Y')]) }}
            {{ __('notifications.order_paid.total', ['total' => $formatPrice($order->total)]) }}
        @endcomponent

        ## {{ __('notifications.order_paid.items') }}

        @component('mail::table')
            | {{ __('notifications.order_paid.product') }} | {{ __('notifications.order_paid.quantity') }} | {{ __('notifications.order_paid.unit_price') }} | {{ __('notifications.order_paid.total_price') }} |
            |---------------------------------------------|----------------------------------------------|-----------------------------------------------|----------------------------------------------|
            @foreach($order->items as $item)
                | {{ $item->product ? $item->product->name : 'Produit supprimé (ID: ' . $item->product_id . ')' }} | {{ $item->quantity }} | {{ $formatPrice($item->unit_price) }} | {{ $formatPrice($item->total_price) }} |
            @endforeach
        @endcomponent

        @component('mail::button', ['url' => route('orders.pdf', ['uuid' => $order->uuid]), 'color' => 'primary'])
            {{ __('notifications.order_paid.view_order') }}
        @endcomponent

        {{ __('notifications.order_paid.thanks') }}
        {{ __('notifications.order_paid.contact', ['email' => 'support@' . config('app.name') | lower . '.com']) }}

        {{-- Footer --}}
        @slot('footer')
            @component('mail::footer')
                © {{ date('Y') }} {{ config('app.name') }}. {{ __('notifications.order_paid.rights') }}
            @endcomponent
        @endslot
    @endcomponent
@endcomponent
