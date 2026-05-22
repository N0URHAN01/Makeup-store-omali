@extends('customer.layouts.app')

@section('content')

<main class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    {{-- HERO --}}
    <div class="text-center mb-10">

        <div class="inline-flex items-center gap-2 rounded-full bg-white border border-pink-100 px-4 py-2 shadow-sm mb-5">
            <span class="w-2 h-2 rounded-full bg-pink-500"></span>
            <span class="text-xs font-bold uppercase tracking-widest text-pink-600">
                Order Tracking
            </span>
        </div>

        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900">
            Track Your
            <span class="bg-gradient-to-r from-pink-600 to-fuchsia-600 bg-clip-text text-transparent">
                Orders
            </span>
        </h1>

    </div>

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('order.track') }}" class="max-w-xl mx-auto mb-10">

        <div class="bg-white border border-pink-100 rounded-3xl p-2 flex gap-2">

            <input type="text"
                   name="phone"
                   value="{{ request('phone') }}"
                   class="flex-1 px-5 py-3 text-sm rounded-2xl border-0"
                   placeholder="Enter phone">

            <button class="px-6 py-3 bg-pink-600 text-white rounded-2xl font-bold">
                Search
            </button>

        </div>

    </form>

    {{-- NO ORDERS --}}
    @if(request('phone') && !$latestOrder)
        <div class="text-center py-16 bg-white border border-dashed border-pink-100 rounded-3xl">
            📦 No Orders Found
        </div>
    @endif


    {{-- LATEST ORDER --}}
    @if($latestOrder)

        @include('customer.orders.components.order-card', [
            'order' => $latestOrder,
            'isLatest' => true
        ])

    @endif


    {{-- PREVIOUS ORDERS --}}
    @if($otherOrders && $otherOrders->count())

        {{-- VIEW BUTTON --}}
        <div id="viewWrapper" class="text-center mt-10">
            <button id="viewBtn"
                    class="px-6 py-3 bg-pink-600 text-white rounded-2xl font-bold">
                View Previous Orders ({{ $otherOrders->count() }})
            </button>
        </div>

        {{-- ORDERS LIST --}}
        <div id="ordersBox" class="hidden mt-8 space-y-6">

            @foreach($otherOrders as $order)

                @include('customer.orders.components.order-card', [
                    'order' => $order
                ])

            @endforeach

            {{-- HIDE BUTTON (BOTTOM UNDER CARDS) --}}
            <div class="text-center mt-6">
                <button id="hideBtn"
                        class="px-6 py-3 bg-gray-900 text-white rounded-2xl font-bold">
                    Hide Orders
                </button>
            </div>

        </div>

    @endif

</main>

{{-- JS (CLEAN & FIXED) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const viewBtn = document.getElementById('viewBtn');
    const hideBtn = document.getElementById('hideBtn');
    const ordersBox = document.getElementById('ordersBox');
    const viewWrapper = document.getElementById('viewWrapper');

    // show previous orders
    viewBtn?.addEventListener('click', function () {
        ordersBox.classList.remove('hidden');
        viewWrapper.classList.add('hidden');
    });

    // hide previous orders
    hideBtn?.addEventListener('click', function () {
        ordersBox.classList.add('hidden');
        viewWrapper.classList.remove('hidden');
    });

});
</script>

@endsection