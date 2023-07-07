<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TestForm</title>
    </head>
    <body>
		@if ($errors->any())
			<h3>Ошибки при заполнении формы:</h3>
			<div>
				@foreach ($errors->all() as $message)
					<p style="color: red">{{$message}}</p>
				@endforeach
			</div>
		@endif

		<h2>Тестовая форма</h2>
		<form name="myform" action="/testform/sendbyrequest" method="post">
			@csrf
			@method('POST')
				<label for="name">Ваше имя:</label><br>
				@error('name')<p style="color: red">{{ $message }}</p>@enderror
					<input type="text" id="name" name="name" value="{{ old('name') }}"><br>
				<label for="text">Ваше сообщение:</label><br>
					<textarea type="text" name="text" id="text" cols="30" rows="10" value="{{ old('text') }}"></textarea><br>
				<label for="bd">Дата рождения:</label><br>
					<input type="date" id="bd" name="bd" value="{{ old('bd') }}"><br><br>
				<button type="submit">Отправить</button>
		</form>
    </body>
</html>
