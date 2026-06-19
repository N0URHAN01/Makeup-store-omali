@extends('customer.layouts.app')

@section('title', $product->name)

@section('content')

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
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-pink-700 transition">
            <span class="text-lg">←</span> Back
        </a>

        <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-gray-500">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/70 border border-pink-100 px-3 py-1 shadow-sm">
                <span class="h-1.5 w-1.5 rounded-full bg-pink-700"></span>
                Premium Beauty
            </span>

            <span class="inline-flex items-center gap-2 rounded-full bg-white/70 border border-gray-100 px-3 py-1 shadow-sm">
                Fast delivery
            </span>
        </div>
    </div>

    @php
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

        $hasVariants = $product->variants->count() > 0;

        $availableStock = $hasVariants
            ? $product->variants->sum('stock')
            : $product->stock;

        $inStock = $availableStock > 0;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

        {{-- ================== GALLERY ================== --}}
        <section class="lg:col-span-7">
            <div class="rounded-3xl border border-pink-100/70 bg-white/70 backdrop-blur-xl shadow-[0_20px_60px_-40px_rgba(236,72,153,0.45)] overflow-hidden">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col lg:flex-row gap-4">

                        {{-- Thumbs --}}
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
                                             class="w-full h-full object-contain p-2 transition duration-300 group-hover:scale-105">

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
                                    >
                                </button>

                                @if($hasDiscount)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-pink-700 text-white text-xs font-extrabold px-3 py-1.5 shadow-lg shadow-pink-200">
                                            -{{ rtrim(rtrim(number_format($product->discount_percentage, 2), '0'), '.') }}%
                                            <span class="h-1.5 w-1.5 rounded-full bg-white/80"></span>
                                            SALE
                                        </span>
                                    </div>
                                @endif

                                <div class="absolute bottom-4 right-4 hidden sm:flex items-center gap-2 rounded-full bg-white/80 backdrop-blur px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-100 shadow-sm">
                                    <span>Click to zoom</span>
                                    <span class="text-base">⤢</span>
                                </div>
                            </div>

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

        {{-- ================== INFO ================== --}}
        <section class="lg:col-span-5">
            <div class="sticky top-24">
                <div class="rounded-3xl border border-pink-100/70 bg-white/75 backdrop-blur-xl shadow-[0_20px_60px_-45px_rgba(236,72,153,0.38)] p-5 sm:p-7">

                    {{-- Title --}}
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-950">
                        {{ $product->name }}
                    </h1>

{{-- ================= VARIANTS ================= --}}
                    @if($hasVariants)
                        <div class="mt-6 pt-6 border-t border-pink-100">
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <h3 class="text-sm font-extrabold text-gray-900">
                                    Choose color
                                </h3>

                                <span class="text-[11px] font-medium text-gray-400">
                                    Select available option
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-4" id="variantsContainer">

                                @foreach($product->variants as $variant)

                                    @php
                                        $outOfStock = $variant->stock <= 0;
                                    @endphp

                                    <div class="variant-wrapper flex flex-col items-center gap-2">

                                        <button type="button"
                                            class="variant-btn group w-14 h-14 rounded-full border-2 overflow-hidden transition relative
                                            {{ $outOfStock
                                                ? 'border-gray-200 opacity-45 cursor-not-allowed grayscale'
                                                : 'border-gray-200 hover:border-pink-700 hover:shadow-md'
                                            }}"
                                            data-id="{{ $variant->id }}"
                                            data-image="{{ $variant->image ? asset('storage/'.$variant->image) : '' }}"
                                            {{ $outOfStock ? 'disabled' : '' }}
                                        >

                                            @if($variant->image)
                                                <img src="{{ asset('storage/'.$variant->image) }}"
                                                     class="w-full h-full object-cover"
                                                     alt="{{ $variant->color_name }}">
                                            @else
                                                <div class="w-full h-full"
                                                     style="background-color: {{ $variant->color_code }}"></div>
                                            @endif

                                            @if($outOfStock)
                                                <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                                    <span class="text-[10px] font-bold text-red-600">
                                                        Out
                                                    </span>
                                                </div>
                                            @endif

                                        </button>

                                        <span class="variant-name text-[11px] font-medium text-center
                                            {{ $outOfStock ? 'text-red-500' : 'text-gray-500' }}">
                                            {{ $variant->color_name }}
                                        </span>

                                    </div>

                                @endforeach

                            </div>

                            <p id="variantError" class="text-red-500 text-xs mt-3 hidden">
                                Please select an available color first.
                            </p>
                        </div>
                    @endif

                    {{-- Code + Stock --}}
                    <div class="mt-3 flex flex-wrap items-center gap-2">

                        <span class="inline-flex items-center gap-2 rounded-full bg-white border border-gray-100 px-3 py-1 text-xs font-semibold text-gray-600 shadow-sm">
                            Code:
                            <span class="font-mono">{{ $product->product_code }}</span>
                        </span>

                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold border shadow-sm
                            {{ $inStock ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-red-50 text-red-700 border-red-100' }}">

                            <span class="h-1.5 w-1.5 rounded-full {{ $inStock ? 'bg-emerald-500' : 'bg-red-500' }}"></span>

                            {{ $inStock ? 'In stock' : 'Out of stock' }}
                        </span>

                    </div>

                    {{-- Price --}}
                    <div class="mt-5">
                        @if($hasDiscount)
                            <div class="flex items-end gap-3">
                                <div class="text-gray-400 line-through text-base sm:text-lg font-semibold">
                                    {{ number_format($product->price, 2) }} EGP
                                </div>

                                <div class="text-2xl sm:text-3xl font-extrabold text-pink-700">
                                    {{ number_format($product->discounted_price, 2) }} EGP
                                </div>
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                You save
                                <span class="font-bold text-pink-700">
                                    {{ number_format($product->price - $product->discounted_price, 2) }} EGP
                                </span>
                            </p>
                        @else
                            <div class="text-2xl sm:text-3xl font-extrabold text-pink-700">
                                {{ number_format($product->price, 2) }} EGP
                            </div>
                        @endif
                    </div>

                    {{-- ================= VARIANTS ================= --}}
                    <!-- @if($hasVariants)
                        <div class="mt-6">
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <h3 class="text-sm font-extrabold text-gray-900">
                                    Choose color
                                </h3>

                                <span class="text-[11px] font-medium text-gray-400">
                                    Select available option
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-4" id="variantsContainer">

                                @foreach($product->variants as $variant)

                                    @php
                                        $outOfStock = $variant->stock <= 0;
                                    @endphp

                                    <div class="variant-wrapper flex flex-col items-center gap-2">

                                        <button type="button"
                                            class="variant-btn group w-14 h-14 rounded-full border-2 overflow-hidden transition relative
                                            {{ $outOfStock
                                                ? 'border-gray-200 opacity-45 cursor-not-allowed grayscale'
                                                : 'border-gray-200 hover:border-pink-700 hover:shadow-md'
                                            }}"
                                            data-id="{{ $variant->id }}"
                                            data-image="{{ $variant->image ? asset('storage/'.$variant->image) : '' }}"
                                            {{ $outOfStock ? 'disabled' : '' }}
                                        >

                                            @if($variant->image)
                                                <img src="{{ asset('storage/'.$variant->image) }}"
                                                     class="w-full h-full object-cover"
                                                     alt="{{ $variant->color_name }}">
                                            @else
                                                <div class="w-full h-full"
                                                     style="background-color: {{ $variant->color_code }}"></div>
                                            @endif

                                            @if($outOfStock)
                                                <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                                    <span class="text-[10px] font-bold text-red-600">
                                                        Out
                                                    </span>
                                                </div>
                                            @endif

                                        </button>

                                        <span class="variant-name text-[11px] font-medium text-center
                                            {{ $outOfStock ? 'text-red-500' : 'text-gray-500' }}">
                                            {{ $variant->color_name }}
                                        </span>

                                    </div>

                                @endforeach

                            </div>

                            <p id="variantError" class="text-red-500 text-xs mt-3 hidden">
                                Please select an available color first.
                            </p>
                        </div>
                    @endif -->

                    {{-- Actions --}}
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">

                        @if($inStock)
                            <form class="add-to-cart-form flex-1">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="1">
                                <input type="hidden" name="variant_id" id="selectedVariant">

                                <button type="submit"
                                    class="add-to-cart-btn w-full inline-flex items-center justify-center gap-2 rounded-2xl
                                    bg-pink-700 hover:bg-pink-800
                                    text-white font-bold py-3.5 shadow-lg shadow-pink-200/70
                                    transition duration-300 active:scale-[0.98]">

              <svg xmlns="http://www.w3.org/2000/svg"
     class="w-5 h-5"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="2">

    <path stroke-linecap="round"
          stroke-linejoin="round"
          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.3 2.4a1 1 0 00.9 1.6H19"/>

    <circle cx="9" cy="20" r="1.5"/>
    <circle cx="18" cy="20" r="1.5"/>

</svg>

<span>Add to Cart</span>                      
                                    

                                </button>
                            </form>
                        @else
                            <button disabled
                                class="flex-1 w-full inline-flex items-center justify-center gap-2 rounded-2xl
                                bg-gray-200 text-gray-500 font-bold py-3.5 cursor-not-allowed">
                                Sold out
                            </button>
                        @endif

                        <a href="{{ url()->previous() }}"
                           class="sm:w-28 inline-flex items-center justify-center rounded-2xl
                           border border-gray-200 bg-white hover:bg-gray-50
                           font-extrabold text-gray-700 py-3.5 transition">
                            Back
                        </a>

                    </div>

                    <p class="mt-4 text-xs text-gray-500">
                        Tip: Click the image to zoom and view details clearly.
                    </p>

               

                    {{-- Description --}}
                    @if($product->description)
                        <div class="mt-7">
                            <h3 class="text-sm font-extrabold text-gray-900">Description</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-600">
                                {{ $product->description }}
                            </p>
                        </div>
                    @endif

                    
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

    if (thumbBtns.length) {
        thumbBtns[0].classList.add('ring-2', 'ring-pink-700');
    }

    thumbBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const src = btn.getAttribute('data-src');

            mainImage.src = src;
            lightboxImage.src = src;

            thumbBtns.forEach(b => b.classList.remove('ring-2', 'ring-pink-700'));
            btn.classList.add('ring-2', 'ring-pink-700');
        });
    });

    openLightbox?.addEventListener('click', () => {
        lightbox.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    function closeModal() {
        lightbox.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    closeLightbox?.addEventListener('click', closeModal);
    overlay?.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
            closeModal();
        }
    });

    const variantButtons = document.querySelectorAll('.variant-btn');
    const selectedVariantInput = document.getElementById('selectedVariant');

    variantButtons.forEach(btn => {
        btn.addEventListener('click', () => {

            if (btn.disabled) {
                return;
            }

            variantButtons.forEach(b => {
                if (b.disabled) {
                    return;
                }

                b.classList.remove('border-pink-700', 'ring-2', 'ring-pink-200');

                const name = b.closest('.variant-wrapper').querySelector('.variant-name');
                name.classList.remove('text-pink-700', 'font-semibold');
                name.classList.add('text-gray-500');
            });

            btn.classList.add('border-pink-700', 'ring-2', 'ring-pink-200');

            const name = btn.closest('.variant-wrapper').querySelector('.variant-name');
            name.classList.remove('text-gray-500');
            name.classList.add('text-pink-700', 'font-semibold');

            if (selectedVariantInput) {
                selectedVariantInput.value = btn.dataset.id;
            }

            if (btn.dataset.image) {
                mainImage.src = btn.dataset.image;
                lightboxImage.src = btn.dataset.image;
            }

        });
    });
});
</script>

@endsection