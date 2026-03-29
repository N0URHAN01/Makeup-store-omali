@extends('customer.layouts.app')

@section('title', $category->name)

@section('content')

<div class="h-16"></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    {{-- Title --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">
            {{ $category->name }}
        </h1>

        @if($category->description)
            <p class="text-gray-500 mt-2">
                {{ $category->description }}
            </p>
        @endif
    </div>

    {{-- Sub Categories --}}
    @if($category->children->count())
        <div class="mb-12">

            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                {{ $category->name }} Categories
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">

                @foreach($category->children as $child)
                    <a href="{{ route('categories.show', $child->slug) }}"
                       class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden">

                        <div class="h-28 sm:h-32 bg-pink-50 flex items-center justify-center p-3">
                            @if($child->image)
                                <img src="{{ asset('storage/'.$child->image) }}"
                                     class="w-full h-full object-contain">
                            @else
                                <div class="text-pink-400 text-sm">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 group-hover:text-pink-600 truncate">
                                {{ $child->name }}
                            </h3>
                        </div>

                    </a>
                @endforeach

            </div>
        </div>
    @endif

    {{-- Products --}}
    <div>

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                Products
            </h2>

            <span class="text-sm text-gray-500">
                {{ $products->count() }} items
            </span>
        </div>

        @if($products->count())

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">

                @foreach($products as $product)
                    @include('customer.components.product-card', ['product' => $product])
                @endforeach

            </div>

        @else
            <p class="text-gray-500">
                No products found.
            </p>
        @endif

    </div>

</div>

@endsection