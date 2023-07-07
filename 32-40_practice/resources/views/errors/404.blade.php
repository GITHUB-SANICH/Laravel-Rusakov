<x-main-layout>
	<x-slot name="title">Страница не найдена - 404</x-slot>
	<x-slot name="description">Запрошенаня страница не существует.</x-slot>
	<x-slot name="keywords">404, страница не найдена, страница не существует</x-slot>
	<x-slot name="left">
		<div id="other">
			<h1>Страница не найдена</h1>
			<div id="pm">
				<p>К сожалению, запрошенная страница не существует</br>Проверьте правильность ввода адреса.</p>
				<p><a href="{{route('index')}}">Вернуться на главную</a></p>
			</div>
		</div>
	</x-slot>
</x-main-layout>