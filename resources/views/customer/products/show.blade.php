<!DOCTYPE html>
<html lang="en" dir="auto">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $product->name }}</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-b from-pink-50/70 via-white to-white text-gray-900">
    {{-- Navbar --}}
    @include('customer.home.sections.navbar')

    {{-- Soft background glow --}}
    <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10">
        <div class="absolute -top-24 left-1/2 h-72 w-[38rem] -translate-x-1/2 rounded-full bg-gradient-to-r from-pink-200/60 via-fuchsia-200/40 to-purple-200/30 blur-3xl"></div>
        <div class="absolute top-52 right-[-6rem] h-72 w-72 rounded-full bg-pink-200/30 blur-3xl"></div>
        <div class="absolute bottom-[-7rem] left-[-6rem] h-80 w-80 rounded-full bg-fuchsia-200/25 blur-3xl"></div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10 lg:py-14">
        {{-- Breadcrumb / Back --}}
        <div class="mb-6 flex items-center justify-between gap-3">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-pink-600 transition">
                <span class="text-lg">←</span> Back
            </a>

            <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-gray-500">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 border border-pink-100 px-3 py-1 shadow-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-pink-500"></span>
                    Premium Beauty
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 border border-gray-100 px-3 py-1 shadow-sm">
                    Fast delivery
                </span>
            </div>
        </div>

        @php
            // main image + other images
            $gallery = collect([]);

            if ($product->image) {
                $gallery->push(asset('storage/'.$product->image));
            }

            foreach ($product->images as $img) {
                $gallery->push(asset('storage/'.$img->image_path));
            }

            $gallery = $gallery->unique()->values();
            $firstImage = $gallery->first() ?? 'https://via.placeholder.com/700x700?text=No+Image';
            $hasDiscount = $product->discount_percentage > 0;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
            {{-- ================== GALLERY (LEFT) ================== --}}
            <section class="lg:col-span-7">
                <div class="rounded-3xl border border-pink-100/70 bg-white/70 backdrop-blur-xl shadow-[0_20px_60px_-40px_rgba(236,72,153,0.55)] overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col lg:flex-row gap-4">
                            {{-- Thumbs (left on desktop) --}}
                            @if($gallery->count() > 1)
                                <div class="order-2 lg:order-1 flex lg:flex-col gap-3 overflow-x-auto lg:overflow-y-auto lg:max-h-[520px] pr-1 pb-2 lg:pb-0">
                                    @foreach($gallery as $index => $src)
                                        <button
                                            type="button"
                                            class="thumbBtn group shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-2xl border border-gray-200/80 bg-white overflow-hidden hover:border-pink-400 transition relative"
                                            data-src="{{ $src }}"
                                            aria-label="Preview image {{ $index + 1 }}"
                                        >
                                            <img src="{{ $src }}"
                                                 alt="thumb"
                                                 class="w-full h-full object-contain p-2 transition duration-300 group-hover:scale-105" />

                                            <span class="pointer-events-none absolute inset-0 rounded-2xl ring-0 group-hover:ring-2 ring-pink-300/70 transition"></span>
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Main image --}}
                            <div class="order-1 lg:order-2 flex-1">
                                <div class="relative rounded-3xl bg-gradient-to-b from-white to-pink-50/30 border border-gray-100 overflow-hidden">
                                    <button id="openLightbox" type="button" class="block w-full">
                                        <img
                                            id="mainImage"
                                            src="{{ $firstImage }}"
                                            alt="{{ $product->name }}"
                                            class="w-full aspect-square object-contain p-6 sm:p-10"
                                        />
                                    </button>

                                    {{-- Discount --}}
                                    @if($hasDiscount)
                                        <div class="absolute top-4 left-4">
                                            <span class="inline-flex items-center gap-2 rounded-full bg-pink-600 text-white text-xs font-extrabold px-3 py-1.5 shadow-lg shadow-pink-200">
                                                -{{ rtrim(rtrim(number_format($product->discount_percentage, 2), '0'), '.') }}%
                                                <span class="h-1.5 w-1.5 rounded-full bg-white/80"></span>
                                                SALE
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Zoom hint --}}
                                    <div class="absolute bottom-4 right-4 hidden sm:flex items-center gap-2 rounded-full bg-white/80 backdrop-blur px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-100 shadow-sm">
                                        <span>Click to zoom</span>
                                        <span class="text-base">⤢</span>
                                    </div>
                                </div>

                                {{-- Mobile thumbs under main if only 1 column --}}
                                @if($gallery->count() > 1)
                                    <p class="mt-3 text-xs text-gray-500">
                                        Tap a thumbnail to switch the preview.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================== INFO (RIGHT) ================== --}}
            <section class="lg:col-span-5">
                <div class="sticky top-24">
                    <div class="rounded-3xl border border-pink-100/70 bg-white/75 backdrop-blur-xl shadow-[0_20px_60px_-45px_rgba(236,72,153,0.45)] p-5 sm:p-7">
                        {{-- Title --}}
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                            {{ $product->name }}
                        </h1>

                        {{-- Code + Stock --}}
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white border border-gray-100 px-3 py-1 text-xs font-semibold text-gray-600 shadow-sm">
                                Code: <span class="font-mono">{{ $product->product_code }}</span>
                            </span>

                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-extrabold shadow-sm
                                {{ $product->stock > 0 ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}
                            </span>
                        </div>

                        {{-- Price --}}
                        <div class="mt-5">
                            @if($hasDiscount)
                                <div class="flex items-end gap-3">
                                    <div class="text-gray-400 line-through text-base sm:text-lg font-semibold">
                                        {{ number_format($product->price, 2) }} EGP
                                    </div>

                                    <div class="text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-pink-600 to-fuchsia-600 bg-clip-text text-transparent">
                                        {{ number_format($product->discounted_price, 2) }} EGP
                                    </div>
                                </div>

                                <p class="mt-2 text-sm text-gray-500">
                                    You save
                                    <span class="font-bold text-pink-600">
                                        {{ number_format($product->price - $product->discounted_price, 2) }} EGP
                                    </span>
                                </p>
                            @else
                                <div class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                                    {{ number_format($product->price, 2) }} EGP
                                </div>
                            @endif
                        </div>

                        {{-- Quick perks --}}
                        <div class="mt-6 grid grid-cols-3 gap-3">
                            <div class="rounded-2xl bg-white border border-gray-100 px-3 py-3 text-center shadow-sm">
                                <div class="text-lg">✨</div>
                                <div class="mt-1 text-[11px] font-bold text-gray-700">Authentic</div>
                            </div>
                            <div class="rounded-2xl bg-white border border-gray-100 px-3 py-3 text-center shadow-sm">
                                <div class="text-lg">🚚</div>
                                <div class="mt-1 text-[11px] font-bold text-gray-700">Fast</div>
                            </div>
                        
                            <div class="rounded-2xl bg-white border border-gray-100 px-3 py-3 text-center shadow-sm">
                            <div class="text-lg">💵</div>
                            <div class="mt-1 text-[11px] font-bold text-gray-700">
                                Cash on Delivery
                            </div>
                        </div>

                        </div>

                        {{-- Description --}}
                        @if($product->description)
                            <div class="mt-7">
                                <h3 class="text-sm font-extrabold text-gray-900">Description</h3>
                                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                                    {{ $product->description }}
                                </p>
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="mt-8 flex flex-col sm:flex-row gap-3">
                            <button
                                class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl
                                       bg-gradient-to-r from-pink-600 to-fuchsia-600
                                       hover:from-pink-700 hover:to-fuchsia-700
                                       text-white font-extrabold py-3.5 shadow-lg shadow-pink-200/70 transition active:scale-[0.99]">
                                <span>🛍️</span>
                                Add to Cart
                            </button>

                            <a href="{{ url()->previous() }}"
                               class="sm:w-28 inline-flex items-center justify-center rounded-2xl
                                      border border-gray-200 bg-white hover:bg-gray-50
                                      font-extrabold text-gray-700 py-3.5 transition">
                                Back
                            </a>
                        </div>

                        {{-- Note --}}
                        <p class="mt-4 text-xs text-gray-500">
                            Tip: Click the image to zoom and view details clearly.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    {{-- ================== LIGHTBOX MODAL ================== --}}
    <div id="lightbox" class="fixed inset-0 z-[999] hidden">
        <div id="lightboxOverlay" class="absolute inset-0 bg-black/70 backdrop-blur-[2px]"></div>

        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div class="relative max-w-5xl w-full rounded-3xl bg-white shadow-2xl overflow-hidden border border-white/40">
                <div class="flex items-center justify-between px-4 sm:px-6 py-3 border-b bg-white/70">
                    <div class="text-sm font-extrabold text-gray-800 truncate pr-3">
                        {{ $product->name }}
                    </div>
                    <button id="closeLightbox"
                            class="w-10 h-10 rounded-full bg-white hover:bg-gray-50 border border-gray-200 shadow-sm flex items-center justify-center text-2xl leading-none">
                        &times;
                    </button>
                </div>

                <div class="bg-black/5">
                    <img id="lightboxImage"
                         src="{{ $firstImage }}"
                         class="w-full max-h-[82vh] object-contain p-4 sm:p-8"
                         alt="zoom">
                </div>
            </div>
        </div>
    </div>

    {{-- ================== SCRIPT ================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mainImage = document.getElementById('mainImage');
            const thumbBtns = document.querySelectorAll('.thumbBtn');

            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightboxImage');
            const openLightbox = document.getElementById('openLightbox');
            const closeLightbox = document.getElementById('closeLightbox');
            const overlay = document.getElementById('lightboxOverlay');

            // default active thumb
            if (thumbBtns.length) {
                thumbBtns[0].classList.add('ring-2', 'ring-pink-500');
            }

            // Switch main image when click a thumbnail
            thumbBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const src = btn.getAttribute('data-src');
                    mainImage.src = src;
                    lightboxImage.src = src;

                    thumbBtns.forEach(b => b.classList.remove('ring-2', 'ring-pink-500'));
                    btn.classList.add('ring-2', 'ring-pink-500');
                });
            });

            // Open modal
            openLightbox?.addEventListener('click', () => {
                lightbox.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });

            // Close modal
            function closeModal() {
                lightbox.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            closeLightbox?.addEventListener('click', closeModal);
            overlay?.addEventListener('click', closeModal);

            // ESC to close
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) closeModal();
            });
        });
    </script>
</body>
</html>
