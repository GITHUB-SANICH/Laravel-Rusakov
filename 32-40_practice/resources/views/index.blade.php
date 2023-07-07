<x-main-layout>
	<x-slot name="title">Личный блог Михаила Русакова</x-slot>
	<x-slot name="description">Личный блог Михаила Русакова и его выпуски рассылки</x-slot>
	<x-slot name="keywords">михаил русаков, блог михаил русаков, рассылка михаил русаков</x-slot>
	<x-slot name="left">
		@foreach ($posts as $post)
			@include('post_intro')
		@endforeach
		{{$posts->links('pagination')}}
	</x-slot>
	<x-slot name="right">
		<div id="author">
			<h4>Автор блога</h4>
			<img src="images/author.png" alt="Михаил Русаков" />
			<p>Михаил Русаков</p>
			<a target="_blank" href="https://vk.com/myrusakov">СТРАНИЦА АВТОРА</a>
	  </div>
	</x-slot>
</x-main-layout>