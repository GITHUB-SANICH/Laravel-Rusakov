@if ($paginator->hasPages())
<nav>
	  {{-- Pagination Elements --}}
	  @foreach ($elements as $element)
	  {{-- "Three Dots" Separator --}}
	  @if (is_string($element))
		  <span>
			  <span>{{ $element }}</span>
		  </span>
	  @endif

	  {{-- Array Of Links --}}
	  @if (is_array($element))
		  @foreach ($element as $page => $url)
				  @if ($page == $paginator->currentPage())
					  <span>
						  <span>{{ $page }}</span>
					  </span>
				  @else
					  <a href="{{ $url }}">{{ $page }}</a>
				  @endif
		  @endforeach
	  @endif
  @endforeach
</nav>
@endif