<!DOCTYPE html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>Проверка шаблона</title>
</head>
<body>
		<p><b>Первая</b> переменная: {{ $a }}</p>
		<p><b>Вторая</b> переменная: {{ $b }}</p>
		@includeWhen($a == 'Какие нибуть данные', 'childe', ['data' => 'еще какие то данные'])
		<script>
			let x = {{ Js::from([1, 2, 3]) }}; //пример преоразования массива или объекта в JSON-строку
		</script>
</body>
</html>