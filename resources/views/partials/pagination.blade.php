@if ($paginator->total() > 0)
<div class="modern-pagination-container">
    <div class="modern-pagination-info">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ number_format($paginator->total(), 0, ',', '.') }} results
    </div>

    @if ($paginator->hasPages())
    <nav aria-label="Navigasi Halaman">
        <ul class="modern-pagination-list">
            {{-- Tombol Sebelumnya (‹) --}}
            @if ($paginator->onFirstPage())
                <li class="page-item-modern disabled" aria-disabled="true" aria-label="Previous">
                    <span class="page-link-modern" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item-modern">
                    <a class="page-link-modern" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">&lsaquo;</a>
                </li>
            @endif

            {{-- Elemen Halaman --}}
            @foreach ($elements as $element)
                {{-- Pemisah "..." --}}
                @if (is_string($element))
                    <li class="page-item-modern disabled" aria-disabled="true">
                        <span class="page-link-modern dots">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Nomor Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item-modern active" aria-current="page">
                                <span class="page-link-modern">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item-modern">
                                <a class="page-link-modern" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya (›) --}}
            @if ($paginator->hasMorePages())
                <li class="page-item-modern">
                    <a class="page-link-modern" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item-modern disabled" aria-disabled="true" aria-label="Next">
                    <span class="page-link-modern" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
    @endif
</div>
@endif

