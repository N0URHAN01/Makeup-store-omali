<section class="relative overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0 bg-gradient-to-b from-pink-50 via-white to-white"></div>

    {{-- Soft glow blobs --}}
    <div class="pointer-events-none absolute -top-28 -left-28 h-96 w-96 rounded-full bg-pink-200/40 blur-3xl"></div>
    <div class="pointer-events-none absolute top-10 -right-20 h-[28rem] w-[28rem] rounded-full bg-fuchsia-200/35 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-rose-200/25 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-14 md:py-20 grid lg:grid-cols-2 gap-12 items-center">

        {{-- Text --}}
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center rounded-full bg-white/70 backdrop-blur border border-pink-100 px-3 py-1 text-[11px] font-semibold tracking-widest text-pink-700">
                    PREMIUM BEAUTY STORE
                </span>
                <span class="inline-flex items-center rounded-full bg-white/70 backdrop-blur border border-gray-100 px-3 py-1 text-[11px] font-semibold text-gray-700">
                    Free Shipping over 500 EGP
                </span>
                <span class="inline-flex items-center rounded-full bg-white/70 backdrop-blur border border-gray-100 px-3 py-1 text-[11px] font-semibold text-gray-700">
                    New Arrivals Weekly
                </span>
            </div>

            <h1 class="mt-6 text-4xl md:text-6xl font-extrabold text-gray-900 leading-[1.02] tracking-tight">
                Discover Your
                <span class="block">Beauty</span>

                <span class="block bg-gradient-to-r from-pink-600 via-fuchsia-600 to-rose-500 bg-clip-text text-transparent">
                    Makeup, Cosmetics & Perfumes
                </span>
            </h1>

            <p class="mt-6 text-gray-600 text-lg leading-relaxed max-w-xl">
                Shop premium makeup, cosmetics, and perfumes — carefully selected to enhance your beauty by Om Ali.
            </p>

            <div class="mt-9 flex flex-wrap gap-4">
                <a href="#"
                   class="px-7 py-3 rounded-full font-semibold text-white
                          bg-gradient-to-r from-pink-600 via-fuchsia-600 to-rose-500
                          shadow-lg shadow-pink-200/60 hover:shadow-xl hover:shadow-pink-200/70
                          transition">
                    Shop Now
                </a>

                <a href="#categories"
                   class="px-7 py-3 rounded-full font-semibold text-gray-900
                          bg-white/80 backdrop-blur border border-pink-100
                          hover:bg-white hover:border-pink-200
                          shadow-sm transition">
                    View Categories
                </a>
            </div>

            <div class="mt-10 flex items-center gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-pink-500"></span>
                    Authentic products
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-fuchsia-500"></span>
                    Best prices
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                    Fast delivery
                </div>
            </div>
        </div>

        {{-- Image (2026 glass card + ring + floating) --}}
        <div class="flex justify-center lg:justify-end">
            <div class="relative w-full max-w-lg">

                {{-- halo --}}
                <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-r from-pink-200/60 via-fuchsia-200/45 to-rose-200/60 blur-2xl"></div>

                {{-- glass frame --}}
                <div class="relative rounded-[2.5rem] p-[2px] bg-gradient-to-r from-pink-300/70 via-fuchsia-300/50 to-rose-300/70 shadow-2xl">
                    <div class="rounded-[2.4rem] bg-white/55 backdrop-blur-xl border border-white/60 overflow-hidden">

                        {{-- top mini bar (editorial touch) --}}
                        <div class="flex items-center gap-2 px-6 pt-5 pb-3">
                            <span class="h-2 w-2 rounded-full bg-pink-400"></span>
                            <span class="h-2 w-2 rounded-full bg-fuchsia-400"></span>
                            <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                            <span class="ml-3 text-xs font-semibold tracking-wide text-gray-700/70">
                                Om Ali Beauty
                            </span>
                        </div>

                        <div class="px-6 pb-6">
                            <div class="rounded-3xl bg-white shadow-xl border border-pink-50 overflow-hidden">
                                <img
                                    src="{{ asset('images/heroAi.png') }}"
                                    alt="Om Ali Store"
                                    class="w-full h-auto object-cover"
                                >
                            </div>
                        </div>

                    </div>
                </div>

                {{-- floating tag --}}
                <div class="absolute -bottom-5 left-6 sm:left-10 bg-white/80 backdrop-blur border border-pink-100
                            px-4 py-2 rounded-2xl shadow-md">
                    <p class="text-xs font-semibold text-gray-900">
                        Trending Now
                        <span class="ml-2 text-pink-600 font-bold">Beauty Essentials</span>
                    </p>
                </div>

            </div>
        </div>

    </div>
</section>
