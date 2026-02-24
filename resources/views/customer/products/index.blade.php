<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>All Products</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

@include('customer.home.sections.navbar')
<div class="h-16"></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div class="flex items-end justify-between mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">All Products</h1>
            <p class="text-gray-500 mt-1">Browse everything in Om Ali Store.</p>
        </div>
    </div>

    @if($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product->id) }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition overflow-hidden">

                    <div class="relative w-full aspect-square bg-pink-50 flex items-center justify-center p-3">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="w-full h-full object-contain group-hover:scale-105 transition duration-300"
                                 alt="{{ $product->name }}">
                        @else
                            <div class="text-pink-400 text-sm font-semibold">No Image</div>
                        @endif
                    </div>

                    <div class="p-3">
                        <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-pink-600 transition">
                            {{ $product->name }}
                        </p>

                        @if($product->discount_percentage > 0)
                            <p class="text-xs text-gray-400 line-through">
                                {{ number_format($product->price, 2) }} EGP
                            </p>
                            <p class="text-pink-600 font-bold">
                                {{ number_format($product->discounted_price, 2) }} EGP
                            </p>
                        @else
                            <p class="text-gray-900 font-bold">
                                {{ number_format($product->price, 2) }} EGP
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-gray-500">No products found.</p>
    @endif
</div>

</body>
</html>
