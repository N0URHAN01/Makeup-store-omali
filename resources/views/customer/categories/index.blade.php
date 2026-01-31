<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories | Om Ali</title>

    @vite('resources/css/app.css')
</head>
<body class="bg-white">

    {{-- Navbar --}}
    @include('customer.home.sections.navbar')

    {{-- Page Header --}}
    <section class="bg-pink-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">
                All Categories
            </h1>
            <p class="mt-4 text-gray-600 text-lg max-w-xl mx-auto">
                Explore all beauty categories — makeup, skincare, perfumes and more.
            </p>

            <div class="mt-6 flex justify-center">
                <div class="h-[3px] w-24 rounded-full bg-gradient-to-r from-pink-500 to-fuchsia-500"></div>
            </div>
        </div>
    </section>

    {{-- Categories Grid --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16">

            @if($categories->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-10 gap-y-14 justify-items-center">

                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}"
                           class="group flex flex-col items-center text-center">

                            {{-- Circle Image --}}
                            <div
                                class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-full
                                       bg-gradient-to-br from-pink-100 to-fuchsia-100
                                       p-[3px]
                                       shadow-md shadow-pink-100
                                       group-hover:shadow-xl group-hover:shadow-pink-200
                                       transition-all duration-300">

                                <div class="w-full h-full rounded-full bg-white overflow-hidden flex items-center justify-center">
                                    @if($category->image)
                                        <img
                                            src="{{ asset('storage/'.$category->image) }}"
                                            alt="{{ $category->name }}"
                                            class="w-full h-full object-cover
                                                   group-hover:scale-110 transition duration-300"
                                        >
                                    @else
                                        <div class="text-pink-400 text-xs font-semibold">
                                            No Image
                                        </div>
                                    @endif
                                </div>

                                {{-- Badge if has children --}}
                                @if($category->children->count())
                                    <span class="absolute -top-2 -right-2 text-[11px] font-bold
                                                 bg-pink-600 text-white w-7 h-7 rounded-full
                                                 flex items-center justify-center shadow">
                                        {{ $category->children->count() }}
                                    </span>
                                @endif
                            </div>

                            {{-- Name --}}
                            <h3 class="mt-4 text-base font-semibold text-gray-800
                                       group-hover:text-pink-600 transition">
                                {{ $category->name }}
                            </h3>

                            <p class="text-xs text-gray-400 mt-1">
                                {{ $category->children->count() ? 'Sub-categories' : 'Products' }}
                            </p>

                        </a>
                    @endforeach

                </div>
            @else
                <p class="text-center text-gray-500">
                    No categories found.
                </p>
            @endif

        </div>
    </section>

</body>
</html>
