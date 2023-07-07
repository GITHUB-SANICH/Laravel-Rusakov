<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SHOW-Адрес: {{ $address->adress }}</title>
    </head>
    <body>
		<p><b>{{ $address->address }}</b></p>
		<a href="{{ route('addresses.index') }}">Вернуться на главную</a>
    </body>
</html>
