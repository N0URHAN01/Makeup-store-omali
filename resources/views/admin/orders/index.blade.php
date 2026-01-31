@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')

<div class="max-w-6xl mx-auto bg-white p-8 shadow-md rounded-2xl border border-pink-200">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Orders</h2>
        <a href="{{ route('admin.orders.create') }}"
           class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg shadow transition">
            + Create Order
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="overflow-x-auto mt-4">
        <table class="w-full text-sm border-collapse rounded-lg overflow-hidden">
            <thead class="bg-pink-50">
                <tr>
                    <th class="p-3 text-left font-medium text-gray-700">Order Code</th>
                    <th class="p-3 text-left font-medium text-gray-700">Customer</th>
                    <th class="p-3 text-left font-medium text-gray-700">Governorate</th>
                    <th class="p-3 text-left font-medium text-gray-700">Total</th>
                    <th class="p-3 text-left font-medium text-gray-700">Status</th>
                    <th class="p-3 text-center font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-pink-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-pink-50 transition cursor-pointer rounded-lg"
                        onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">

                        <td class="p-3 font-semibold text-gray-800">
                            {{ $order->order_code }}
                        </td>

                        <td class="p-3 text-gray-700">
                            <div class="font-medium">{{ $order->customer_name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->customer_phone1 }}</div>
                        </td>

                        <td class="p-3 text-gray-700">
                            {{ $order->governorate->name ?? '-' }}
                        </td>

                        <td class="p-3 font-semibold text-gray-800">
                            {{ number_format($order->total_price, 2) }} EGP
                        </td>

                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800
                                @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td class="p-3 text-center space-x-2">
                            <div class="inline-flex space-x-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="px-3 py-1 bg-pink-100 hover:bg-pink-200 text-pink-800 rounded-lg text-xs transition"
                                   onclick="event.stopPropagation();">
                                   View
                                </a>

                                <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                   class="px-3 py-1 bg-purple-100 hover:bg-purple-200 text-purple-800 rounded-lg text-xs transition"
                                   onclick="event.stopPropagation();">
                                   Edit
                                </a>

                               <form action="{{ route('admin.orders.destroy', $order->id) }}" 
      method="POST" class="inline-block"
      onsubmit="event.stopPropagation(); return confirm('Delete this order?') ? true : false;">
    @csrf
    @method('DELETE')
    <button type="submit" 
            class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-800 rounded-lg text-xs transition"
            onclick="event.stopPropagation();">
        Delete
    </button>
</form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

</div>

@endsection
