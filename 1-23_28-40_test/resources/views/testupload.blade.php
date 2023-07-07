<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FormUpload</title>
    </head>
    <body>
    <body>
		@if ($errors->any())
			<h3>Ошибки при заполнении формы:</h3>
			<div>
				@foreach ($errors->all() as $message)
					<p style="color: red">{{$message}}</p>
				@endforeach
			</div>
		@endif
		@if ($image)
		<h4>Загруженное изображения:</h4>		
			<img src="{{ $image }}" alt="">			 
			<p>{{ $public_url }}</p>
			<p>{{ $local_url }}</p>
			<hr>
		@endif

		<h2>Форма для загрузки файла</h2>
		<form name="myform" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@csrf
			@method('POST')
				<label for="image">Загрузка изображения</label><br>
				@error('image')<p style="color: red">{{ $message }}</p>@enderror
					<input type="file" id="image" name="image" value="{{ old('image') }}"><br><br>
				<input type="submit" name="submit"></input>
		</form>
    </body>
</html>
