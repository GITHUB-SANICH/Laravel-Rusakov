<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Пагинация</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    	<body>
			{{--<h1>Комментарии (Страница {{ $comments->currentPage() }})</h1>--}}
			{{--{{$comments}}--}}
			{{--@foreach ($comments as $comment)--}}
				 {{--<div>
					<p><b>{{ $comment->name }}:</b> {{ $comment->text }}</p>
				 </div>--}}
			{{--@endforeach--}}
			{{ $comments->links('mypagination') }}
		</body>
</html>