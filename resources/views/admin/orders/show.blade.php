@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-10 rounded-2xl shadow-lg border border-gray-200">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold tracking-wide text-gray-800">
            Order #{{ $order->order_code }}
        </h2>

        <span class="px-4 py-2 rounded-full text-sm font-semibold
            @if($order->status == 'pending') bg-yellow-100 text-yellow-700 
            @elseif($order->status == 'confirmed') bg-blue-100 text-blue-700
            @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
            @elseif($order->status == 'delivered') bg-green-100 text-green-700
            @elseif($order->status == 'cancelled') bg-red-100 text-red-700
            @else bg-gray-100 text-gray-600
            @endif
        ">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    {{-- CUSTOMER SECTION --}}
    <div class="mb-10">
        <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
            Customer Information
        </h3>

        <div class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
            <div><strong>Name:</strong> {{ $order->customer_name }}</div>
            <div><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</div>
            <div><strong>Phone 1:</strong> {{ $order->customer_phone1 }}</div>
            <div><strong>Phone 2:</strong> {{ $order->customer_phone2 ?? '-' }}</div>
            <div class="col-span-2"><strong>Address:</strong> {{ $order->address }}</div>
        </div>

        <div class="mt-3 text-gray-700">
            <strong>Governorate:</strong> {{ $order->governorate->name ?? '-' }} 
            <span class="text-sm text-gray-500">
                (Shipping: {{ number_format($order->shipping_cost,2) }} EGP)
            </span>
        </div>

        <div class="mt-3 text-gray-700 text-sm">
            <strong>Notes:</strong> {{ $order->notes ?? '-' }}
        </div>
    </div>

    {{-- ORDER ITEMS --}}
    <div class="mb-10">
        <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
            Order Items
        </h3>

        @if($order->items->count() > 0)

        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium text-gray-600">Product</th>
                        <th class="py-3 px-4 text-center font-medium text-gray-600 w-20">Qty</th>
                        <th class="py-3 px-4 text-right font-medium text-gray-600 w-32">Price</th>
                        <th class="py-3 px-4 text-right font-medium text-gray-600 w-32">Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-4 flex items-center gap-4">
                            
                            {{-- IMAGE --}}
                            <div class="w-14 h-14 bg-white p-1 rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                <img 
                                    src="{{ asset('storage/' . $item->product->image) }}" 
                                    class="w-full h-full object-contain"
                                >
                            </div>

                            <span class="font-medium text-gray-800 text-sm leading-5">
                                {{ $item->product->name }}
                            </span>
                        </td>

                        <td class="py-4 px-4 text-center font-medium text-gray-800">
                            {{ $item->quantity }}
                        </td>

                        <td class="py-4 px-4 text-right text-gray-600">
                            {{ number_format($item->price, 2) }}
                        </td>

                        <td class="py-4 px-4 text-right font-semibold text-green-600">
                            {{ number_format($item->total, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        <p class="text-gray-500">No items in this order.</p>
        @endif
    </div>

    {{-- TOTALS --}}
    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 text-gray-700 text-sm">
        <div class="flex justify-between mb-2">
            <span>Subtotal:</span>
            <span class="font-medium">{{ number_format($order->items->sum('total'), 2) }} EGP</span>
        </div>

        <div class="flex justify-between mb-2">
            <span>Shipping:</span>
            <span class="font-medium">{{ number_format($order->shipping_cost, 2) }} EGP</span>
        </div>

        <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
            <span class="font-bold text-lg text-gray-900">Total:</span>
            <span class="font-bold text-lg text-gray-900">{{ number_format($order->total_price, 2) }} EGP</span>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="mt-8">
        <a href="{{ route('admin.orders.index') }}" 
           class="inline-block bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg shadow-sm transition">
            ← Back to Orders
        </a>
    </div>

</div>
@endsection
