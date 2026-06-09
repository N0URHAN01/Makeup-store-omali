<section id="products" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">

        {{-- HEADER --}}
        {{-- HEADER --}}
<div class="text-center mb-12">

    <div class="inline-flex items-center gap-2.5 rounded-full bg-pink-50 border border-pink-100 px-5 py-2 mb-5">
        <span class="w-2 h-2 rounded-full bg-pink-500"></span>
        <span class="text-xs font-bold tracking-[0.25em] uppercase text-pink-600">
            Fresh Drops
        </span>
    </div>

    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-gray-900 leading-tight">
        New
        <span class="relative inline-block text-pink-600">
            Arrivals
            <span class="absolute left-0 -bottom-1 w-full h-3 bg-pink-200/60 -z-10 rounded-full"></span>
        </span>
    </h2>

    <p class="mt-5 text-sm md:text-base text-gray-500 max-w-xl mx-auto leading-relaxed">
        Discover our latest beauty essentials, carefully selected to bring you fresh picks,
        premium quality, and everyday favorites in one place.
    </p>

</div>

        @if($featuredProducts->count())

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-10">

                @foreach($featuredProducts as $product)
                    @include('customer.components.product-card', ['product' => $product])
                @endforeach

            </div>

            {{-- Browse all --}}
            <div class="flex justify-center">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-white
                          bg-gradient-to-r from-pink-600 to-fuchsia-600
                          px-10 py-3 rounded-full hover:opacity-90 transition-opacity group">
                    Browse all products
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4 transition-transform group-hover:translate-x-0.5"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M13 18l6-6M13 6l6 6"/>
                    </svg>
                </a>
            </div>

        @else
            <p class="text-center text-sm text-gray-400">No products found.</p>
        @endif

    </div>
</section>