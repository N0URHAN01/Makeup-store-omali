<section class="bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">

        {{-- HEADER --}}
        <div class="text-center mb-10">

            <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-widest
                         text-white bg-gradient-to-r from-pink-600 to-fuchsia-600
                         px-4 py-1 rounded-full mb-4">
                🔥 Limited time
            </span>

            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight mb-3">
                Don't miss our
                <span class="bg-gradient-to-r from-pink-600 via-fuchsia-600 to-rose-500
                             bg-clip-text text-transparent">
                    Special Offers
                </span>
            </h2>

            <p class="text-sm text-gray-400 max-w-sm mx-auto leading-relaxed">
                Premium beauty deals — curated with care, priced to love.
            </p>

        </div>

        {{-- PRODUCTS --}}
        @if($offerProducts->count())

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 mb-8">

                @foreach($offerProducts as $product)

                    <div class="relative bg-white border border-pink-100 rounded-2xl overflow-hidden
                                hover:border-pink-300 transition-colors">

                        <span class="absolute top-2.5 left-2.5 z-10
                                     text-[9px] font-semibold uppercase tracking-wider text-white
                                     bg-gradient-to-r from-pink-600 to-fuchsia-600
                                     px-2 py-0.5 rounded-full">
                            Sale
                        </span>

                        @include('customer.components.product-card', ['product' => $product])

                    </div>

                @endforeach

            </div>

            {{-- VIEW ALL --}}
            @if($offersCategory)
                <div class="flex justify-center">
                    <a href="{{ route('categories.show', $offersCategory->slug) }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-white
                              bg-gradient-to-r from-pink-600 to-fuchsia-600
                              px-10 py-3 rounded-full hover:opacity-90 transition-opacity group">
                        View all offers
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 transition-transform group-hover:translate-x-0.5"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M13 18l6-6M13 6l6 6"/>
                        </svg>
                    </a>
                </div>
            @endif

        @else

            <div class="border border-dashed border-pink-100 rounded-2xl py-14 text-center">
                <p class="text-sm text-gray-400">No offers available right now.</p>
            </div>

        @endif

    </div>

</section>