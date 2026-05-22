@php
    $steps = ['pending','confirmed','shipped','delivered'];
    $current = array_search($order->status, $steps);

    $icons = [
        'pending' => '⏳',
        'confirmed' => '✓',
        'shipped' => '🚚',
        'delivered' => '📦'
    ];
@endphp

<div class="bg-white border border-pink-100 rounded-[30px] overflow-hidden shadow-sm">

    {{-- HEADER --}}
    <div class="p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <p class="{{ $isLatest ?? false ? 'text-pink-500' : 'text-gray-400' }} text-xs uppercase tracking-widest">
                {{ $isLatest ?? false ? 'Latest Order' : 'Order' }}
            </p>

            <h2 class="text-xl font-extrabold text-gray-900 mt-1">
                {{ $order->order_code }}
            </h2>

            <p class="text-xs text-gray-400 mt-2">
                {{ $order->created_at->format('d M Y • h:i A') }}
            </p>
        </div>

        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider
            @if($order->status == 'pending')
                bg-yellow-50 text-yellow-700 border border-yellow-100
            @elseif($order->status == 'confirmed')
                bg-blue-50 text-blue-700 border border-blue-100
            @elseif($order->status == 'shipped')
                bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-100
            @elseif($order->status == 'delivered')
                bg-green-50 text-green-700 border border-green-100
            @else
                bg-red-50 text-red-600 border border-red-100
            @endif">

            {{ ucfirst($order->status) }}

        </span>

    </div>

    {{-- PROGRESS --}}
    @if($order->status != 'cancelled')
    <div class="px-6 pb-6">

        <div class="relative">

            <div class="absolute top-5 left-0 right-0 h-1 bg-pink-100 rounded-full"></div>

            <div class="absolute top-5 left-0 h-1 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-600"
                 style="width: calc({{ ($current / (count($steps)-1)) * 100 }}%)">
            </div>

            <div class="relative flex justify-between">

                @foreach($steps as $i => $step)

                    <div class="flex flex-col items-center">

                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                            @if($i < $current)
                                bg-pink-600 text-white
                            @elseif($i == $current)
                                bg-white border-2 border-pink-500
                            @else
                                bg-white border border-pink-100 text-gray-300
                            @endif">

                            {{ $icons[$step] }}

                        </div>

                        <p class="mt-2 text-[11px] font-semibold capitalize
                            @if($i <= $current)
                                text-pink-600
                            @else
                                text-gray-300
                            @endif">

                            {{ $step }}

                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </div>
    @endif


    {{-- ITEMS --}}
    <div class="px-6 pb-6 space-y-4">

        @foreach($order->items as $item)

            @php
                $variant = $item->variant;

                if ($variant && $variant->image) {
                    $image = asset('storage/' . $variant->image);
                } elseif ($item->product->image) {
                    $image = asset('storage/' . $item->product->image);
                } else {
                    $image = 'https://via.placeholder.com/150';
                }
            @endphp

            <div class="rounded-3xl border border-pink-50 bg-pink-50/40 p-4">

                <div class="flex items-center gap-4">

                    <img src="{{ $image }}"
                         class="w-16 h-16 rounded-2xl object-cover border border-pink-100">

                    <div class="flex-1 min-w-0">

                        <h3 class="text-sm font-extrabold text-gray-800 truncate">
                            {{ $item->product->name }}
                        </h3>

                        @if($variant)
                            <div class="flex items-center gap-2 mt-2">

                                @if($variant->color_code)
                                    <span class="w-3 h-3 rounded-full border"
                                          style="background: {{ $variant->color_code }}"></span>
                                @endif

                                <span class="text-xs font-semibold text-pink-600">
                                    {{ $variant->color_name }}
                                </span>

                            </div>
                        @endif

                        <p class="text-xs text-gray-400 mt-2">
                            Qty: {{ $item->quantity }}
                        </p>

                    </div>

                    <div class="text-right">
                        <p class="text-sm font-extrabold text-gray-900">
                            {{ number_format($item->total, 2) }}
                        </p>
                        <p class="text-xs text-gray-400">EGP</p>
                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>