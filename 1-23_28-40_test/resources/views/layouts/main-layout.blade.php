<!DOCTYPE html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>{{$title ?? 'Заголовок страницы'}}</title>
</head>
<body>
	<div>Шапка сайта</div>
	<div>
		<div>Основное меню</div> 
		<div>Корзина (по заданию) - макет  снаследованием</div> 
		{{$left}}
	</div>
	<div>
		{{$content}}
	</div>
	<div>Подвал</div>
</body>
</html>
