@extends('customer.layouts.app')

@section('title', 'Cart')

@section('content')

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

  {{-- HEADER --}}
  <div class="flex items-end justify-between mb-6">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-900">Your Cart</h1>
      <p class="text-gray-500 mt-1">{{ $count }} item(s)</p>
    </div>

    @if($count)
      <form action="{{ route('cart.clear') }}" method="POST">
        @csrf @method('DELETE')
        <button class="text-sm font-semibold text-gray-600 hover:text-red-600 transition">
          Clear cart
        </button>
      </form>
    @endif
  </div>

  {{-- ALERTS --}}
  @if(session('error'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
      {{ session('error') }}
    </div>
  @endif

  @if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-700">
      {{ session('success') }}
    </div>
  @endif

  {{-- EMPTY --}}
  @if(empty($cart))
    <div class="rounded-3xl border border-gray-200 p-10 text-center">
      <p class="text-gray-600 text-lg">Your cart is empty.</p>

      <a href="{{ route('home') }}"
         class="mt-5 inline-flex rounded-2xl bg-pink-600 px-6 py-3 text-white font-semibold hover:bg-pink-700 transition">
        Continue shopping
      </a>
    </div>

  @else

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- ================= ITEMS ================= --}}
      <div class="lg:col-span-2 space-y-4">

        @foreach($cart as $item)

          <div class="rounded-3xl border border-gray-200 bg-white p-4 flex gap-4
                      hover:shadow-md transition">

            {{-- IMAGE --}}
            <div class="w-24 h-24 rounded-2xl bg-gray-50 border border-gray-100
                        overflow-hidden flex items-center justify-center">

              @if($item['image'])
                <img src="{{ $item['image'] }}"
                     class="w-full h-full object-contain p-2">
              @else
                <span class="text-xs text-gray-400">No image</span>
              @endif

            </div>

            {{-- INFO --}}
            <div class="flex-1">

              {{-- TOP --}}
              <div class="flex items-start justify-between gap-4">

                <div>

                  <p class="font-semibold text-gray-900">
                    {{ $item['name'] }}
                  </p>

                  {{-- 🔥 VARIANT --}}
                  @if(!empty($item['variant_name']))
                    <div class="flex items-center gap-2 mt-1">
                      <span class="w-3 h-3 rounded-full border"
                            style="background: {{ $item['variant_color'] }}">
                      </span>

                      <span class="text-xs text-gray-500 font-medium">
                        {{ $item['variant_name'] }}
                      </span>
                    </div>
                  @endif

                  <p class="text-sm text-gray-500 mt-1">
                    {{ number_format($item['price'],2) }} EGP
                  </p>

                </div>

                {{-- REMOVE --}}
                <form action="{{ route('cart.remove') }}" method="POST">
                  @csrf @method('DELETE')
                  <input type="hidden" name="key" value="{{ $item['key'] }}">

                  <button class="text-sm font-semibold text-gray-400 hover:text-red-600 transition">
                    ✕
                  </button>
                </form>

              </div>

              {{-- BOTTOM --}}
              <div class="mt-4 flex items-center justify-between">

                {{-- QTY --}}
                <div class="inline-flex items-center rounded-2xl border border-gray-200 overflow-hidden">

                  <form action="{{ route('cart.decrement') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $item['key'] }}">
                    <button class="px-3 py-2 hover:bg-gray-50 transition">−</button>
                  </form>

                  <div class="px-4 py-2 text-sm font-semibold">
                    {{ $item['qty'] }}
                  </div>

                  <form action="{{ route('cart.increment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $item['key'] }}">
                    <button class="px-3 py-2 hover:bg-gray-50 transition">+</button>
                  </form>

                </div>

                {{-- TOTAL --}}
                <p class="font-extrabold text-gray-900">
                  {{ number_format($item['price'] * $item['qty'], 2) }} EGP
                </p>

              </div>

            </div>
          </div>

        @endforeach

      </div>

      {{-- ================= SUMMARY ================= --}}
      <div class="rounded-3xl border border-gray-200 bg-white p-5 h-fit sticky top-24">

        <h3 class="text-lg font-extrabold text-gray-900">
          Summary
        </h3>

        <div class="mt-4 space-y-3 text-sm">

          <div class="flex justify-between">
            <span class="text-gray-600">Subtotal</span>
            <span class="font-semibold text-gray-900">
              {{ number_format($subtotal,2) }} EGP
            </span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-600">Shipping</span>
            <span class="text-gray-400 text-xs">
              Calculated at checkout
            </span>
          </div>

        </div>

        {{-- CHECKOUT --}}
        <a href="{{ route('checkout.index') }}"
           class="mt-6 w-full inline-flex items-center justify-center rounded-2xl
                  bg-gradient-to-r from-pink-600 to-fuchsia-600
                  text-white font-bold py-3 hover:opacity-90 transition">
          Checkout
        </a>

        <a href="{{ route('home') }}"
           class="mt-3 block text-center text-sm font-semibold text-gray-600 hover:text-pink-700">
          Continue shopping
        </a>

      </div>

    </div>

  @endif

</main>

@endsection