<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@if ($action == 'create') Добавить@else Изменить@endif адрес</title>
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

		<h2>@if ($action == 'create') Добавить@else Изменить@endif адрес</h2>
		<form name="address" action="@if ($action == 'create'){{ route('addresses.store') }}@else{{ route('addresses.update', ['address' => $address]) }}@endif" method="post">
			@csrf
			@if ($action == 'edit') @method('PUT')@endif
				<label for="address"><b>Адрес:</b></label><br>
				@error('address')<p style="color: red">{{ $message }}</p>@enderror
					<input type="text" id="address" name="address" value="@if ($action == 'create') {{ old('address') }} @else {{ $address->address }}@endif"><br><br>
				<button type="submit">@if ($action == 'create') Добавить@else Изменить@endif</button>
		</form>
    </body>
</html>
