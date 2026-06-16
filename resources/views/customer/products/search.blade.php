@extends('customer.layouts.app')

@section('title', 'Search | Om Ali Cosmetics')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    <div class="max-w-2xl mx-auto text-center mb-10">

        <span class="inline-flex items-center rounded-full bg-pink-50 border border-pink-100 px-4 py-2 text-xs font-bold text-pink-700 uppercase tracking-widest">
            Search
        </span>

        <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-gray-900">
            Search Products
        </h1>

        <p class="mt-2 text-sm text-gray-500">
            Search by product name, code, category, or description.
        </p>

        <form action="{{ route('search') }}" method="GET" class="mt-6">
            <div class="relative">
                <input type="text"
                       name="search"
                       value="{{ $keyword }}"
                       autofocus
                       placeholder="What are you looking for?"
                       class="w-full rounded-full border border-pink-100 bg-pink-50 px-5 py-4 pr-14 text-sm outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-100">

                <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-pink-700 hover:bg-pink-800 text-white flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
            </svg>
                </button>
            </div>
        </form>

    </div>

    @if($keyword === '')

        <div class="text-center text-gray-400 text-sm">
            Start typing to search for your favorite products.
        </div>

    @elseif($products->count())

        <div class="mb-6 text-sm text-gray-500">
            Results for:
            <span class="font-bold text-pink-700">"{{ $keyword }}"</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">
            @foreach($products as $product)
                @include('customer.components.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links('customer.components.pagination') }}
        </div>

    @else

        <div class="bg-white border border-dashed border-pink-100 rounded-3xl py-16 text-center">
            <div class="text-5xl mb-4">  <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
            </svg></div>

            <h3 class="text-lg font-bold text-gray-800">
                No results found
            </h3>

            <p class="text-sm text-gray-400 mt-2">
                Try another product name or category.
            </p>
        </div>

    @endif

</div>

@endsection