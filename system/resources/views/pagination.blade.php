@if ($paginator->hasPages())
    <ul class="pagination pagination-round pagination-primary">
        <!-- Previous Page Link  -->
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link" >Prev</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a></li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="page-item"><a  class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
        <li class="page-item active"> <a  class="page-link" href="javascript:void();">...</a> <span></span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active"> <a  class="page-link" href="javascript:void();">{{ $i }}</a> <span></span></li>
                @else
                    <li class="page-item "><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
        <li class="page-item disabled"> <a  class="page-link" href="javascript:void();">...</a> <span></span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item"><a  class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

         <!-- Next Page Link  -->
        @if ($paginator->hasMorePages())
            <li class="page-item"><a  class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
        @else
            <li class="page-item disabled"><a  class="page-link" href="javascript:void();" rel="next">Next</a></li>
        @endif
    </ul>
@endif