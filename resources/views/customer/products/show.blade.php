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
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-pink-600 transition">
            <span class="text-lg">←</span> Back
        </a>
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
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

        {{-- ================== GALLERY ================== --}}
        <section class="lg:col-span-7">
            <div class="rounded-3xl border border-pink-100/70 bg-white/70 backdrop-blur-xl shadow overflow-hidden">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col lg:flex-row gap-4">

                        {{-- Thumbs --}}
                        @if($gallery->count() > 1)
                            <div class="flex lg:flex-col gap-3 overflow-auto">
                                @foreach($gallery as $src)
                                    <button type="button"
                                        class="thumbBtn w-16 h-16 rounded-xl border"
                                        data-src="{{ $src }}">
                                        <img src="{{ $src }}" class="w-full h-full object-contain p-2">
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        {{-- Main image --}}
                        <div class="flex-1">
                            <img id="mainImage"
                                 src="{{ $firstImage }}"
                                 class="w-full aspect-square object-contain p-6">
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- ================== INFO ================== --}}
        <section class="lg:col-span-5">
            <div class="sticky top-24">

                <div class="rounded-3xl border border-pink-100/70 bg-white p-6 shadow">

                    {{-- Title --}}
                    <h1 class="text-2xl sm:text-3xl font-extrabold">
                        {{ $product->name }}
                    </h1>

                    {{-- Stock --}}
                    <div class="mt-3">
                        <span class="text-sm font-bold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}
                        </span>
                    </div>

                    {{-- Price --}}
                    <div class="mt-5">
                        @if($hasDiscount)
                            <div class="flex items-center gap-3">
                                <span class="line-through text-gray-400">
                                    {{ number_format($product->price, 2) }} EGP
                                </span>

                                <span class="text-2xl font-extrabold text-pink-600">
                                    {{ number_format($product->discounted_price, 2) }} EGP
                                </span>
                            </div>
                        @else
                            <div class="text-2xl font-extrabold text-gray-900">
                                {{ number_format($product->price, 2) }} EGP
                            </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    @if($product->description)
                        <p class="mt-6 text-gray-600 text-sm">
                            {{ $product->description }}
                        </p>
                    @endif

                    {{-- ================== ACTIONS ================== --}}
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">

                        {{-- ✅ AJAX FORM --}}
                        <form class="add-to-cart-form flex-1">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" value="1">

                            <button type="submit"
                                class="add-to-cart-btn w-full inline-flex items-center justify-center gap-2 rounded-2xl
                                bg-gradient-to-r from-pink-600 to-fuchsia-600
                                hover:from-pink-700 hover:to-fuchsia-700
                                text-white font-extrabold py-3.5 shadow-lg transition">

                                <span>🛍️</span>
                                Add to Cart

                            </button>
                        </form>

                        <a href="{{ url()->previous() }}"
                           class="sm:w-28 inline-flex items-center justify-center rounded-2xl
                           border border-gray-200 bg-white hover:bg-gray-50
                           font-extrabold text-gray-700 py-3.5 transition">
                            Back
                        </a>

                    </div>

                </div>
            </div>
        </section>

    </div>
</main>

{{-- Image Switch Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const mainImage = document.getElementById('mainImage');

    document.querySelectorAll('.thumbBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            mainImage.src = btn.dataset.src;
        });
    });

});
</script>

@endsection