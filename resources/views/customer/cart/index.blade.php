<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Cart</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-white">
@include('customer.home.sections.navbar')

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <div class="flex items-end justify-between mb-6">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-900">Your Cart</h1>
      <p class="text-gray-500 mt-1">{{ $count }} item(s)</p>
    </div>

    @if($count)
      <form action="{{ route('cart.clear') }}" method="POST">
        @csrf @method('DELETE')
        <button class="text-sm font-semibold text-gray-600 hover:text-red-600">Clear cart</button>
      </form>
    @endif
  </div>

  @if(session('error'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
  @endif

  @if(empty($cart))
    <div class="rounded-2xl border border-gray-200 p-8 text-center">
      <p class="text-gray-600">Your cart is empty.</p>
      <a href="{{ route('home') }}" class="mt-4 inline-flex rounded-xl bg-pink-600 px-5 py-3 text-white font-semibold hover:bg-pink-700">
        Continue shopping
      </a>
    </div>
  @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Items --}}
      <div class="lg:col-span-2 space-y-4">
        @foreach($cart as $item)
          <div class="rounded-3xl border border-gray-200 bg-white p-4 flex gap-4">
            <div class="w-24 h-24 rounded-2xl bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
              @if($item['image'])
                <img src="{{ $item['image'] }}" class="w-full h-full object-contain p-2" alt="">
              @else
                <span class="text-xs text-gray-400">No image</span>
              @endif
            </div>

            <div class="flex-1">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <p class="font-semibold text-gray-900">{{ $item['name'] }}</p>
                  <p class="text-sm text-gray-500 mt-1">{{ number_format($item['price'],2) }} EGP</p>
                </div>

                <form action="{{ route('cart.remove') }}" method="POST">
                  @csrf @method('DELETE')
                  <input type="hidden" name="key" value="{{ $item['key'] }}">
                  <button class="text-sm font-semibold text-gray-500 hover:text-red-600">Remove</button>
                </form>
              </div>

              <div class="mt-4 flex items-center justify-between">
                <div class="inline-flex items-center rounded-2xl border border-gray-200 overflow-hidden">
                  <form action="{{ route('cart.decrement') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $item['key'] }}">
                    <button class="px-3 py-2 hover:bg-gray-50">−</button>
                  </form>

                  <div class="px-4 py-2 text-sm font-semibold">{{ $item['qty'] }}</div>

                  <form action="{{ route('cart.increment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $item['key'] }}">
                    <button class="px-3 py-2 hover:bg-gray-50">+</button>
                  </form>
                </div>

                <p class="font-extrabold text-gray-900">
                  {{ number_format($item['price'] * $item['qty'], 2) }} EGP
                </p>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Summary --}}
      <div class="rounded-3xl border border-gray-200 bg-white p-5 h-fit">
        <h3 class="text-lg font-extrabold text-gray-900">Summary</h3>

        <div class="mt-4 space-y-2 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-600">Subtotal</span>
            <span class="font-semibold text-gray-900">{{ number_format($subtotal,2) }} EGP</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Shipping</span>
            <span class="text-gray-500">Calculated at checkout</span>
          </div>
        </div>

        <a href="{{ route('checkout.index') }}"
           class="mt-5 w-full inline-flex items-center justify-center rounded-2xl bg-pink-600 px-4 py-3 text-white font-semibold hover:bg-pink-700">
          Checkout
        </a>

        <a href="{{ route('home') }}" class="mt-3 block text-center text-sm font-semibold text-gray-600 hover:text-pink-700">
          Continue shopping
        </a>
      </div>
    </div>
  @endif
</main>
</body>
</html>