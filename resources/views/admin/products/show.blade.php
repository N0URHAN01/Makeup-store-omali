@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-pink-700">💖 Product Details</h2>
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 bg-pink-100 text-pink-700 rounded-lg hover:bg-pink-200 transition">← Back</a>
    </div>

    {{-- Product Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Left: Product Main Image --}}
        <div>
            <h3 class="font-semibold text-pink-600 mb-3">Main Image</h3>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="w-full h-64 object-cover rounded-lg border border-pink-200">
            @else
                <p class="text-gray-400 italic">No main image uploaded.</p>
            @endif
        </div>

        {{-- Right: Product Details --}}
        <div class="space-y-3">
            <h3 class="font-semibold text-pink-600 mb-3">Product Information</h3>
            <div><span class="font-medium text-pink-700">Name:</span> {{ $product->name }}</div>
            <div><span class="font-medium text-pink-700">Code:</span> {{ $product->product_code }}</div>
            <div><span class="font-medium text-pink-700">Category:</span> 
                {{ $product->category ? $product->category->name : '—' }}
            </div>
            <div><span class="font-medium text-pink-700">Price:</span> ${{ number_format($product->price, 2) }}</div>
            <div><span class="font-medium text-pink-700">Discount:</span> {{ $product->discount_percentage }}%</div>
            <div><span class="font-medium text-pink-700">Stock:</span> {{ $product->stock }}</div>
            <div><span class="font-medium text-pink-700">Created At:</span> {{ $product->created_at->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    {{-- Description --}}
    <div class="mt-8">
        <h3 class="font-semibold text-pink-600 mb-2">Description</h3>
        <div class="p-4 bg-pink-50 border border-pink-200 rounded-lg text-gray-700">
            {!! nl2br(e($product->description)) ?: '<span class="text-gray-400 italic">No description provided.</span>' !!}
        </div>
    </div>

    {{-- Additional Images --}}
    @if($product->images->count() > 0)
        <div class="mt-8">
            <h3 class="font-semibold text-pink-600 mb-3">Additional Images</h3>
            <div class="flex flex-wrap gap-4">
                @foreach ($product->images as $image)
                    <div class="relative w-28 h-28 border border-pink-200 rounded-lg overflow-hidden group">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Variants --}}
    {{-- Variants --}}
@if($product->variants->count() > 0)
<div class="mt-8">
    <h3 class="font-semibold text-pink-600 mb-3">🎨 Product Variants</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($product->variants as $variant)
            <div class="p-4 border border-pink-200 rounded-xl bg-pink-50 flex flex-col md:flex-row gap-4 items-center">
                {{-- Variant Image --}}
                @if($variant->image)
                    <div class="w-24 h-24 flex-shrink-0">
                        <img src="{{ asset('storage/' . $variant->image) }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                @endif

                {{-- Variant Details --}}
                <div class="flex-1 space-y-1 text-gray-800">
                    <div><span class="font-medium text-pink-700">Color Name:</span> {{ $variant->color_name }}</div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-pink-700">Color Code:</span>
                        <div class="w-6 h-6 rounded" style="background-color: {{ $variant->color_code }}"></div>
                        <span>{{ $variant->color_code }}</span>
                    </div>
                    <div><span class="font-medium text-pink-700">Price Difference:</span> {{ $variant->price_difference ? '+$'.$variant->price_difference : '$0' }}</div>
                    <div><span class="font-medium text-pink-700">Stock:</span> {{ $variant->stock }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif


    {{-- Buttons --}}
    <div class="flex justify-end mt-8 space-x-3">
        <a href="{{ route('admin.products.index') }}"
           class="px-5 py-2 bg-pink-100 text-pink-700 rounded-lg hover:bg-pink-200 transition">Back</a>
        <a href="{{ route('admin.products.edit', $product->id) }}"
           class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">✏️ Edit</a>
    </div>
</div>
@endsection
