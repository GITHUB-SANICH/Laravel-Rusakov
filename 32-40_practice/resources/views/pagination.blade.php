@if ($paginator->hasPages())
    <div id="pagination">
        <span>Страница {{ $paginator->currentPage() }} из {{ $paginator->lastPage() }}</span>
        <div id="pages">
			{{-- если первая страницы --}}
            @if ($paginator->onFirstPage())
                В начало&nbsp; &laquo;&nbsp;
            @else
				{{-- если не первая страницы --}}
                <a href="{{ Request::url() }}">В начало</a>&nbsp;
                <a href="{{ $paginator->previousPageUrl() }}">&laquo;</a>&nbsp;
            @endif
				{{-- вывод страниц --}}
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        {{-- номер  текущая страницы выводится текстом --}}
						  		@if ($page == $paginator->currentPage())
                            {{ $page }}&nbsp;
                        {{-- не текущая выводится ссылкой --}}
								@else
                            <a href="{{ $url }}">{{ $page }}</a>&nbsp;
                        @endif
                    @endforeach
                @endif
            @endforeach
				{{-- если последняя страницы --}}
            @if ($paginator->onLastPage())
                &raquo;&nbsp; В конец
            @else
				{{-- если не последняя страницы --}}
                <a href="{{ $paginator->nextPageUrl() }}">&raquo;</a>&nbsp;
                <a href="{{ Request::url().'?page='.$paginator->lastPage() }}">В конец</a>
            @endif
        </div>
        <div class="clear"></div>
    </div>
@endif