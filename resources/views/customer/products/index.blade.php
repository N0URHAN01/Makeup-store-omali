@extends('customer.layouts.app')

@section('title', 'All Products')

@section('content')

<div class="h-16"></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="flex items-end justify-between mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">
                All Products
            </h1>
            <p class="text-gray-500 mt-1">
                Browse everything in Om Ali Store.
            </p>
        </div>
    </div>

    @if($products->count())

        {{-- Products Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">

            @foreach($products as $product)
                @include('customer.components.product-card', ['product' => $product])
            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->links('customer.components.pagination') }}
        </div>

    @else
        <p class="text-gray-500 text-center mt-10">
            No products found.
        </p>
    @endif

</div>

@endsection