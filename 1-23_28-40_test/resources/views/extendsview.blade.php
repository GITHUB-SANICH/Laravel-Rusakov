<!DOCTYPE html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>@yield('title', 'Заголовок страницы')</title>
</head>
<body>
	<div>Шапка сайта</div>
	<div>
		@section('left')
			<div>Основное меню</div> 
			<div>Корзина (по заданию) - макет  снаследованием</div> 
		@show
	</div>
	<div>
		@yield('content')
	</div>
	<div>
		Подвал
	</div>
	{{--@mycurrency('12', 'rub')--}}
</body>
</html>
