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
	<li>
		@can('view', $address)
			<a href="{{ route('addresses.show', ['address' => $address]) }}">{{$address->address}}</a>
			@else
				<span>Ссылка недоступна для просмотра</span>
		@endcan
		- 
		@can('update', $address) 
				<a href="{{ route('addresses.edit', ['address' => $address]) }}">Редактировать</a>
			@else
				<span>редактирование недоступно</span>
		@endcan
		-
		@can('delete', $address) 
		<form name="delete" method="POST" action="{{ route('addresses.destroy', ['address' => $address]) }}">
			@csrf
			@method('DELETE')
			<button type="submit">Удалить</button>
		</form>
		@else
			<span>удаление недоступно</span>
		@endcan
	</li>
		@endforeach
		-
		@can('create', App\Models\Address::class)
			<li><a href="{{ route('addresses.create') }}">Добавить еще адрес</a></li>
		@else
			<span>создание записей недоступно</span>
		@endcan
		@can('myPrava', [App\Models\Address::class, 6])
			<span>Право "myPrava" успешно реализовано</span>
		@endcan
		
</ul>
    </body>
</html>
