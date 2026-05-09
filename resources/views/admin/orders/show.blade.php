@extends('admin.layouts.app')

@php
use App\Enums\OrderStatus;
@endphp

@section('title', 'Order Details')

@section('content')

<div class="max-w-6xl mx-auto bg-white p-6 md:p-10 rounded-2xl shadow-lg border border-gray-200">

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

        <div>
            <h2 class="text-2xl md:text-3xl font-bold tracking-wide text-gray-800">
                Order #{{ $order->order_code }}
            </h2>

            <p class="text-sm text-gray-400 mt-1">
                Created {{ $order->created_at->format('d M Y - h:i A') }}
            </p>
        </div>

        <div class="flex flex-col items-start lg:items-end gap-3">

            {{-- CURRENT STATUS --}}
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                {{ OrderStatus::color($order->status) }}">

                {{ OrderStatus::label($order->status) }}
            </span>

            {{-- QUICK STATUS UPDATE --}}
            <form method="POST"
                  action="{{ route('admin.orders.update', $order->id) }}"
                  class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">

                @csrf
                @method('PUT')

                {{-- REQUIRED HIDDEN FIELDS --}}
                <input type="hidden" name="customer_name" value="{{ $order->customer_name }}">
                <input type="hidden" name="customer_email" value="{{ $order->customer_email }}">
                <input type="hidden" name="customer_phone1" value="{{ $order->customer_phone1 }}">
                <input type="hidden" name="customer_phone2" value="{{ $order->customer_phone2 }}">
                <input type="hidden" name="address" value="{{ $order->address }}">
                <input type="hidden" name="notes" value="{{ $order->notes }}">
                <input type="hidden" name="governorate_id" value="{{ $order->governorate_id }}">

                <select name="status"
                        class="border border-gray-300 rounded-xl px-4 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-pink-400">

                    @foreach(OrderStatus::all() as $status)
                        <option value="{{ $status }}"
                            @selected($order->status === $status)>

                            {{ OrderStatus::label($status) }}

                        </option>
                    @endforeach

                </select>

                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white
                               px-5 py-2 rounded-xl text-sm font-semibold transition">
                    Update Status
                </button>

            </form>

        </div>

    </div>

    {{-- CUSTOMER SECTION --}}
    <div class="mb-10">

        <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
            Customer Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 text-sm">

            <div>
                <strong>Name:</strong>
                {{ $order->customer_name }}
            </div>

            <div>
                <strong>Email:</strong>
                {{ $order->customer_email ?? '-' }}
            </div>

            <div>
                <strong>Phone 1:</strong>
                {{ $order->customer_phone1 }}
            </div>

            <div>
                <strong>Phone 2:</strong>
                {{ $order->customer_phone2 ?? '-' }}
            </div>

            <div class="md:col-span-2">
                <strong>Address:</strong>
                {{ $order->address }}
            </div>

        </div>

        <div class="mt-4 text-gray-700 text-sm">

            <strong>Governorate:</strong>
            {{ $order->governorate->name ?? '-' }}

            <span class="text-gray-500">
                (Shipping: {{ number_format($order->shipping_cost, 2) }} EGP)
            </span>

        </div>

        <div class="mt-3 text-gray-700 text-sm">
            <strong>Notes:</strong>
            {{ $order->notes ?? '-' }}
        </div>

    </div>

    {{-- ORDER ITEMS --}}
    <div class="mb-10">

        <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
            Order Items
        </h3>

        @if($order->items->count() > 0)

            <div class="overflow-x-auto rounded-xl border border-gray-200">

                <table class="w-full text-sm min-w-[650px]">

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>
                            <th class="py-3 px-4 text-left font-medium text-gray-600">
                                Product
                            </th>

                            <th class="py-3 px-4 text-center font-medium text-gray-600 w-24">
                                Qty
                            </th>

                            <th class="py-3 px-4 text-right font-medium text-gray-600 w-32">
                                Price
                            </th>

                            <th class="py-3 px-4 text-right font-medium text-gray-600 w-32">
                                Total
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($order->items as $item)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="py-4 px-4">

                                    <div class="flex items-center gap-4">

                                        {{-- IMAGE --}}
                                        <div class="w-14 h-14 bg-white p-1 rounded-lg shadow-sm border border-gray-100 overflow-hidden shrink-0">

                                            <img
                                                src="{{ asset('storage/' . $item->product->image) }}"
                                                class="w-full h-full object-contain"
                                                alt="{{ $item->product->name }}"
                                            >

                                        </div>

                                        <span class="font-medium text-gray-800 text-sm leading-5">
                                            {{ $item->product->name }}
                                        </span>

                                    </div>

                                </td>

                                <td class="py-4 px-4 text-center font-medium text-gray-800">
                                    {{ $item->quantity }}
                                </td>

                                <td class="py-4 px-4 text-right text-gray-600">
                                    {{ number_format($item->price, 2) }} EGP
                                </td>

                                <td class="py-4 px-4 text-right font-semibold text-green-600">
                                    {{ number_format($item->total, 2) }} EGP
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <p class="text-gray-500">
                No items in this order.
            </p>

        @endif

    </div>

    {{-- TOTALS --}}
    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 text-gray-700 text-sm">

        <div class="flex justify-between mb-3">
            <span>Subtotal:</span>

            <span class="font-medium">
                {{ number_format($order->items->sum('total'), 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between mb-3">
            <span>Shipping:</span>

            <span class="font-medium">
                {{ number_format($order->shipping_cost, 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">

            <span class="font-bold text-lg text-gray-900">
                Total:
            </span>

            <span class="font-bold text-lg text-gray-900">
                {{ number_format($order->total_price, 2) }} EGP
            </span>

        </div>

    </div>

    {{-- FOOTER --}}
    <div class="mt-8 flex flex-wrap gap-3">

        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center justify-center
                  bg-gray-700 hover:bg-gray-800 text-white
                  px-6 py-2 rounded-xl shadow-sm transition">

            ← Back to Orders

        </a>

        <a href="{{ route('admin.orders.edit', $order->id) }}"
           class="inline-flex items-center justify-center
                  bg-pink-500 hover:bg-pink-600 text-white
                  px-6 py-2 rounded-xl shadow-sm transition">

            Edit Full Order

        </a>

    </div>

</div>

@endsection