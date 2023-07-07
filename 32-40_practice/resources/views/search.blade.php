<x-main-layout>
	<x-slot name="title">Поиск: {{$search_query}}</x-slot>
	<x-slot name="description">поиск {{$search_query}}</x-slot>
	<x-slot name="keywords">поиск, поиск {{ mb_strtolower($search_query) }}</x-slot>
	<x-slot name="left">
		@if (!count($posts))
			<div id="other">
				<h1>Результаты поиска: {{$search_query}}</h1>
				<div id="pm">
					<p>Ничего не найдено!</p>
					<p><a href="{{route('index')}}">Вернуться на главную</a></p>
				</div>
			</div>
		@else
			@foreach ($posts as $post)
				@include('post_intro')
			@endforeach
			{{ $posts->links('pagination') }}
		@endif
	</x-slot>
</x-main-layout>