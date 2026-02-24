<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Order Confirmed</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-white">
@include('customer.home.sections.navbar')

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-14">
  <div class="rounded-3xl border border-gray-200 bg-white p-8 text-center">
    <div class="mx-auto w-14 h-14 rounded-full bg-green-50 flex items-center justify-center">
      ✅
    </div>

    <h1 class="mt-4 text-3xl font-extrabold text-gray-900">Order confirmed</h1>
    <p class="mt-2 text-gray-600">Thanks! Your order has been placed successfully.</p>

    <div class="mt-6 rounded-2xl bg-gray-50 p-4 text-left">
      <p class="text-sm text-gray-600">Order Code</p>
      <p class="text-xl font-extrabold text-gray-900">{{ $order->order_code }}</p>

      <div class="mt-4 flex justify-between text-sm">
        <span class="text-gray-600">Status</span>
        <span class="font-semibold text-gray-900">{{ ucfirst($order->status) }}</span>
      </div>

      <div class="mt-2 flex justify-between text-sm">
        <span class="text-gray-600">Total</span>
        <span class="font-extrabold text-gray-900">{{ number_format($order->total_price,2) }} EGP</span>
      </div>
    </div>

    <a href="{{ route('home') }}"
       class="mt-6 inline-flex rounded-2xl bg-pink-600 px-6 py-3 text-white font-semibold hover:bg-pink-700">
      Back to home
    </a>
  </div>
</main>
</body>
</html>