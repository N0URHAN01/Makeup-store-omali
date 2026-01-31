@extends('admin.layouts.app')

@section('title', 'All Products')

@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-3 sm:px-6 overflow-x-hidden">
    <div class="w-full mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 p-4 sm:p-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-semibold text-gray-800 text-center sm:text-left">All Products</h2>
            <a href="{{ route('admin.products.create') }}"
               class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-4 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all text-center">
                + Add New Product
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-sm text-sm font-medium text-center sm:text-left">
                {{ session('success') }}
            </div>
        @endif

        {{-- Product Cards --}}
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($products as $product)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-transform hover:-translate-y-1 flex flex-col">

                        {{-- Image --}}
                        <div class="relative w-full h-44 bg-gray-50 rounded-t-xl overflow-hidden flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-contain">
                            @else
                                <div class="text-pink-400 font-semibold text-sm">No Image</div>
                            @endif
                            @if($product->discount_percentage > 0)
                                <span class="absolute top-2 left-2 bg-pink-600 text-white text-xs font-bold px-2 py-1 rounded-lg">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="font-semibold text-gray-800 text-base sm:text-lg mb-1 truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-1">Code: <span class="font-mono">{{ $product->product_code }}</span></p>
                                <p class="text-sm text-gray-600 mb-1">Category: {{ $product->category->name ?? '—' }}</p>

                                {{-- Price --}}
                                @if($product->discount_percentage > 0)
                                    @php
                                        $discountedPrice = $product->price * (1 - $product->discount_percentage / 100);
                                    @endphp
                                    <p class="text-gray-400 line-through text-sm">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-pink-600 font-semibold">${{ number_format($discountedPrice, 2) }}</p>
                                @else
                                    <p class="text-gray-900 font-semibold mb-1">${{ number_format($product->price, 2) }}</p>
                                @endif

                                <p class="text-xs text-gray-500">Stock: <span class="font-medium">{{ $product->stock }}</span></p>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('admin.products.show', $product->id) }}"
                                   class="flex-1 text-center bg-blue-100 text-blue-700 hover:bg-blue-200 py-1.5 rounded-md text-sm font-semibold transition">
                                    View
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="flex-1 text-center bg-yellow-100 text-yellow-700 hover:bg-yellow-200 py-1.5 rounded-md text-sm font-semibold transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this product?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full bg-red-100 text-red-700 hover:bg-red-200 py-1.5 rounded-md text-sm font-semibold transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 py-10">No products found.</p>
        @endif

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
