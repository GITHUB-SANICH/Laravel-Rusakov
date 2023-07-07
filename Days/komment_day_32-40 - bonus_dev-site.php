
	<?php

use function Termwind\style;

	echo '<hr><hr><br><h2>Модуль №32.32-40: Бонус "Создание сайта на Laravel"</h2>' . "<br>";
	echo '<hr><hr><br><h3>Laravel - #32.1-3 - Постановка задачи, Создание и настройка проекта, Создание моделей (День 32)</h3><hr><hr>' . "<br>";
		//!Урок 1: Постановка задачи
		/*
			В рамках бонусного курса будем применять полученные ранее теоритические знания на практике через создание сайта с следющего урока.
			Этапы создания сайта:
				1) Протатипирование - определение функций продукта и пользовательского интерфейса.
				2) Дизайн - составление дизайна шаблонов, верстка сайта. 
				3) Связвание шаблонов вместе и подгрузка данных из БД. 
		*/
		//!Урок 2: Создание и настройка проекта
		/*
			Начнем работу с создания нового проекта:
				php composer.phar create-project laravel/laravel 32-40_praktika
			Внесем прилагаемые с курсом файлы (js/styles/img) папки public в проект.
			Созаддим бд и подключем в .env: laravel_Rusakov_practice
			В конфиге выберем русскую локаль.
		*/
		//!Урок 3: Создание моделей
		/*
			В процесе создания моделей нет однозначно правильного и неправильного подхода - это творческий процесс.
				Практика показывает, что с 1-го раза модель правильно создать со всеми необходимыми параметрами редко получается, но в курсе получится. 

				Планируемые модели:
					1) модель поста
						php artisan make:model Post -mfs
						Use SoftDeletes; - мягкое удаление
					2) платные курсы 
						php artisan make:model Course -mfs
					3) бесплатные курсы 
						php artisan make:model FreeCourse -mfs
					4) комментарии
						php artisan make:model Comment -mfs
					TODO ЗАМЕТКА: Введем возможность прописи комментариев без авторзации с возможность удаления. Через access_token.
					5) сайты учеников
						php artisan make:model Site -mfs

				Оставим только созданные мигарции - остальные удалим. 
				Вот некотрые поля из созданных:
					1) посты:
						$table->boolean('is_release'); //пост - рассылка или нет
						$table->string('aleas', 255)->uniqid(); //чпу ссылки
						$table->integer('hits'); //просмотры
						$table->dateTime('data_show'); //заданное время отображения поста (анонс).
						$table->softDeletes(); //мягкое удаление

					2) комменты:
						$table->integer('post_id'); //id поста
						$table->string('access_token', 32); //токен проверки автора коммента, даваемый пользователю при создании коммента (без авторизации).

					3) курсы платные:
						$table->string('alias', 255)->uniqid(); //алиас - псевданим ссылки
						$table->decimal('price', 10, 2); //цена курса. 1-й арг: название поля, 2-й: кол-во символов, 3-й кол-во символов после запятой
					TODO ЗАМЕТКА: для обозначения цен в таблицах лучше использовать тип данных "decimal". 

					4) курсы бесплатные:
						$table->integer('delivery_id'); //номер рассылки - он определяет подписку пользователя

					5) сайты:
						$table->string('address', 255);
						$table->boolean('is_active'); //флаг проверки сайта модератором

					Модели:
						Отношения:
							1) пост
								один ко нмогим с комментариями
							2) коммент
								один ко нмогим с комментариями
						Атребуты:
							1) сайт:
								protected $attribute = ['is_active' => 0];
						Запуск миграции: php artisan migrate:fresh --seed
		*/

	echo '<hr><hr><br><h3>Laravel - #33.1 - Создание фабрик и наполнителей (День 33)</h3><hr><hr>' . "<br>";
		//!Урок 1: Создание фабрик и наполнителей
		/*
			Фабрики и сидеры с прошлого урока - наполним их и запустим. 
			С помощью фейкера не получится с HTML создать текст. Поэтому создадим функцию генерации текста с параграфами HTML.
				'intro_text' => $this->getFakeHTMLText(1), //генерация текста с HTML
				public function getFakeHTMLText($countParagraphs){
					$paragraphs = $this->faker->paragraphs($countParagraphs);
					$text = '';
					foreach ($paragraphs as $p) { //генерация блоков текста
						$text .= "<p>$p</p>";
					}
					return $text;
				}

				TODO ВАЖНО! Так как этот функционал будет повторяться и в других фабриках - создадим для него класс с статическим методом.
				TODO ЗАМЕТКА: faker передается только в качестве аргумента, поэтому приставка "$this" не нужна. 
					class FactoryHelper {
						public static function getFakeHTMLText($faker, $countParagraphs){
							$paragraphs = $faker->paragraphs($countParagraphs);
							$text = '';
							foreach ($paragraphs as $p) { //генерация блоков текста
								$text .= "<p>$p</p>";
							}
							return $text;
						}
					}
					Пример вызова класса: 'intro_text' => FactoryHalper::getFakeHTMLText($this->faker, 1), //генерация текста с HTML

			Алиасы должны быть уникальным и не сгенерированными. Создадим массив из них: $aliases = [ '5steps', 'ab-1', 'ab-2',...];
			  'is_release' => mt_rand(1, 2) == 1, //true || false
            'title' => $this->faker->realText(mt_rand(20, 100)), // текст от 20-100 чимволов
            'alias' => $this->faker->unique()->randomElement($aliases), //вместе с алиасом будет и картинка, отвечающая за пост: analist-img.png 
            'intro_text' => FactoryHelper::getFakeHTMLText($this->faker, 1), //генерация текста с HTML
            'full_text' => FactoryHelper::getFakeHTMLText($this->faker, mt_rand(2, 10)), //от 2 до 10 абзацов
            'meta_key' => implode(', ', $this->faker->words(mt_rand(3, 5))), //возврат массив случайных слов, преобразованных в строку
            'hits' => mt_rand(0, 1000), //число просмотров
            'date_show' => $this->faker->dateTimeBetween($startDate = '-1 year', $endDate = '+1 month') //время показа +-1 год/день
		
			Коменты:
				$dataTime = $this->faker->dateTime(); // случайное время
				'access_token' => Str::random(32), //генератор токена доступа к комменту из 32 символов
				'created_at' => $dataTime, //время созданяи комментария 
				'updated_at' => $dataTime, //время обновления комментария 
			
			Курс:
				'full_description' => FactoryHelper::getFakeHTMLText($this->faker, mt_rand(2, 4)), 
				'price' => mt_rand(1000, 45000), //цена
			
			Курс бесплатный:
				Практически копия платного. 

			Сайты:	
				'address' => 'http://'.$this->faker->domainName(), //адрес сайта
				'is_active' => mt_rand(1, 2) == 1,

			Сидеры:
				$this->call([
					FreeCourseSeeder::class,
					...
				]);
				поста:
					Post::factory()->count(20)->create();
				Коменты:
					Comment::factory()->count(80)->create();
				Курс:
					Course::factory()->count(20)->create();
				Курс бесплатный:
					FreeCourse::factory()->count(20)->create();
				Сайты:
					Site::factory()->count(25)->create();
		*/


	echo '<hr><hr><br><h3>Laravel - #34.1 - Подготовка основного шаблона (День 34)</h3><hr><hr>' . "<br>";
		//!Урок 1: Подготовка основного шаблона
		/*
			Возмем HTML шаблон предлагаемого сайта в материалах курса и будем переводить его на Laravel. 
			В большей части страницы на сайте похожи друг на друга. 
			В ходе урока буудем описывать шаблон главной страницы. 
			
			Для начала заменим ссылки на имена ссылок в маршрутах.
			Передаваемые в шаблон переменные будем помещать в компанент, а его уже дублировать в шаблоны: 
			Создадим папку resources\views\layouts, в котором создадим компанент "main-layout.blade". 
			Создадим компанент, который будет получать информацию, повторяющуюся на страницах.
				php artisan meke:component MainLayout
				resources\views\components\main-layout.blade.php
				Но эта папка нам не нужна, так как мы уже создали файл-шаблон, котоырй и является компанентом. 
				А файл - контроллер компанента - оставим в нем и будем получать данные, передаваемые в компанент:
					app\View\Components\MainLayout.php
					Указываем в нем путь до компанента: 
						return view('layouts.main-layout');
			Сайдбар будем выводить только на главной странице: <div id="right">{{ $right ?? ''}}</div>
			В контроллере компанента создадим и передадим массивы платный и бесплатных курсов:
				$slider = Course::orderByDesc('id')->get();
				$courses = FreeCourse::orderByDesc('id')->get();
				return view('layouts.main-layout', ['slider' => $slider, 'courses' => $courses]);
				
			Вставка для отображения года
				<p>&copy; Blog.MyRusakov.ru {{date('Y')}} г.</p>
		*/

	echo '<hr><hr><br><h3>Laravel - #35.1-2 - Вывод главной страницы, Навигация по страницам (День 35)</h3><hr><hr>' . "<br>";
		//!Урок 1: Вывод главной страницы
		/*
			Займемся выводом главной страницы, создав контроллер и заполнив компанент слотами. 
			Выведем посты время публикации (data_show) которых меньше теущего. Передадим это в виде переменной $posts. Carbon::now() - текущее время. 
			Компанент в прошлом уроке мы создали - теперь создадим для него шаблон => resources\views\index.blade.php
			TODO ЗАМЕТКА: с выводом даты есть сложность. Она должна выглядеть так: "03 декабря 2021". Для этого применим функцию "translatedFormat('d F Y')". 
			Поле "date_show" является строкой, поэтому его нужно перевести в объкт/формат "date". 
			Для этого у нас есть абцессор и мутатор. 
			Для этого в методе Post пропишем:
				protected $casts = [
					'date_show' => 'date'
				];
				где, date_show - поле таблицы, date - изменяемый формат. 
				
			<div class="date">{{$post->date_show->translatedFormat('d F Y')}}</div>, где ('d F Y') - формат вывода времени. Локаль переведент ее на русский. 
			Переносим в компанент левую и правую часть и запускаем. 
			Вывод ссылок постов:
				<a href="{{route('post', ['id' => $post->id])}}">ЧИТАТЬ ПОЛНОСТЬЮ &gt;</a>
		*/

		//!Урок 2: Навигация по страницам
		/*
			Введем разбиение на страницы выводимые посты на гл.странице. 
			Меняем вывод постов в контроллере c ->get() на ->paginate():
				
				$posts = Post::where('date_show', '<', Carbon::now())
				->orderByDesc('date_show')
				->paginate(5);
				НО так напрямую выставлять количество записей на странице не рекомендуется. Для этого число устанавливается в константу в файле .env 
				Пример:
					USER_COUNT_ON_PAGE=5
				И установим ее в пагинатор:
					->paginate(env('USER_COUNT_ON_PAGE'));

				TODO ЗАМЕТКА: рекомендуется все пользовательские настройки/команды/константы называть с префикса USER. 
				Вывод пагинации на странице с постами:
					{{$post->links('pagination')}}
					где,
						links - метод пагинации
						pagination - подключаемый шаблон пагинации с логикой отображения пагинации, в которой передаются ссылки на страницы
					
					В шаблоне:
						1) Проверяем страницы на наличие
							@if ($paginator->hasPages()) ... страницы ... @endif
						2) Выводим текущую и поледнюю страницу
							<span>Страница {{$paginator->currentPage()}} из {{$paginator->lastPage()}}</span>
						3) Ввод на первой странице либо ссылка на первую страницу
							@if ($paginator->onFirstPage())
								В начало&nbsp; &laquo;&nbsp;
							@else
								<a href="{{ Request::url() }}">В начало</a>&nbsp;
								<a href="{{ $paginator->previousPageUrl() }}">&laquo;</a>&nbsp;
							@endif
							где,
								$paginator->onFirstPage() - проверка текущей тсраницы как первой
								Request::url() - url без GET параметров, т.е. 1-я страницы
						4) Предыдущая страницы
							$paginator->previousPageUrl()
						5) Вывод страницы:
							@foreach ($elements as $element)
								@if (is_array($element))
									@foreach ($element as $page => $url)
											@if ($page == $paginator->currentPage())
												{{ $page }}&nbsp;
											@else
												<a href="{{ $url }}">{{ $page }}</a>&nbsp;
											@endif
									@endforeach
								@endif
							@endforeach
						6) Следующая страница, номер последней страницы
							<a href="{{$paginator->nextPageUrl()}}">&raquo </a>
							<a href="{{Request::url().'?page='.$paginator->lastPage()}}">В конец</a>
						7) Последняя страницы
							@if ($paginator->onLastPage())
								&raquo;&nbsp; В конец
							@else
							где,
								$paginator->onLastPage() - проверка последней страницы как последней
					
							
		*/


	echo '<hr><hr><br><h3>Laravel - #36.1-3 - Вывод страницы "Об авторе", Вывод страницы "Видеокурсы", Вывод страницы "Выпуски рассылки" (День 36)</h3><hr><hr>' . "<br>";
		//!Урок 1: Вывод страницы "Об авторе"
		/*
			Выведем страницу об авторе создав шаблон и метод контроллера. Тут все просто. 
			Правого блока в шаблоне не будет. 
		*/

		//!Урок 2: Вывод страницы "Видеокурсы"
		/*
			Выведем страницу о видеокурсах. 
			Создадим метд вывода курсов в контроллере:
				public function courses(){
					return view('author', [
						'courses' => Course::orderByDesc('id')->get(),
						'free_courses' => FreeCourse::orderByDesc('id')->get()
					]);
				}
			Фишки вывода курсов через foreach:
				1) {{$loop->index + 1}}
					Нумерация выведенных курсов
				2) {{$loop->index + count($courses) + 1}}
				TODO ЗАМЕТКА: запись означает продожение списка после вывода платных курсов
					вывод нумерации бесптатных курсов. 
		*/

		//!Урок 3: Вывод страницы "Выпуски рассылки"
		/*
			Реализуем вывод рассылок:
			Через контроллер быудем передавать бесплатные курсы. На странице будет выводиться и номера выпуска и чтобы ее вывести нужно знать общее число выпусков. 

			public function releases(){
				$courses = FreeCourse::orderByDesc('id')->get();
				$posts = Post::orderByDesc('id')
					->where('is_release', 1)
					->where('date_show', '<', Carbon::now())
					->paginate(env('USER_COUNT_ON_PAGE'));
				$count = Post::orderByDesc('id')
				->where('is_release', 1)
				->where('date_show', '<', Carbon::now())
				->count();

				return view('releases', [
					'courses' => $courses,
					'posts' => $posts,
					'count' => $count
				]);
			}
			где,
				$courses - бесплатные курсы, выводимоые в обратном порядке
				$posts - опубликованные посты, выводимые в обратном порядке, выводимые постранично
				$count - количество выпусков вышедших в релиз (нужнго дял вывода номеров выпусков на странице)

			Запись в шаблоне:
				<h4>Выпуск №{{$count - $loop->index}}.</h4> 
				$count - $loop->index -- максимальное число выпусков минус номер индекса выводимого элемента, т.е. $loop->index 1-й иттераци == [0]. 
				Это правило работает если была бы одна страница пагинации, но их множество:
					<h4>Выпуск №{{$count - $loop->index - ($post->currentPage() - 1)*env('USER_COUNT_ON_PAGE')}}.</h4>
						($post->currentPage() - 1)*env('USER_COUNT_ON_PAGE') - запись вычета элементов предыдущей страници. На 2-й странице вычитываются номера 1-й страницы.
						где,
							$post->currentPage() - номер текущей страници. Т.е. $post->currentPage() - 1 - игнорирует первую страницу
							/*env('USER_COUNT_ON_PAGE') - умножение на количества элементов на странице
			
			Так как вывод постов не отличается в текущем и в предыдущем уроках уроме записи с номером выпуска, то создадим для вывода поста отдельный шаблон. 
			Теперь вывод постов на главной странице:
				@foreach ($posts as $post)
					@include('post_intro')
				@endforeach
			На странице редации:
				@foreach ($posts as $post)
						@include('post_intro', ['number' => $count - $loop->index - ($posts->currentPage() - 1)*env('USER_COUNT_ON_PAGE')])
				@endforeach
		*/

	echo '<hr><hr><br><h3>Laravel - #37.1-3 - Вывод страницы "Сайты учеников", Добавление сайта, Добавление reCAPTCHA (День 37)</h3><hr><hr>' . "<br>";
		//!Урок 1: Вывод страницы "Сайты учеников"
		/*
			Вывод сайтов не сложен и потребуется для вывода формы добавления сайтов. 
			Вывод сайтов в контроллере:
				return view('sites', [
					'sites' => Site::where('is_active', 1)->orderByDesc('id')->get()
				]);
		*/

		//!Урок 2: Добавление сайта
		/*
			Создадим вывод формы для добавления сайта. 
			В мершруте будем выводить форму чреез HTTP метод Any:
				Route::any('/sites/add', [App\Http\Controllers\MainController::class, 'addSites'])->name('sites.add');
			Action ведет на страницу с формой: action="{{url()->current()}} или "action="sites/add""
			
			Проверка формы на ошибки и вывод сообщения об успешном добавлении формы:
				@if ($errors->any())
					@foreach ($errors->all() as $message)
						<p class="messsage">{{$message}}</p>
					@endforeach
				@elseif($success_add)
					Изначально $success_add - имеет значнеие false в контроллере, но после добавления становится true.
					<p class="messsage">Сайт успешно добавлен и отправлен на проверку перед размещением</p>
				@endif

			Проверка и создание сайта:
				if ($request->add_site) {
				$validate = $request->validate([
					'address' => 'required|url|unique:sites',
					'description' => 'required|min:10|max:200',
				]);
				$site = new Site();
				$site->address = $validate['address'];
				$site->description = $validate['description'];
				$site->save();

			TODO ЗАМЕТКА: в главном компаненте в пути к JS, IMG и CSS проставить в начале "/", чтобы дать понять, что поиск идет от корня.
				<link type="text/css" rel="stylesheet" href="/styles/fancybox.css" />
				<img src="/images/courses/{{ $course->alias }}.png" alt="{{ $course->title }}" />
			TODO ЗАМЕТКА: Строку ниже убираем - это CSRF токен, выводимый на страницу. Он уже проставлен в виде директивы.  
				{{--<input type="hidden" name="_token" value="i6yi4ysAPfHeWGPglYGnBrbKw9RZFWCk3iPmairH">--}}

			Создаем локаль RU
			В моделе должен быть массив с параметрами по-умолчнаию, котоыре не вводит пользователь:
				protected $attributes = [
					'is_active' => 0
				];
		*/

		//!Урок 3: Добавление reCAPTCHA
		/*
			Форма написана, но если ее оставить так, то на нее скоро будут спамить тысячами сообщений. 
			Поэтому нужна капча - рекапча.
			Для этого в Laravel специальный модуль. 
			Ссылка:
				https://laravel-recaptcha-docs.biscolab.com/docs/intro 
			
			Этапы установки рекапчи в фаорму:
				1) Получнеие ключа рекапчи
					Ссылка: https://www.google.com/recaptcha/admin/create
					а) выбор названия сайта - название рекапчи: local-laravel
					б) выбор типа рекапчи и подтипа
					в) указание домена
					г) принятие условий и отправка рекапчи
					д) копированеи ключа сайта: 6LeGeOgmAAAAAKtCENnTnPrrA6qKOfBcCJ1s6GIp и секретного ключа:6LeGeOgmAAAAABdx2x0qD5nUYD6EB4YtmVt-Ir5l

				2) Установка рекапчи
					а) установка через компосер в дериктории проекта: "composer require biscolab/laravel-recaptcha"
				3) Настройка рекапчи
					а) Создание config/recaptcha.php файл конфигурации, используя следующую команду artisan
						php artisan vendor:publish --provider="Biscolab\ReCaptcha\ReCaptchaServiceProvider"
				4) Добавление API ключей в файл .env (без угловых скобок):
					RECAPTCHA_SITE_KEY=<YOUR_API_SITE_KEY> == ключ сайта: 6LeGeOgmAAAAAKtCENnTnPrrA6qKOfBcCJ1s6GIp
					RECAPTCHA_SECRET_KEY=<YOUR_API_SECRET_KEY> == секретный ключ: 6LeGeOgmAAAAABdx2x0qD5nUYD6EB4YtmVt
					RECAPTCHA_SKIP_IP=<YOUR_IP_LIST> - список IP для которых можно отключить рекапчу...не будем реализовывать
				5) Открываем созданный файл "config\recaptcha.php"
					а) Указываем версию рекапчи
					Все параметры указаны обычно на странице установки библиотеки. Но у нас они установлены по-умолчанию.
				
			Использованеи рекапчи 2-й версии
				1) Вставьте htmlScriptTagJsApi() вспомогательный элемент перед закрытием </head> тега.
					<!DOCTYPE html>
						<html>
						<head>
						...
						{!! htmlScriptTagJsApi($configuration) !!}
						</head>
				2) Вставка в форму
					<form>
						@csrf
						...
						{!! htmlFormSnippet() !!}
							<!-- OR -->
							{!! htmlFormSnippet($attributes) !!} - если понадобится внести аттребуты 
						<input type="submit">
					</form
				3) Верификация
					Ввведенеи строки в проверку валидации: 'g-recaptcha-response' => 'recaptcha'
					$validator = Validator::make(request()->all(), [
						...
						'g-recaptcha-response' => 'recaptcha',
						// OR since v4.0.0
						recaptchaFieldName() => recaptchaRuleName()
					]);
				4) Добавление ошибки "validation.recaptcha" в языковую константу
					'recaptcha' => 'Вы не подтвердили, что вы не робот',

				Теперь рекапча должна работать, но так как у нас локальынй сервер и домен не настроен, то и рекапча не работает, так как в ней не прописан наш домен. 
		*/

	echo '<hr><hr><br><h3>Laravel - #38.1-2 - Вывод страницы с постом, Добавление комментариев (День 38)</h3><hr><hr>' . "<br>";
		//!Урок 1: Вывод страницы с постом
		/*
			Выведем страницу с постом и комментариев. Форму комментариев выведем в след уроке. 
			Укажем дополнительно, что в списке отображаемых постов не должен отображаться читаемый коммент. 
		*/

		//!Урок 2: Добавление комментариев
		/*
			Начнем обработку форму добавления комментариев, а значит поменяем запрос с GET на ANY. Route::any('/post{post} ... });
			Еще в меотд post добавим зависимость Request, так как в методе будет обработка полученных данных. 
			В форме указываем адрес на саму себя. 
			TODO ЗАМЕТКА: так как после ошибке редирект не нужен, то будем выполнять проверку формы через фассад: Validator::make().
			При создании комментария будем заполнять поле "$comment->access_token = '12345';"
			При успешном добавлении комментария нужно выводить шаблон на уровне формы добавления комментария для этого сделаем дополнительный маршрут:
				Route::any('/post{post}#comments', [App\Http\Controllers\MainController::class, 'post'])->name('post.comments');
			Если добавление не прошло успешно, то стоит через проверку воводить шаблон на месте формы с комментариями:
					if ($validator->fails()) return redirect()->route('post.comments', ['posts' => $post])->withErrors($validator->errors())->withInput();
						или
					if ($validator->fails()) return $redirect->withErrors($validator->errors())->withInput();
						где $redirect переменаня с redirect()->route( ... []);
							Запись "->withErrors($validator->errors()" необходима потому, что ошибки передаются в шаблон через метод ->validate();
						Запись "->withInput()" - нужна так как передает функцию old('inputName'), передаваемую методом "->validated()", которого мы не прописали так как  вызвали валидацию через фассад "Validator::". 
		*/

	echo '<hr><hr><br><h3>Laravel - #39.1-2 - Удаление комментариев, Добавление поиска (День 39)</h3><hr><hr>' . "<br>";
		//!Урок 1: Удаление комментариев
		/*
			Реализуем функцию вдаления комментариев не смотря на отсутствие на сайте авторизации. 
			TODO ЗАМЕТКА: пользователь при заходе на сайт получает в свою сессию специальный "access_token", котоырй выполняет функцию ID пользователя. 
			При добавлении комментария токен пользователя впечатывается в строку комментария. Если она совпадает с сессией пользователя - у него есть доступ на удаление.
			Но так как токен находится в сессии, то и возможность удаление сохраняется только при условии хранения токена в сессии - до выхода из браузера. 
			При необходимости возможностьи удаления в любое время - уже нужна авторизация. 

			УСТАНОВКА access_token
				1) При открытии страницы с постом - создается access_token в контроллере
					$this->setAccessToken($request);
				2) Функция созданяи токена:
					public function setAccessToken(Request $request) {
						if ($request->session()->missing('access_token')) {
							$request->session()->put('access_token', Str::random(32));
							где,
								use Illuminate\Support\Str; - хелпер
								missing('access_token') - проверка на отсутствие парамека сессии
						}
					}
					TODO ЗАМЕТКА: Метод missing() - может подсвечиваться как ошибка, но тем не менее он работает. 
				3) Прописать политику доступа к комментариям
					а) Сооздание потики
						php artisan make:policy CommentPolicy --model=Comment
						В политике понадобится только менто delete
					б) Доступ на удаление комментария если содержимое токена комментари и сессии совпадают
						public function delete(?User $user, Comment $comment): bool
						{
							return Session::get('access_token') === $comment->access_token;
						}
						где,
							/?User - не обязательность условия наличия у пользователя авторизации
				4) Вывод кнопки удаления комментария в форме добавления комментария
					@can('delete', $comment)
						<div class="functions"><a href="{{route('comment.delete', ['comment' => $comment])}}" class="replay">Удалить</a></div>
					@endcan
				5) Создание маршрута, ведущего на удаление комментария
					Route::get('/comment{comment}/delete', [App\Http\Controllers\MainController::class, 'deleteComment'])
					->middleware('can:delete,comment')->name('comment.delete');
				6) Удаление комментария
						public function deleteComment(Comment $comment) {
							$post = $comment->post;
							$comment->delete();
							return redirect()->route('post.comments', ['post' => $post]);
						}
					где,
						Comment $comment - удаляемый коммент
						$post = $comment->post; - ссылка для редиректа
						$comment->delete(); - удаление коммента
						return redirect()->route('post.comments', ['post' => $post]); - редирект на страницу с формой комментрирования
					TODO ЗАМЕТКА: без прописи дополнительной проверки в в контроллере или мидлваре/посреднике, проверяющего права удаления коммента - комменты удалять может кто угодно, подставляя в URL нужный Id. 
						Route::get('/comment{comment}/delete', [App\Http\Controllers\MainController::class, 'deleteComment'])
							->middleware('can:delete,comment')->name('comment.delete');
							где,
								can:delete - действие указаноне в политике
								comment - параметр над которым подразумевается действие (передается в политику для проверки). 
						TODO ВАЖНО! В посреднеке не должно быть пробелов между проверкой и передаваемым параметром. 
		*/

		//!Урок 2: Добавление поиска
		/*
			Реализацтя поиска на сайте:
				1) Создание маршрута:
				Route::get('/search', [App\Http\Controllers\MainController::class, 'search'])->name('search');
					TODO ЗАМЕТКА: поисковой запрос отправляется метдом GET, так как это нужно для индексации и продвижения. + это создает ссылку на результат поиска.  
				2) Смена урла в шаблоне:
					В шаблоне с поиском достаточно поставить URL, ведущего на метод поиска. 
						<form name="search" method="get" action="{{route('search')}}">
				3) Создание маршрута:
					Route::get('/search', [App\Http\Controllers\MainController::class, 'search'])->name('search');
				4) Проверка запроса на валидность:
					$validated = $request->validate([
						'search_query' => 'required|string|min:3|max:200'
					]);
				5) Составление выборки подходящих под запрос постов:
					$search_query = $validated['search_query'];
					$post = Post::where('title', 'LIKE', "%$search_query%")
					->orWhere('intro_text', 'LIKE', "%$search_query%")
					->orWhere('full_text', 'LIKE', "%$search_query%")
					->paginate(env('USER_COUNT_ON_PAGE'));
				6) Передача в шаблон запроса и выборки запроса:
					return view('search', ['search_query' => $search_query, 'post' => $post]);
				7) Создаем шаблон для вывода искомых постов и скопиурем в него код вывода постов из шаблона index:
					@if (!count($posts))
						<div id="other">
							<h1>Результаты поиска: {{$search_query}}</h1>
							<div id="pm">
								<p>Ничего не найдено!</p>
								<p><a href="{{route('index')}}">Вернуться на главную</a></p>
							</div>
						</div>
					@endif
					@foreach ($posts as $post)
						@include('post_intro')
					@endforeach
					{{$posts->links('pagination')}}
				TODO ЗАМЕТКА: по всем словам в искомых полях таблицы чрезе цикл foreach - для этого слова разбиваются через пробел в массив и уже в нем происходит поиск на соответствие запросу. Но обойдемся простйо версией поиска.

		*/

	echo '<hr><hr><br><h3>Laravel - #40.1-3 - Создание ЧПУ-ссылок, Вывод страницы 404, Подведение итогов (День 40)</h3><hr><hr>' . "<br>";
		//!Урок 1: Создание ЧПУ-ссылок
		/*
			На данный в адресной строке выводятся ссылки, понятные для сервера. Однако, это не ЧПУ-ссылки (человеко-понятные).
			+ для индекцсации страниц ужно, чтобы она была ЧПУ.
			В целом сайт уже имее ЧПУ ссылки, но кроме постов, котоыре отображаются в виде цифры в конце URL'a:
				.../post/15
			Своей системы реализации ЧПУ ссылок в Laravel нет, однако, можно осздать и свою. 

			Создание функционала оформления ЧПУ ссылки:
				1) Параметр post в URL'е-маршруте заменим на алиас:
					Route::any('/post/{post}',...); => Route::any('/post/{alias}',...);
				2) Замена ссылок на посты:
					Было:
						<a href="{{route('post', ['post' => $post])}}">ЧИТАТЬ ПОЛНОСТЬЮ &gt;</a>
					Стало:
						<a href="{{route('post', ['alias' => $post->alias])}}">ЧИТАТЬ ПОЛНОСТЬЮ &gt;</a>
				3) Замена аргумента в методе вывода постов и присваивание:
					Было: 
						public function post(Post $post, Request $request) {
					Стало:
						public function post($alias, Request $request) {
							$post = Post::where('alias', $alias)->first();
				4) Проверка аргумента $alias на причастность к модели/таблице post:
					Без нее будет выдаваться ошибка, но не 404. 					
					Было: 
						public function post(Post $post, Request $request) {
					Стало:
						if (!$post) abort(404);
				5) Замена ссылок в контроллере:
					Было:
						$redirect = redirect()->route('post.comments', ['alias' => $post]);
					Стало:
						return redirect()->route('post.comments', ['alisas' => $post->alias]);

				Этого вполне достаточно. Но елси нужно добавить суффикс HTML, то он добавляется в URL в маршруте. 
		*/

		//!Урок 2: Вывод страницы 404
		/*
			Создадим страницу 404. 
			Эта система работает уже. Однако, не всех может устроть этот шаблон. 
			
			Создание шаблонов с ошибками:
				1) Сооздание папки с шаблонами ошибок errors
				2) Создание файла 404.blade.php
				3) Переносим в шаблон компанент страницы. 
				4) Добавим оповещение об отсутствии страници с кнопкой на главную страницу. 
					<div id="other">
					<h1>Страница не найдена</h1>
					<div id="pm">
						<p>К сожалению, запрошенная страница не существует</br>Проверьте правильность ввода адреса.</p>
						<p><a href="{{route('index')}}">Вернуться на главную</a></p>
					</div>
				</div>
		*/

		//!Урок 3: Подведение итогов
		/*
			На созданном сайте имеются вывод страниц, пагинация, валидация, поиск, формы, рекапчи. 
			Если писать подобный проект с нуля на нативном языке - это не на долго.
			С фреймворком же набедакурить сложнее - в нем уже выстроны процессы создания и пользования функционала сайта. 
			Для дальнейшего продвижения и обучения нужно создавать проекты обращаясь к документации, вспоминая пройденные уроки. 
		*/


