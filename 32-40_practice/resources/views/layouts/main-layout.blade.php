
<!DOCTYPE html>
<html lang="ru">
<head>
	<title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="{{ $description }}" />
    <meta name="keywords" content="{{ $keywords }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link type="text/css" rel="stylesheet" href="/styles/main.css" />
    <link type="text/css" rel="stylesheet" href="/styles/fancybox.css" />
    <script src="/js/jquery.js"></script>
    <script src="/js/is_mobile.js"></script>
    <script src="/js/fancybox.js"></script>
    <script src="/js/functions.js"></script>
	<script async src="https://vk.com/js/api/openapi.js?121"></script>
	{{-- тут должна быть рекапча --}}
	{!! htmlScriptTagJsApi() !!}
	{{--{!! htmlScriptTagJsApi($configuration) !!}--}}
</head>
<body>
	<div id="header">
		<ul class="menu">
            <li>
                <a href="{{ route('author') }}">Об авторе</a>
            </li>
            <li>
                <a href="{{ route('courses') }}">Видеокурсы</a>
            </li>
            <li>
                <a href="{{ route('releases') }}">Выпуски рассылки</a>
            </li>
            <li>
                <a href="{{ route('sites') }}">Сайты учеников</a>
            </li>
            <li>
                <a target="_blank" href="https://myrusakov.ru">Мой сайт</a>
            </li>
            <li>
                <a target="_blank" href="https://support.myrusakov.ru">Поддержка</a>
            </li>
        </ul>
        <div class="clear"></div>
		<div id="header_title">
			<h2><a href="{{ route('index') }}">блог Михаила Русакова</a></h2>
		</div>
		<div id="search">
			<form name="search" method="get" action="{{route('search')}}">
				@csrf
               <input type="hidden" name="_token" value="i6yi4ysAPfHeWGPglYGnBrbKw9RZFWCk3iPmairH">				
					<div>
						<input type="text" name="search_query" placeholder="Поиск" />
						<input type="image" src="/images/search_icon.png" alt="Поиск" />
					</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
	<div id="content">
		<div id="slider">
			{{-- вывод курсов в слайдере --}}
				@foreach ($slider as $course)
				<div class="slider_item">
					<img src="/images/courses/{{ $course->alias }}.png" alt="{{ $course->title }}" />
					<div class="slider_content">
						 <h3>{{$course->title}}</h3>
						 <p>{{$course->slider_description}}</p>
					</div>
					<div class="more"><a target="_blank" href="https://srs.myrusakov.ru/{{ $course->alias }}?utm_source=Blog.MyRusakov.ru&amp;utm_campaign={{ $course->alias }}">УЗНАТЬ ПОДРОБНЕЕ</a></div>
			  </div>
				@endforeach

				<div class="clear"></div>
            <div id="bullets">
					{{-- переключатели курсов --}}
					<div class="active"></div>
						@for ($i = 1; $i < count($slider); $i++)
							<div></div>
						@endfor
					</div>
        </div>
		  {{-- левый блок --}}
        <div id="left">{{$left}}</div>
		  {{-- правый блок-сайдбар --}}
		  <div id="right">{{ $right?? '' }}
		  {{-- курсы бесплатные --}}
			<div class="courses" id="courses">
					@foreach ($courses as $course)
					<div class="course">
						<h4>{{$course->title}}</h4>
						<img src="/images/courses/{{$course->alias}}.png" alt="{{$course->title}}" />
						<p class="more">
							 <a target="_blank" href="https://srs.myrusakov.ru/{{$course->alias}}?utm_source=Blog.MyRusakov.ru&amp;utm_campaign={{ $course->alias }}">ПОЛУЧИТЬ БЕСПЛАТНО</a>
						</p>
				  </div>
					@endforeach
						<div class="arrows">
                    <div>
                        <div class="left">
                            <img src="/images/arrow_left.png" alt="" />
                        </div>
                        <div>Бесплатные курсы</div>
                        <div class="right">
                            <img src="/images/arrow_right.png" alt="" />
                        </div>
                    </div>
                </div>
            </div>	

            <div id="recommendations">
				<h4>Рекомендую</h4>
				<div>
					<a target="_blank" class="more" href="https://myrusakov.ru/r/reg">REG.RU</a>
					<a target="_blank" href="https://myrusakov.ru/r/reg"><img src="/images/regru.png" alt="" /></a>
					<p>Одно из лучших мест, где можно зарегистрировать на себя доменное имя за скромную плату. Все свои домены перенёс к ним и покупаю новые только у них!</p>
				</div>
				<div>
					<a target="_blank" class="more" href="https://myrusakov.ru/r/hostia">HOSTIA.RU</a>
					<a target="_blank" class="more" href="https://myrusakov.ru/r/hostia"><img src="/images/hostia.png" alt="" /></a>
					<p>На мой взгляд, лучший хостинг в Рунете. Я перепробовал много их, то они были медленными, то отключались часто, то была высокая цена. Hostia.ru - это отличная скорость, высокая надёжность и при этом низкая цена (от 0.88$ в месяц).</p>
				</div>
			</div>		
		</div>
		<div class="clear"></div>
	</div>
	<footer>
		<p>
			<img src="/images/logo_footer.png" alt="" />
		</p>
		<p>
			<img src="/images/logo_arrow.png" alt="" />
			<a href="{{route('index')}}"><span>блог Михаила Русакова</span></a>
		</p>
		<ul class="menu">
            <li>
                <a href="{{route('author')}}">Об авторе</a>
            </li>
            <li>
                <a href="{{route('courses')}}">Видеокурсы</a>
            </li>
            <li>
                <a href="{{route('releases')}}">Выпуски рассылки</a>
            </li>
            <li>
                <a href="{{route('sites')}}">Сайты учеников</a>
            </li>
            <li>
                <a target="_blank" href="https://myrusakov.ru">Мой сайт</a>
            </li>
            <li>
                <a target="_blank" href="https://support.myrusakov.ru">Поддержка</a>
            </li>
        </ul>
        <div class="clear"></div>
        <div id="copy">
            <p>&copy; Blog.MyRusakov.ru {{date('Y')}} г.</p>
            <p>ВСЕ ПРАВА ЗАЩИЩЕНЫ.</p>
        </div>
	</footer>
</body>
</html>