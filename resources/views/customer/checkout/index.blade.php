<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Checkout</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-white">
@include('customer.home.sections.navbar')

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <h1 class="text-3xl font-extrabold text-gray-900">Checkout</h1>

  @if(session('error'))
    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}</div>
  @endif

  <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <form action="{{ route('checkout.store') }}" method="POST" class="lg:col-span-2 rounded-3xl border border-gray-200 p-6">
      @csrf

      <h2 class="text-lg font-extrabold text-gray-900">Customer Info</h2>

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold text-gray-700">Name</label>
          <input name="customer_name" value="{{ old('customer_name') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
          @error('customer_name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">Email (optional)</label>
          <input name="customer_email" value="{{ old('customer_email') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400">
          @error('customer_email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">Phone 1</label>
          <input name="customer_phone1" value="{{ old('customer_phone1') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
          @error('customer_phone1')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">Phone 2</label>
          <input name="customer_phone2" value="{{ old('customer_phone2') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400">
          @error('customer_phone2')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <h2 class="text-lg font-extrabold text-gray-900 mt-8">Delivery</h2>

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold text-gray-700">Governorate</label>
          <select name="governorate_id"
                  class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
            <option value="">Select</option>
            @foreach($governorates as $g)
              <option value="{{ $g->id }}" @selected(old('governorate_id') == $g->id)>{{ $g->name }}</option>
            @endforeach
          </select>
          @error('governorate_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="text-sm font-semibold text-gray-700">Address</label>
          <input name="address" value="{{ old('address') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
          @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="mt-4">
        <label class="text-sm font-semibold text-gray-700">Notes (optional)</label>
        <textarea name="notes" rows="3"
                  class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400">{{ old('notes') }}</textarea>
        @error('notes')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
      </div>

      <button class="mt-6 w-full rounded-2xl bg-pink-600 px-4 py-3 text-white font-semibold hover:bg-pink-700">
        Confirm order
      </button>

      <p class="mt-3 text-xs text-gray-500 text-center">
        Payment: Cash on delivery (COD)
      </p>
    </form>

    {{-- Order summary --}}
    <div class="rounded-3xl border border-gray-200 p-6 h-fit">
      <h2 class="text-lg font-extrabold text-gray-900">Order Summary</h2>

      <div class="mt-4 space-y-3">
        @foreach($cart as $item)
          <div class="flex justify-between text-sm">
            <span class="text-gray-700">{{ $item['name'] }} × {{ $item['qty'] }}</span>
            <span class="font-semibold text-gray-900">{{ number_format($item['price'] * $item['qty'],2) }} EGP</span>
          </div>
        @endforeach
      </div>

      <div class="mt-5 border-t pt-4 flex justify-between">
        <span class="text-gray-700 font-semibold">Subtotal</span>
        <span class="text-gray-900 font-extrabold">{{ number_format($subtotal,2) }} EGP</span>
      </div>

      <p class="mt-2 text-xs text-gray-500">Shipping will be added based on governorate.</p>
    </div>
  </div>
</main>
</body>
</html>