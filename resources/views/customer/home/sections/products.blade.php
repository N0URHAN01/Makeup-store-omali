<section id="products" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">

        {{-- Header --}}
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-semibold text-pink-600">New this week</p>
                <h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    New Arrivals
                </h2>
                <p class="text-gray-500 mt-2">Fresh picks, trending beauty essentials.</p>
            </div>

            <a href="{{ route('products.index') }}"
               class="shrink-0 inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-4 py-2.5
                      text-sm font-semibold text-white hover:bg-pink-700 transition">
                Browse all
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if($featuredProducts->count())
            {{-- ✅ Grid Responsive --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">

                @foreach($featuredProducts as $product)
                    @php
                        $hasDiscount = $product->discount_percentage > 0;
                        $discountText = rtrim(rtrim(number_format($product->discount_percentage, 2), '0'), '.');
                    @endphp

                    {{-- ✅ Card --}}
                    <div class="group h-full rounded-3xl border border-gray-200 bg-white overflow-hidden
                                hover:border-pink-200 hover:shadow-[0_18px_60px_-28px_rgba(236,72,153,0.55)]
                                transition-all duration-300 flex flex-col">

                        {{-- Media --}}
                        <div class="relative p-3">
                            <div class="relative aspect-square rounded-2xl overflow-hidden
                                        bg-gradient-to-b from-gray-50 to-white border border-gray-100">

                                {{-- soft spotlight --}}
                                <div class="pointer-events-none absolute -top-10 -left-10 h-40 w-40 rounded-full bg-pink-200/30 blur-3xl"></div>
                                <div class="pointer-events-none absolute -bottom-12 -right-10 h-44 w-44 rounded-full bg-fuchsia-200/25 blur-3xl"></div>

                                <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full">
                                    @if($product->image)
                                        <img
                                            src="{{ asset('storage/'.$product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-contain p-5
                                                   group-hover:scale-[1.05] transition-transform duration-300"
                                        >
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-pink-400 font-semibold">
                                            No Image
                                        </div>
                                    @endif
                                </a>

                                {{-- Discount badge --}}
                                @if($hasDiscount)
                                    <span class="absolute top-3 left-3 inline-flex items-center gap-1 text-[11px] font-extrabold
                                                 bg-gray-900 text-white px-2.5 py-1 rounded-full shadow">
                                        -{{ $discountText }}%
                                    </span>
                                @endif

                                {{-- Quick view (Desktop hover) --}}
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="hidden sm:flex absolute inset-x-4 bottom-4 items-center justify-center gap-2
                                          opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0
                                          transition-all duration-300
                                          bg-white/90 backdrop-blur border border-gray-200
                                          rounded-2xl py-2 text-xs font-semibold text-gray-900 shadow-sm">
                                    Quick view
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z"/>
                                    </svg>
                                </a>

                                {{-- Quick view (Mobile always visible) --}}
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="sm:hidden absolute inset-x-4 bottom-4 text-center
                                          bg-white/95 border border-gray-200 rounded-2xl py-2
                                          text-xs font-semibold text-gray-900 shadow-sm">
                                    View details
                                </a>
                            </div>
                        </div>

                        {{-- Content (✅ fixes button position) --}}
                        <div class="px-4 pb-4 flex flex-col flex-1">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="text-sm sm:text-[15px] font-semibold text-gray-900 leading-snug
                                      line-clamp-2 hover:text-pink-700 transition
                                      min-h-[44px]">
                                {{ $product->name }}
                            </a>

                            {{-- Price area fixed height --}}
                            <div class="mt-2 min-h-[44px]">
                                @if($hasDiscount)
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-xs text-gray-400 line-through">
                                            {{ number_format($product->price, 2) }} EGP
                                        </span>
                                        <span class="text-sm font-extrabold text-gray-900">
                                            {{ number_format($product->discounted_price, 2) }} EGP
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm font-extrabold text-gray-900">
                                        {{ number_format($product->price, 2) }} EGP
                                    </span>
                                @endif
                            </div>

                            {{-- Stock --}}
                            <div class="mt-2 flex items-center gap-2 text-[11px] text-gray-500">
                                <span class="h-1.5 w-1.5 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}
                            </div>

                            {{-- ✅ Add to cart fixed bottom --}}
                            <div class="mt-auto pt-4">
                                @if($product->stock > 0)
                                   <form action="{{ route('cart.add') }}" method="POST">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="qty" value="1">

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2
                   rounded-2xl px-4 py-3
                   bg-pink-600 text-white text-sm font-semibold
                   hover:bg-pink-700 transition shadow-sm">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1 12H6L5 8z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8V7a3 3 0 016 0v1"/>
        </svg>

        Add to cart
    </button>
</form>
                                @else
                                    <button type="button" disabled
                                            class="w-full inline-flex items-center justify-center gap-2
                                                   rounded-2xl px-4 py-3
                                                   bg-gray-200 text-gray-500 text-sm font-semibold cursor-not-allowed">
                                        Sold out
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        @else
            <p class="text-gray-500">No products found.</p>
        @endif
    </div>
</section>