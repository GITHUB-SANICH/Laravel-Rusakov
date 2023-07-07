<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>TetComponents</title>
</head>
<body>
	<br>
	{{-- значение введенное в шаблоне --}}
	<label for="">Компаненты "my-input"</label><br>
	<x-forms.my-input input-type="text" value="Содержимое поля"/><br> {{--если убрать поле "value", то в компанент подставится переданное значение контроллера--}}
	<x-forms.my-input input-type="text" value="{{$a}}"/><br> {{-- значение полученное из контроллера --}}
	<x-forms.my-input input-type="text" placeholder="Test placeholder"/><br>
	<x-error-simple message="сообщение об ошибке"/>
	<x-forms.fitback-form value-input="Имя в поле" value-email="Почта в поле"/>
	{{-- Компанент со слотами --}}
	<x-error-message>
		<x-slot name="header" class="my-class">Ошибка, выведенная из второго слота.</x-slot>
		<i>Выыод ошибки из первого слота</i>
	</x-error-message>
</body>
</html>
