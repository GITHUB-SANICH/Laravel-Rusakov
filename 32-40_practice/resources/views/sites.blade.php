<x-main-layout>
	<x-slot name="title">Сайты моих учеников</x-slot>
	<x-slot name="description">Список сайтов моих учеников.</x-slot>
	<x-slot name="keywords">список сайтов, список сайтов ученики, список сайтов ученики михаил русаков</x-slot>
	<x-slot name="left">
			<div id="other">
			<h1>Сайты моих учеников</h1>
			<p class="center">
				 <img src="images/sites.png" alt="Сайты моих учеников">
			</p>
			<p>Ниже идёт список сайтов, которые были созданы моими учениками. Добавить ещё сайт можно <a href="{{route('sites.add')}}">здесь</a>. Обратите внимание, что обязательным условием является наличие какой-нибудь фразы на главной страницы сайта, свидетельствующей о том, что сайт принадлежит Вам и Вы его создали благодаря моим урокам! Например, это может быть "Спасибо Михаилу Русакову!". Как альтернативу можно просто поставить ссылку на мой сайт <b>myrusakov.ru</b>, либо на любой другой из моих сайтов.</p>
			<ul id="sites" class="ul_mark">
				@foreach ($sites as $site)
					<li><a target="_blank" rel="external" href="{{$site->address}}">{{$site->address}}</a> - <span>{{$site->description}}</span></li>
				@endforeach
			</ul>
	 	 </div>
	</x-slot>
</x-main-layout>