@if ($paginator->hasPages())
<ul class="c-pagination__list">
    
    @if ($paginator->onFirstPage())
    <li class="c-pagination__item" class="disabled">
        <a class="c-pagination__control">
            <i class="fa fa-caret-left"></i>
        </a>
    </li>
    @else
    <li class="c-pagination__item">
        <a class="c-pagination__control" href="{{ $paginator->previousPageUrl() }}">
            <i class="fa fa-caret-left"></i>
        </a>
    </li>
    @endif
    
    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="c-pagination__item disabled"><span>{{ $element }}</span></li>
            <!-- <li class="disabled"><span>{{ $element }}</span></li> -->
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="c-pagination__item">
                        <a class="c-pagination__link is-active" >{{ $page }}</a>
                    </li>
                    <!-- <li class="active"><span>{{ $page }}</span></li> -->
                @else
                    <li class="c-pagination__item"><a class="c-pagination__link" href="{{ $url }}">{{ $page }}</a></li>
                    <!-- <li><a href="{{ $url }}">{{ $page }}</a></li> -->
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="c-pagination__item">
            <a class="c-pagination__control" href="{{ $paginator->nextPageUrl() }}">
                <i class="fa fa-caret-right"></i>
            </a>
        </li>
        <!-- <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li> -->
    @else
        <li class="c-pagination__item">
            <a class="c-pagination__control">
                <i class="fa fa-caret-right"></i>
            </a>
        </li>
        <!-- <li class="disabled"><span>&raquo;</span></li> -->
    @endif
    
</ul>
            
@endif