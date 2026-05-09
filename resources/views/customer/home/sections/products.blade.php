<section id="products" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">

        {{-- HEADER --}}
        <div class="text-center mb-10">

            <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-widest
                         text-white bg-gradient-to-r from-pink-600 to-fuchsia-600
                         px-4 py-1 rounded-full mb-4">
                ✨ New this week
            </span>

            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight mb-3">
                Fresh
                <span class="bg-gradient-to-r from-pink-600 via-fuchsia-600 to-rose-500
                             bg-clip-text text-transparent">
                    New Arrivals
                </span>
            </h2>

            <p class="text-sm text-gray-400 max-w-sm mx-auto leading-relaxed">
                Trending beauty essentials — curated and dropped fresh.
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