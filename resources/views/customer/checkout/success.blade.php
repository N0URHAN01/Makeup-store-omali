@extends('customer.layouts.app')

@section('title', 'Order Confirmed')

@section('content')

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-14">

  <div class="rounded-3xl border border-gray-200 bg-white p-8">

    {{-- SUCCESS ICON --}}
    <div class="text-center">
      <div class="mx-auto w-14 h-14 rounded-full bg-green-50 flex items-center justify-center">
        ✅
      </div>

      <h1 class="mt-4 text-3xl font-extrabold text-gray-900">
        Order confirmed
      </h1>

      <p class="mt-2 text-gray-600">
        Thanks! Your order has been placed successfully.
      </p>
    </div>

    {{-- ORDER INFO --}}
    <div class="mt-6 rounded-2xl bg-gray-50 p-4">

      <p class="text-sm text-gray-600">Order Code</p>
      <p class="text-xl font-extrabold text-gray-900">
        {{ $order->order_code }}
      </p>

      <div class="mt-4 flex justify-between text-sm">
        <span class="text-gray-600">Status</span>
        <span class="font-semibold text-gray-900">
          {{ ucfirst($order->status) }}
        </span>
      </div>

      {{-- CUSTOMER INFO --}}
      <div class="mt-6 border-t pt-4 text-sm space-y-2">
        <p class="font-semibold text-gray-700">Customer Info</p>

        <div class="flex justify-between">
          <span class="text-gray-600">Phone</span>
          <span class="font-semibold text-gray-900">
            {{ $order->customer_phone1 }}
            @if($order->customer_phone2)
              - {{ $order->customer_phone2 }}
            @endif
          </span>
        </div>

        <div class="flex justify-between">
          <span class="text-gray-600">Address</span>
          <span class="font-semibold text-gray-900 text-right">
            {{ $order->address }}
          </span>
        </div>
      </div>

      {{-- PRODUCTS --}}
      <div class="mt-6 border-t pt-4">
        <p class="text-sm font-semibold text-gray-700 mb-3">Items</p>

        @foreach($order->items as $item)
          <div class="flex items-center justify-between gap-3 mt-3">

            {{-- IMAGE + NAME --}}
            <div class="flex items-center gap-3">


                   <img 
  src="{{ $item->variant && $item->variant->image 
            ? asset('storage/' . $item->variant->image) 
            : asset('storage/' . $item->product->image) }}"
  class="w-12 h-12 object-cover rounded-lg border">
              <div class="text-sm">

                <p class="font-semibold text-gray-900">
                  {{ $item->product->name }}
                </p>

                {{-- VARIANT --}}
                @if($item->variant)
                  <div class="flex items-center gap-1 text-xs text-gray-500">
                    <span class="w-2.5 h-2.5 rounded-full border"
                          style="background: {{ $item->variant->color_code }}"></span>

                    {{ $item->variant->color_name }}
                  </div>
                @endif

                <p class="text-gray-500">
                  Qty: {{ $item->quantity }}
                </p>

              </div>
            </div>

            {{-- PRICE --}}
            <span class="text-sm font-semibold text-gray-900">
              {{ number_format($item->total,2) }} EGP
            </span>

          </div>
        @endforeach
      </div>

      {{-- SHIPPING --}}
      <div class="mt-6 border-t pt-4 flex justify-between text-sm">
        <span class="text-gray-600">Shipping</span>
        <span class="font-semibold text-gray-900">
          {{ number_format($order->shipping_cost,2) }} EGP
        </span>
      </div>

      {{-- TOTAL --}}
      <div class="mt-2 flex justify-between text-sm">
        <span class="text-gray-600">Total</span>
        <span class="font-extrabold text-gray-900">
          {{ number_format($order->total_price,2) }} EGP
        </span>
      </div>

    </div>

    {{-- ACTIONS --}}
    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">

      <a href="{{ route('home') }}"
         class="inline-flex justify-center rounded-2xl bg-pink-600 px-6 py-3 text-white font-semibold hover:bg-pink-700">
        Back to home
      </a>

      {{-- TRACK ORDER BUTTON  --}}
      <a href="{{ route('order.track', ['phone' => $order->customer_phone1]) }}"
         class="inline-flex justify-center rounded-2xl border border-gray-300 px-6 py-3 text-gray-700 font-semibold hover:bg-gray-100">
        Track Order
      </a>

    </div>

  </div>

</main>

@endsection