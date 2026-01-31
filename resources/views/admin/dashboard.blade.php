@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-3 sm:px-6">

    <div class="max-w-7xl mx-auto"> 
        {{-- Metrics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 mb-8">
            
            {{-- Total Products --}}
            <div class="bg-gradient-to-r from-pink-400 to-pink-500 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Total Products</p>
                    <h2 class="text-2xl font-bold">{{ $totalProducts }}</h2>
                </div>
                <div class="text-white opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0H4m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2"/>
                    </svg>
                </div>
            </div>

            {{-- Total Orders --}}
            <div class="bg-gradient-to-r from-purple-400 to-purple-500 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Total Orders</p>
                    <h2 class="text-2xl font-bold">{{ $totalOrders }}</h2>
                </div>
                <div class="text-white opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/>
                    </svg>
                </div>
            </div>

            {{-- Total Revenue --}}
            <div class="bg-gradient-to-r from-green-400 to-green-500 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Revenue</p>
                    <h2 class="text-2xl font-bold">{{ number_format($totalRevenue, 2) }} EGP</h2>
                </div>
                <div class="text-white opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 2v4m0 12v4m8-8h-4M4 12H0"/>
                    </svg>
                </div>
            </div>

            {{-- Low Stock --}}
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Low Stock</p>
                    <h2 class="text-2xl font-bold">{{ $lowStock }}</h2>
                </div>
                <div class="text-white opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Active Discounts --}}
            <div class="bg-gradient-to-r from-pink-600 to-pink-700 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transition flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Active Discounts</p>
                    <h2 class="text-2xl font-bold">{{ $activeDiscounts }}</h2>
                </div>
                <div class="text-white opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 7h10M7 12h4m1 8a9 9 0 100-18 9 9 0 000 18z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Latest Orders --}}
        <div class="mb-8 bg-white rounded-2xl shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Latest Orders</h3>
            @if($latestOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-pink-50">
                            <tr>
                                <th class="p-3 text-left font-medium text-gray-700">Order Code</th>
                                <th class="p-3 text-left font-medium text-gray-700">Customer</th>
                                <th class="p-3 text-left font-medium text-gray-700">Status</th>
                                <th class="p-3 text-left font-medium text-gray-700">Total</th>
                                <th class="p-3 text-left font-medium text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($latestOrders as $order)
                                <tr class="hover:bg-pink-50 cursor-pointer transition"
                                    onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">
                                    <td class="p-3 font-semibold text-gray-800">{{ $order->order_code }}</td>
                                    <td class="p-3 text-gray-700">{{ $order->customer_name }}</td>
                                    <td class="p-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
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
                                    <td class="p-3 font-semibold text-gray-800">{{ number_format($order->total_price, 2) }} EGP</td>
                                    <td class="p-3 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500 py-6">No recent orders.</p>
            @endif
        </div>

        {{-- Low Stock Products --}}
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Low Stock Products</h3>
            @if($lowStockProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($lowStockProducts as $product)
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition flex flex-col">
                            <div class="relative w-full h-44 bg-gray-50 rounded-t-xl overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                @else
                                    <div class="flex items-center justify-center h-full text-pink-400 font-semibold text-sm">No Image</div>
                                @endif
                                @if($product->discount_percentage > 0)
                                    <span class="absolute top-2 left-2 bg-pink-600 text-white text-xs font-bold px-2 py-1 rounded-lg">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col justify-between flex-1">
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-1 truncate">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500 mb-1">Code: <span class="font-mono">{{ $product->product_code }}</span></p>
                                    @if($product->discount_percentage > 0)
                                        <p class="text-sm text-gray-400 line-through mb-1">${{ number_format($product->price, 2) }}</p>
                                        <p class="text-gray-900 font-semibold mb-1">${{ number_format($product->price * (1 - $product->discount_percentage / 100), 2) }}</p>
                                    @else
                                        <p class="text-gray-900 font-semibold mb-1">${{ number_format($product->price, 2) }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500">Stock: <span class="font-medium">{{ $product->stock }}</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-6">No low stock products.</p>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.products.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white rounded-xl py-3 font-semibold text-center shadow-md hover:shadow-lg transition">
                + Add Product
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white rounded-xl py-3 font-semibold text-center shadow-md hover:shadow-lg transition">
                Categories
            </a>
            <a href="{{ route('admin.orders.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white rounded-xl py-3 font-semibold text-center shadow-md hover:shadow-lg transition">
                Orders
            </a>
            <a href="{{ route('admin.governorates.index') }}" class="bg-green-500 hover:bg-green-600 text-white rounded-xl py-3 font-semibold text-center shadow-md hover:shadow-lg transition">
                Governorates
            </a>
        </div>

    </div>

</div>
@endsection
