<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>INDEX</title>
    </head>
    <body>
<ul>
	@foreach ($addresses as $address)
		 <li><a href="{{ route('addresses.show', ['address' => $address]) }}">{{$address->address}}</a> - <a href="{{ route('addresses.edit', ['address' => $address]) }}">Редактировать</a> - 
		<form name="delete" method="POST" action="{{ route('addresses.destroy', ['address' => $address]) }}">
			@csrf
			@method('DELETE')
			<button type="submit">Удалить</button>
		</form></li>
		<li><a href="{{ route('addresses.create') }}">Добавить еще адрес</a></li>
	@endforeach
</ul>
    </body>
</html>
