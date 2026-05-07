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
                    @php
                        $hasDiscount = $product->discount_percentage > 0;
                        $discountText = rtrim(rtrim(number_format($product->discount_percentage, 2), '0'), '.');
                    @endphp

                    {{-- Card --}}
                    <div class="group flex flex-col bg-white border border-pink-100 rounded-3xl overflow-hidden
                                hover:border-pink-300 hover:shadow-[0_12px_40px_-16px_rgba(219,39,119,0.3)]
                                transition-all duration-300">

                        {{-- Image area --}}
                        <div class="relative m-2.5 aspect-square rounded-2xl overflow-hidden
                                    bg-gradient-to-b from-pink-50 to-fuchsia-50/30">

                            <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-contain p-5
                                                group-hover:scale-[1.05] transition-transform duration-300">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-pink-300 text-sm font-medium">
                                        No Image
                                    </div>
                                @endif
                            </a>

                            {{-- Discount badge --}}
                            @if($hasDiscount)
                                <span class="absolute top-2.5 left-2.5 text-[10px] font-bold
                                             bg-gray-900 text-white px-2.5 py-1 rounded-full">
                                    -{{ $discountText }}%
                                </span>
                            @endif

                            
                            {{-- Quick view — desktop hover --}}
                            <a href="{{ route('products.show', $product->id) }}"
                               class="hidden sm:flex absolute inset-x-3 bottom-3 items-center justify-center gap-1.5
                                      opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0
                                      transition-all duration-300
                                      bg-white/90 border border-gray-100 rounded-2xl
                                      py-2 text-[11px] font-semibold text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12H9m12 0c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z"/>
                                </svg>
                                Quick view
                            </a>

                            {{-- View details — mobile --}}
                            <a href="{{ route('products.show', $product->id) }}"
                               class="sm:hidden absolute inset-x-3 bottom-3 text-center
                                      bg-white/95 border border-gray-100 rounded-2xl
                                      py-2 text-[11px] font-semibold text-gray-700">
                                View details
                            </a>
                        </div>

                        {{-- Body --}}
                        <div class="px-4 pb-4 flex flex-col flex-1">

                            <a href="{{ route('products.show', $product->id) }}"
                               class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2
                                      hover:text-pink-600 transition min-h-[40px]">
                                {{ $product->name }}
                            </a>

                            {{-- Price --}}
                            <div class="mt-2 min-h-[28px]">
                                @if($hasDiscount)
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-xs text-gray-300 line-through">
                                            {{ number_format($product->price, 2) }} EGP
                                        </span>
                                        <span class="text-sm font-bold bg-gradient-to-r from-pink-600 to-fuchsia-600
                                                     bg-clip-text text-transparent">
                                            {{ number_format($product->discounted_price, 2) }} EGP
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm font-bold bg-gradient-to-r from-pink-600 to-fuchsia-600
                                                 bg-clip-text text-transparent">
                                        {{ number_format($product->price, 2) }} EGP
                                    </span>
                                @endif
                            </div>

                            {{-- Stock --}}
                            <div class="mt-2 flex items-center gap-1.5 text-[11px] text-gray-400">
                                <span class="h-1.5 w-1.5 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                {{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}
                            </div>

                            {{-- Add to cart --}}
                            <div class="mt-auto pt-4">
                                @if($product->stock > 0)
                                    <form class="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit"
                                                class="add-to-cart-btn w-full inline-flex items-center justify-center gap-2
                                                       rounded-full px-4 py-2.5 text-sm font-semibold text-white
                                                       bg-gradient-to-r from-pink-600 to-fuchsia-600
                                                       hover:opacity-90 transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1 12H6L5 8z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8V7a3 3 0 016 0v1"/>
                                            </svg>
                                            Add to cart
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                            class="w-full inline-flex items-center justify-center
                                                   rounded-full px-4 py-2.5 text-sm font-semibold
                                                   bg-gray-100 text-gray-400 cursor-not-allowed">
                                        Sold out
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
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