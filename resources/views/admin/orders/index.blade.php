@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')

<div class="max-w-6xl mx-auto bg-white p-8 shadow-md rounded-xl">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Orders</h2>

        <a href="{{ route('admin.orders.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow">
            + Create Order
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto mt-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3 border">Order Code</th>
                    <th class="p-3 border">Customer</th>
                    <th class="p-3 border">Governorate</th>
                    <th class="p-3 border">Total</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($orders as $order)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3 border font-semibold">
                        {{ $order->order_code }}
                    </td>

                    <td class="p-3 border">
                        <div class="font-bold">{{ $order->customer_name }}</div>
                        <div class="text-sm text-gray-600">{{ $order->customer_phone1 }}</div>
                    </td>

                    <td class="p-3 border">
                        {{ $order->governorate->name }}
                    </td>

                    <td class="p-3 border font-semibold">
                        {{ number_format($order->total_price, 2) }} EGP
                    </td>

                    <td class="p-3 border">
                        <span
                            class="px-3 py-1 rounded-lg text-white
                            @if($order->status == 'pending') bg-yellow-600
                            @elseif($order->status == 'confirmed') bg-blue-600
                            @elseif($order->status == 'shipped') bg-indigo-600
                            @elseif($order->status == 'delivered') bg-green-600
                            @else bg-red-600 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td class="p-3 border text-center">

                        <a href="{{ route('admin.orders.show', $order->id) }}"
                            class="px-3 py-1 bg-gray-800 text-white rounded-lg text-sm">
                            View
                        </a>

                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                            class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.orders.destroy', $order->id) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('Delete this order?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm">
                                Delete
                            </button>

                        </form>

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

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

</div>

@endsection
