<section id="categories" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">

        {{-- Title --}}
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                Shop By Category
            </h2>
            <p class="text-gray-500 mt-2">
                Discover your beauty essentials
            </p>

            <div class="mt-5 flex justify-center">
                <div class="h-[3px] w-20 rounded-full bg-gradient-to-r from-pink-500 to-fuchsia-500"></div>
            </div>
        </div>

        @if($categories->count())
            <div class="flex flex-wrap justify-center gap-x-10 gap-y-10">

                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="group flex flex-col items-center text-center w-28 sm:w-32">

                        {{-- Circle Image --}}
                        <div
                            class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-full
                                   bg-gradient-to-br from-pink-100 to-fuchsia-100
                                   p-[3px]
                                   shadow-md shadow-pink-100
                                   group-hover:shadow-lg group-hover:shadow-pink-200
                                   transition">

                            <div class="w-full h-full rounded-full bg-white overflow-hidden flex items-center justify-center">
                                @if($category->image)
                                    <img
                                        src="{{ asset('storage/'.$category->image) }}"
                                        alt="{{ $category->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                    >
                                @else
                                    <div class="text-pink-400 text-xs font-semibold">No Image</div>
                                @endif
                            </div>

                            {{-- badge if has children --}}
                            @if($category->children->count())
                                <span class="absolute -top-2 -right-2 text-[10px] font-bold
                                             bg-pink-600 text-white w-6 h-6 rounded-full flex items-center justify-center
                                             shadow">
                                    {{ $category->children->count() }}
                                </span>
                            @endif
                        </div>

                        {{-- Name --}}
                        <p class="mt-3 text-sm font-semibold text-gray-800 group-hover:text-pink-600 transition">
                            {{ $category->name }}
                        </p>

                        <p class="text-[11px] text-gray-400">
                            {{ $category->children->count() ? 'Sub-categories' : 'Products' }}
                        </p>
                    </a>
                @endforeach

            </div>

            {{-- Browse all button (UNDER categories) --}}
            <div class="mt-12 flex justify-center">
                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3
                          rounded-xl border border-pink-500
                          text-pink-600 font-semibold text-sm
                          hover:bg-pink-50 hover:text-pink-700 transition">
                    Browse all categories
                    <span class="text-base">→</span>
                </a>
            </div>

        @else
            <p class="text-center text-gray-500">No categories found.</p>
        @endif

    </div>
</section>
