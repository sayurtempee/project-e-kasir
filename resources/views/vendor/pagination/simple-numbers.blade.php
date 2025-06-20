@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center space-x-2 mt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-sm text-gray-400 rounded border"
                style="background:#fff; border-color:#fff;">&lt;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-1 text-sm text-blue-700 hover:bg-blue-100 rounded border"
                style="background:#fff; border-color:#fff;">&lt;</a>
        @endif

        {{-- Page Number Links --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-sm text-gray-400 rounded border"
                    style="background:#fff; border-color:#fff;">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 text-sm text-white bg-blue-800 rounded border"
                            style="border-color:#fff;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1 text-sm text-blue-800 hover:bg-blue-100 rounded border"
                            style="background:#fff; border-color:#fff;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-1 text-sm text-blue-800 hover:bg-blue-100 rounded border"
                style="background:#fff; border-color:#fff;">&gt;</a>
        @else
            <span class="px-3 py-1 text-sm text-gray-400 rounded border"
                style="background:#fff; border-color:#fff;">&gt;</span>
        @endif
    </nav>
@endif
