@if ($paginator->hasPages())
    <div class="flex justify-center mt-10">

        <div class="flex items-center gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-gray-300 cursor-not-allowed">←</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-2 rounded-xl border border-gray-200 hover:bg-pink-50">
                    ←
                </a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)

                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 rounded-xl bg-pink-600 text-white font-semibold shadow">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-4 py-2 rounded-xl border border-gray-200 hover:bg-pink-50 hover:border-pink-300 transition">
                                {{ $page }}
                            </a>
                        @endif

                    @endforeach
                @endif

            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-2 rounded-xl border border-gray-200 hover:bg-pink-50">
                    →
                </a>
            @else
                <span class="px-3 py-2 text-gray-300 cursor-not-allowed">→</span>
            @endif

        </div>

    </div>
@endif