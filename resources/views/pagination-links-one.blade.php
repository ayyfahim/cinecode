<!-- resources/views/vendor/pagination/custom.blade.php -->

@if ($paginator->hasPages())
    <div class="join">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="join-item btn btn-disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                &laquo;
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn" rel="prev"
                aria-label="@lang('pagination.previous')">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <button class="join-item btn btn-disabled" aria-disabled="true">{{ $element }}</button>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="join-item btn btn-active" aria-current="page">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn" rel="next"
                aria-label="@lang('pagination.next')">
                &raquo;
            </a>
        @else
            <button class="join-item btn btn-disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                &raquo;
            </button>
        @endif
    </div>
@endif
