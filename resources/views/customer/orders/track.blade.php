<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Track Order</title>
  @vite('resources/css/app.css')
</head>

<body class="bg-[#fdf8fb] min-h-screen overflow-x-hidden">

@include('customer.home.sections.navbar')

{{-- Background --}}
<div class="fixed -top-40 -left-40 w-[300px] sm:w-[400px] h-[300px] sm:h-[400px] bg-pink-200/30 rounded-full blur-3xl pointer-events-none z-0"></div>
<div class="fixed -bottom-32 -right-32 w-[250px] sm:w-[350px] h-[250px] sm:h-[350px] bg-fuchsia-200/25 rounded-full blur-3xl pointer-events-none z-0"></div>

<main class="relative z-10 max-w-2xl mx-auto px-3 sm:px-6 py-8 sm:py-12">

  {{-- HERO --}}
  <div class="text-center mb-6 sm:mb-8">
    <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-widest
                 text-white bg-gradient-to-r from-pink-600 to-fuchsia-600
                 px-4 py-1 rounded-full mb-4">
      📦 Order tracking
    </span>

    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight mb-2">
      Track Your
      <span class="bg-gradient-to-r from-pink-600 via-fuchsia-600 to-rose-500 bg-clip-text text-transparent">
        Orders
      </span>
    </h1>

    <p class="text-xs sm:text-sm text-gray-400 max-w-xs mx-auto leading-relaxed">
      Enter your phone number to see all your orders and live status.
    </p>
  </div>

  {{-- SEARCH --}}
  <form method="GET" action="{{ route('order.track') }}"
        class="flex flex-col sm:flex-row gap-2 max-w-md mx-auto mb-8 sm:mb-10">

    <input name="phone"
           value="{{ request('phone') }}"
           placeholder="Enter your phone number…"
           class="flex-1 bg-white border border-pink-100 focus:border-pink-400
                  rounded-full px-5 py-3 text-sm text-gray-800 placeholder-gray-300
                  outline-none transition">

    <button class="w-full sm:w-auto inline-flex items-center justify-center gap-2 text-sm font-semibold text-white
                   bg-gradient-to-r from-pink-600 to-fuchsia-600
                   rounded-full px-6 py-3 hover:opacity-90 transition-opacity">
      🔍 Search
    </button>
  </form>

  {{-- ALERTS --}}
  @if(session('success'))
    <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl px-4 py-3 mb-6">
      ✔ {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="text-sm text-red-600 bg-red-50 border border-red-200 rounded-2xl px-4 py-3 mb-6">
      {{ session('error') }}
    </div>
  @endif

  @if(request('phone') && $orders->isEmpty())
    <div class="text-center border border-dashed border-pink-100 rounded-3xl py-14 mb-6">
      🔍
      <p class="text-sm text-gray-400 mt-2">No orders found for this number.</p>
    </div>
  @endif

  {{-- ORDERS --}}
  <div class="space-y-5">

    @foreach($orders as $order)
      @php
        $steps = ['pending','confirmed','shipped','delivered'];
        $current = array_search($order->status, $steps);
        $icons = ['pending'=>'⏳','confirmed'=>'✓','shipped'=>'🚚','delivered'=>'📦'];
      @endphp

      <div class="bg-white border border-pink-100 rounded-2xl sm:rounded-3xl overflow-hidden">

        {{-- TOP --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 px-4 sm:px-5 pt-4 sm:pt-5 pb-3 sm:pb-4">

          <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-300">Order code</p>
            <p class="text-base font-bold">{{ $order->order_code }}</p>
            <p class="text-[11px] text-gray-400">
              {{ $order->created_at->format('d M Y · h:i A') }}
            </p>
          </div>

          <span class="inline-flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider px-3 py-1.5 rounded-full
            @if($order->status=='pending') bg-yellow-50 text-yellow-700
            @elseif($order->status=='confirmed') bg-blue-50 text-blue-700
            @elseif($order->status=='shipped') bg-fuchsia-50 text-fuchsia-700
            @elseif($order->status=='delivered') bg-green-50 text-green-700
            @else bg-red-50 text-red-600 @endif">
            {{ ucfirst($order->status) }}
          </span>
        </div>

        <div class="h-px bg-pink-50 mx-4 sm:mx-5"></div>

        {{-- PROGRESS --}}
        <div class="px-4 sm:px-5 py-5">

          @if($order->status == 'cancelled')

            <div class="text-center py-4">✖ Cancelled</div>

          @else

            <div class="relative">

              <div class="absolute top-5 left-5 right-5 h-0.5 bg-pink-100"></div>

              <div class="absolute top-5 left-5 h-0.5 bg-gradient-to-r from-pink-600 to-fuchsia-500"
                   style="width: calc({{ ($current / (count($steps)-1)) * 100 }}%)">
              </div>

              <div class="flex justify-between relative z-10 gap-1">

                @foreach($steps as $i => $step)
                  <div class="flex flex-col items-center flex-1">

                    <div class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full text-sm
                      @if($i < $current) bg-pink-600 text-white
                      @elseif($i == $current) border-2 border-pink-500 bg-white
                      @else border border-pink-100 text-gray-300 bg-white @endif">
                      {{ $icons[$step] }}
                    </div>

                    <p class="text-[9px] sm:text-[10px] capitalize text-center
                      @if($i <= $current) text-pink-600 font-semibold @else text-gray-300 @endif">
                      {{ $step }}
                    </p>

                  </div>
                @endforeach

              </div>
            </div>

          @endif
        </div>

        <div class="h-px bg-pink-50 mx-4 sm:mx-5"></div>

        {{-- ITEMS --}}
        <div class="px-4 sm:px-5 py-4 space-y-3">

          @foreach($order->items as $item)
            <div class="flex items-center gap-2 sm:gap-3">

              <img src="{{ asset('storage/products/'.$item->product->image) }}"
                   class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl object-cover">

              <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm font-semibold truncate">
                  {{ $item->product->name }}
                </p>
                <p class="text-[11px] text-gray-400">Qty: {{ $item->quantity }}</p>
              </div>

              <span class="text-sm font-bold">
                {{ number_format($item->total, 2) }} EGP
              </span>

            </div>
          @endforeach

        </div>

        <div class="h-px bg-pink-50 mx-4 sm:mx-5"></div>

        {{-- INFO --}}
        <div class="mx-4 sm:mx-5 my-4 bg-pink-50/60 rounded-2xl p-3 sm:p-4
                    grid grid-cols-1 sm:grid-cols-2 gap-3">

          <div>
            <p class="text-[10px] text-gray-300">Name</p>
            <p class="text-xs font-medium">{{ $order->customer_name }}</p>
          </div>

          <div>
            <p class="text-[10px] text-gray-300">Phone</p>
            <p class="text-xs font-medium">{{ $order->customer_phone1 }}</p>
          </div>

          <div class="sm:col-span-2">
            <p class="text-[10px] text-gray-300">Address</p>
            <p class="text-xs font-medium break-words">{{ $order->address }}</p>
          </div>

          <div>
            <p class="text-[10px] text-gray-300">Shipping</p>
            <p class="text-xs font-medium">{{ number_format($order->shipping_cost, 2) }} EGP</p>
          </div>

        </div>

        <div class="h-px bg-pink-50 mx-4 sm:mx-5"></div>

        {{-- TOTAL --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 px-4 sm:px-5 py-4">

          <span class="text-sm text-gray-400">Order total</span>

          <span class="text-lg sm:text-xl font-extrabold text-transparent bg-clip-text
                       bg-gradient-to-r from-pink-600 to-fuchsia-600">
            {{ number_format($order->total_price, 2) }} EGP
          </span>

        </div>

      </div>

    @endforeach

  </div>

</main>

{{-- MODAL --}}
<div id="cancelModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/40 p-4 z-50">

  <div class="bg-white rounded-2xl p-5 w-full max-w-sm text-center">

    ⚠️
    <h2 class="text-lg font-bold mt-2">Cancel order?</h2>

    <div class="mt-4 flex gap-2">
      <button onclick="closeModal()" class="flex-1 bg-gray-100 rounded-full py-2">
        No
      </button>

      <form id="cancelForm" method="POST" class="flex-1">
        @csrf
        <button class="w-full bg-red-500 text-white rounded-full py-2">
          Yes
        </button>
      </form>
    </div>

  </div>

</div>

<script>
function openModal(url){
  document.getElementById('cancelModal').classList.remove('hidden');
  document.getElementById('cancelModal').classList.add('flex');
  document.getElementById('cancelForm').action = url;
}
function closeModal(){
  document.getElementById('cancelModal').classList.add('hidden');
  document.getElementById('cancelModal').classList.remove('flex');
}
</script>

</body>
</html>