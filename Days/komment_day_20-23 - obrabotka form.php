
	<?php

use function Termwind\style;

	echo '<hr><hr><br><h2>Модуль №20.20-23:  Обработка форм</h2>' . "<br>";
	echo '<hr><hr><br><h3>Laravel - #20.1-2 - Вывод форм, Валидация (День 20)</h3><hr><hr>' . "<br>";
		//!Урок 1: Вывод форм
		/*
			Создадим форму в этом уроке и рассмотрим процесс передачи данных из нее контроллеру. 
			Проверку переданых данных рассмотрим в следующем уроке. 
			Создадим контроллер: php artisan make:controller FormController
			И его маршрутизацию: Route::get('/testform', [App\Http\Controllers\FormController::class, 'testForm']);
			И маршрутизацию обработчика формы: Route::post('/testform/send', [App\Http\Controllers\FormController::class, 'send']);
			
			В процедуре создания формы нет ничего особенного. Laravel может предоставлять некоторые инструменты для работы с формой. 

			HTTP метод в форме можно укзать чрез директиву: @method('POST').

			CSRF ТОКЕН
			TODO ВАЖНО! В формы laravel нужно добавлять "@csrf" токен. Он нужен для безопастности. 
				Токен нужен, чтобы через форму методом POST не проходили несанкционированные запросы на сайт - без токена они работать не будут. 
				Перед выполнением запрос проходит через группу мидлваров "web". В ней есть мидлвар VerifyCsrfToken, которые проверяет наличие токена. Там токен и нужен. 

				Добавим в таблицу @csrf токен - он является проверочным ключом к запросу, поступающим через таблицу. 
				Запрос проходит в мидлвар "laravel\app\Http\Middleware\VerifyCsrfToken.php". В этот мидлвар можно вписать ссылки, которые/API, котоыре можно обрабатывать без наличия @csrf токена. 

		*/

		//!Урок 2: Валидация
		/*
				Принятые данные следует проверять прежде чем обрабатывать. 
				
				МЕТОДЫ ВАЛИДАЦИИ, ВЫВОДА ОШИБОК, СОХРАНЕНИЯ ЗНАЧЕНИЙ ПОЛЕЙ
				validate() - метод проверки данных из формы. Аргументом выступает массив с проверяемыми параметрами формы. Метод относится к объекту $request.
					Пример использования метода валидации:
						$validated = $request->validate([
							'name' => 'required|min:2|max:20',
							'text' => 'required|max:100',
							'bd' => 'nullable|data',
						]);
						где,
							request - объект со значениями из формы
							validate - метод валидации значений
							name/text/bd - проверяемые поля
							после знака => идут словия проверки полей
							$validated - массив с проверенными данными
						TODO ЗАМЕТКА: если валидация формы не пройдет, то метод validate() сделает редирект на страницу с формой, передавая в сессию причину ошибки валидации.
						TODO ЗАМЕТКА: код в контроллере после валидации начнет выполняться только после успешного её прохождения.
						TODO ЗАМЕТКА: метод validate() вызывает мнгновенный редирект на страницу с формой. Однако, может случиться ситуация, когда редирект не нужен. Для этого используется фассад "Validator", который не подразумевает редиректа - его можно настроить через условие после валидации.
							Пример:
								$validator = Validator::make($request->all(), [
									'image' => 'required|file|max:1024|mimes:jpg,png,gif'
								]);
				old() - функция Laravel, которая прописывается в шаблоне для сохранения значения поле после перезапуска страницы. Аргумент - название поля.
					TODO ЗАМЕТКА: Чтобы значение полей не сбрасывались при ошибках - в каждом поле в атребуте "value" вставим метод "old()" с атребутом поля.
					Пример: 
						value="{{ old('name') }}"

				1-й способ вывода (частных) ошибок валидации
				error() - директива вывода ошибки валидации у указанного поля. Аргумнет - поле формы. Тело директивы - сообщение, выводимое при провали валидации поля.
					TODO ЗАМЕТКА: Нижже каждого поля прописывается дерективу @error(''), аргументом которой является имя проверяемого поля. Деректива отобразит ошибку, ес	
					Пример: 
						@error('email')
							<p class="test-red-500">{{ $message }}</p>
						@enderror

				2-й способ вывода (всех) ошибок валидации
				Пример:
					@if ($errors->any())
						<h3>Ошибки при заполнении формы:</h3>
						<div>
							@foreach ($errors->all() as $message)
								<p>{{$message}}</p>
							@endforeach
						</div>
					@endif
					где,
						$errors->any() - проверка на наличие ошибок
						$errors->all() - массив с сообщениями всех ошибок

				Локализация ошибок
					По-умолчанию ошибки выводятся на английском. За это отвечает файл "lang\en\validation.php"
					Файл представляет из седя набор свойств (ошибок) и значений - локализаций/переводом. 
						Пример: 'email' => 'The :attribute must be a valid email address.',
					TODO ЗАМЕТКА: Для создания русской локализации ошибок достаточно создать клонировать папку "en", переименовать ее на "ru" и перевести все ошибки. 
					
					Для переименования полей в локализации ошибок - достаточно в объекте "attributes" создать запись: 
						ключ + значения, где ключ - старое назание, значение - новое название.
						Пример:	
							'attributes' => [
								'name' => 'имя',
							],

					Для переименования правила проверки в локализации для определенного поля - достаточно в объекте "custom" создать объект с названием проверяемого поля и создать в ней запись: 
						ключ + значения, где ключ + правило проверки, а ключ - старое назание, значение - сообщение, отображаемое в случаи не выполнения правила.
							Пример:	
								'custom' => [
									'name' => [ 
											'required' => 'Это очень важное поле, заполните его!'
									]
								],
					

		*/

	echo '<hr><hr><br><h3>Laravel - #21.1-2 - Класс запроса формы, Создание собственного правила валидации (День 21)</h3><hr><hr>' . "<br>";
		//!Урок 1: Класс запроса формы
		/*
			FormRequest (FR) - тип класса, проводящий валидацию формы.
			ВАЖНО! Для каждой создаваемой формы желательно создавать класс типа Form requests, чтобы ему делегировалась часть функционала с контроллера, связанный с валидацией, дополнения данных запросов, и.т. 
							
			В прошлом уроке данные из формы передавались в виде объекта класса Request.
			В текущем уроке данные из формы в виде объекта Request будет обрабатоваться классом Form requests. Это считается более правильным способом. 

			Команда создания класса проверки формы:
				php artisan make:request TestForm
					где,
						request - атребут, указывающий на проверку данных из формы
						CommentForm - название создаваемого класса
					Место созданного класса: "app\Http\Requests\TestForm.php"

				ПОДКЛЮЧЕНИЕ FR К ФОРМЕ
					1) Создаем маршрут:
						Route::post('/testform/sendbyrequest', [App\Http\Controllers\FormController::class, 'sendByRequest']);
						где,
							/testform/sendbyrequest - URL, указанынй в action формы

					2) Создаем метод в контроллере, передающий данные формы в FR:
						public function sendByRequest(TestForm $request){
							$validate = $request->validate();
							print_r($validate);
							return 'Форма проверена';
						}
						где,
							sendByRequest - функция, указанная в маршруте
							TestForm - класс - FR, в который передаются даныне из формы
							$request - объект с данными из формы
							$validate - массив с проверенными данными из формы

				СПОСОБЫ ИЗВЧЛЕЧЕНИЯ ДАННЫХ 
					Даныне формы извлекаются двумя методами:
						1) ->validate - меотд, обрамляющий провреенные даныне формы в массив.
							Пример:
								echo $validate['name'];
						2) ->safe - метод, обрамляющий провреенные даныне формы в объект. 
							Пример:
								echo $validate->name;
							В случаи провала валидации меотд safe() так же возвратщает обратно на страницу с формой. 

				МЕТОДЫ класса FR:
					1) authorize()	- проверка авторизации пользователя и докуск до формы только авторизованных, конкретных пользователей. Возвратщает булево значнеие.     
					Пример:
						public function authorize(): bool
						{
							return true;
						}
					2) rules()			- метод с массивом правил валидации формы, как в методе "validate()". Валидация проходит еще в момент инъекции в метод контроллера. 
					Пример:
						public function rules(): array
						{
							return [
								'name' => 'required|min:2|max:20',
								'text' => 'required|max:100',
								'text' => ['required', 'max:100'],
								'bd' => 'nullable|date',
							];
						}
						TODO ЗАМЕТКА: правила валидации можно прописывать как в строке => 'bd' => 'nullable|date',, так и в массиве => 'text' => ['required', 'max:100'].

					prepareForValidation	- выполняетя перед передачей запроса на проверку валидации. 
						Это нужно, чтобы при добавлении в запрос ID авторизоаванного пользователя, не пришлось делать через скрытое поле в форме. 
				

					ОПЦИОНАЛЬНЫЕ ПОЛЯ КЛАССА ПРОВЕРКИ ФОРМЫ	
						Настройка редиректа валидации
							TODO ЗАМЕТКА: метод validate() автоматом редиректил пользователя на форму после ее проверки. В классе FormRequest редирект настраиваемый на любой URL. За это товечает поле "redirect". Если же в маршрутах используются имена, то для них используется свойство "redirectRoute".
							1) За правило редиректа в классе отвевает поле "redirect".
								Пример: 
									protected $redirect = '/';
							2) За правило редиректа в классе отвевает поле "redirectRoute".
								Пример: 
								protected $redirectRoute = 'nameRoute';

						Параметр остановки валидации при первой ошибке
							3) protected $stopOnFirstFailure = true;


					ОПЦИОНАЛЬНЫЕ ФУНКЦИИ КЛАССА ПРОВЕРКИ ФОРМЫ	
						1) messages() - функция возвратщающая массив с переопределенными сообщениями об ошибках заполенния привязанной формы. 
							Пример:
								public function messages()
								{
									return [
										'name.required' => 'Поле :attribute обязательно для заполнения!',
										'name.min' => 'Такого имени не может существовать',
									];
								}
								где,
									name - название проверяемого поля
									min - параметр проверки поля
									:attribute - ссылка на название поля
							TODO ЗАМЕТКА: сообщения валидации прописываются и в файле локализации, но сообщения в методе привязаны конкретно к ошибкам определенной формы. Сообщения об ошибках, прописанные в методе имеют приоритет перед сообщениями в файле локализации (объект "custom") в случаи совпадения имен полей и параметров проверки. Это может пригодиться, когда поля разных форм часто совпадают, но различаются по сожержанию.
								
						2) attributes() - функция возвратщающая массив с переименованными полями формы, помещенными в сообщение об ошибке.
							Пример:
								public function attributes()
								{
									return [
										'name' => 'имя',
										'bd' => 'дата рождения',
									];
								}	
		*/

		//!Урок 2: Создание собственного правила валидации
		/*
			В Laravel уже имеется множество правил валидации, в нем есть возможность создавать свои правила.
			Используется это редко, но это есть. а 
			Команда создания файла с кастомными правилами валидации:
				php artisan make:rule MyRule
			Место хранения самодельных правил валидации: 
				"app\Rules\MyRule.php".

			TODO ВАЖНО! Данный урок актуален только для Laravel 8-й версии, так как указанные в уроке методы класса находятся только в ней. Так что урок на практике не пройден в виду наличия только 10-й версии фреймворка. 
			
			Методы класса с самодельными правилами валидации:
				1) passes() - проверяет полученное значение от формы на соответствие.
				2) message() - возвратщает сообщение об ошибке в случаи провала валидации.
					public function message(){
						return 'Это значение должно ровняться';
					}
					
			Чтобы прописанное правило в классе rule заработало - его нужно подключить к FormRequest классу, который вмещает в себя правила проверки полей формы. 
				Пример:	
					'test' => [new MyRule, required];
					где,
						test - название проверяемого поля
						new MyRule - класс с самописными правилами валидации
				TODO ВАЖНО! Самописные правила прилагаются к проверяемому полю, только если правила перечисляются в массиве.
			
			Вынесение самописных правил валидации в файл локализации
				1) Сначала нужно прописать новый параметр и текст ошибки в нужной локализации
				Пример:
					'myrule' => 'Значение поля :attribute не прошло проверку'
				2) Затем подключить этот параметр в файл самописной валидации "MyRule".
				Пример:
					return trans('validation.myrule');
		*/

	echo '<hr><hr><br><h3>Laravel - #22.1-1 - Взаимодействие с моделями через формы (День 22)</h3><hr><hr>' . "<br>";
		//!Урок 1: Взаимодействие с моделями через формы
		/*
			Это урок применения на практики знаний работы с валидацией формы. 
			Доработаем контроллер "AddressController" обработки данных формы, прописав функционал добавления создание и т.д. данных формы. 
			Формы на изменение и добалвение будут иметь минимальные различия. Каждая из форм будет вести на свой метод контроллера со своим отдельным валидатором. 
			После создания формы (она будет заплняться в зависимости от вызввавшего ее метода) создадим два валидатора. 
				TODO ЗАМЕТКА: два валидатора могет понадобиться, если к одному и тому же полю могут потребоваться разные правила проверки формы. 
				TODO ЗАМЕТКА: правило "unique:" - это важное правило валидации, допускающее значения поля таблицы до записи в БД, только если оно отсутстввуте в указанно таблице. Т.е. уникально. + Если бы название поля формы и таблицы различались бы, то правило "unique:" имело бы второй аргумент (через ","), с названием поля в таблице, в котором значение поля формы не должно повторяться. 
					Прмиер:	
						'address' => 'required|min:10|max:255|unique:addresses',
						где,
							address - поле формы
							unique - правило валидации
							:addresses - таблица, проверяемая на наличие значения из формы
							
			В контроллере пропишем вызов валидации:
			Создание адресов:
				public function store(StoreAddressRequest $request)
				{
					$validated = $request->safe(); преобразование validated в объект с полями из формы
					$address = new Address(); вызов объекта класса для вызова поля таблицы
					$address->address = $validated->address; помещение в поле таблицы проверенное поле формы
					$address->save(); сохранение результата
					return redirect()->route('addresses.index'); редирект
				}
			
			Редактирование адресов:
				public function update(UpdateAddressRequest $request, Address $address)
				{
					$validated = $request->safe();
					$address->address = $validated->address;
					$address->save();
					return redirect()->route('addresses.index');
				}

				TODO ЗАМЕТКА: так как было создано два отдельынй класса проверки формы для добавления значений и редактирования, то это позволило создать разные правила для каждой отдельной формы. Если бы при редактировании формы оставалось правило "unique:addresses", то это было бы ошибкой, если содержимое не поменяло бы, то пользователь не мог бы сохранить старое значение поля. 

			Удаление адресов
				Удаление производится через отправку HTTP метдоа "delete". Т.е. для этого понадобится отдельная форма с кнопкой. 
					public function destroy(Address $address)
					{
						$address->delete();
						return redirect()->route('addresses.index');
					}
					TODO ЗАМЕТКА: метод delete() подразумевает в себе метод save(), поэтому после удаления - результат сохраняется.
		*/

	echo '<hr><hr><br><h3>Laravel - #23.1-1 - Взаимодействие с файлами и их загрузка (День 23)</h3><hr><hr>' . "<br>";
		//!Урок 1: Взаимодействие с файлами и их загрузка
		/*
			В ходе урока разберемся как передавать файлы через форму и обрабатывать их.

			РАБОТА ФАЙЛОВОЙ СИСТЕМЫ 
				Настройкаи работы файловой системы Laravel находятся в файле "config\filesystems.php". 
				Настройки конфига файловой системы:
					1) 'default' => env('FILESYSTEM_DISK', 'local'),
						default - использует диск файловой системы, который используется по-умолчанию.
					2) "disks" - диски, используемые в laravel: "local", "public", "s3". 
						TODO ЗАМЕТКА: "disks" - способ хранения файлов. 
						2.1) local 
							2.1.1) driver - драйвер, указывающий место хранения файлов (локальный сервер или публичный).
							2.1.2) root - адрес хранения файлов
						2.2) public 
							2.2.1) url - ссылка на папку с файлами
							2.2.2) visibility - доствпно для открытия любому пользователю 
						2.3) s3 
							2.3.1) - 'driver' => 's3' - Amazon'овский вариант хранения файлов. + в том, что размер хранения такого способа неограничен, но это платно. 
					
					3) links' - символическая ссылка
						3.1) - public_path('avatars') - фейлокая ссылка, доступная пользователю, ведущая к файлам
						3.2) - storage_path('app/public/avatars') - действительная ссылка
					Это ссылки, которые доступны пользователю, однако, ведущие к другой папке с файлами. 
						TODO ЗАМЕТКА: Файлы, передаваемые через форму помещаюстя в папку "strage". Полизователю доступна только папка "public". Символичные ссылки перенаправляют на папку "storage". Можно создавать множество символичных ссылок. 
						TODO ВАЖНО!: по-умолчанию символические ссылки недоступны - посли их объявления их нужно подключить чреез комнаду: "php artisan storage:link".

			ФАССАД STARAGE::
				Для работы с файловым хранилищем нам понадибится фассад "Storage::". 
				Создадим новый маршрут. Через который будем обращатсья к нему.
				
				Методы фассада Starage
					1) put() - метод добавления файла. 1-й аругмент: название закачиваемого файла, 2-й аргумент: содержание файала.
						Пример:
							Storage::put('1.txt', 'Text...'); 
								ИЛИ
							Storage::disk('local')->put('1.txt', 'Text...'); без указания диска метод по-умолчанию подключает локальный диск
					TODO ЗАМЕТКА:	Файл появится в папке "storage\app\1.txt", так как она прописана в диске по-умолчанию, а символическая ссылка не перекрывает этот адрес.
					2) disk() - метод, указывающий на диск дбавления файла. Аргументом выствпает название диска. Скачиваемый файл можно поместить на множество дисков. 
						Пример:
							Storage::disk('public')->put('1.txt', 'Text...');
							Storage::disk('local')->put('1.txt', 'Text...');
					3) prepend() - метод добвляет в начало файла сожержимое 2-го аргумента. 1-й аргумент это название файла, с которым взаимодействует метод.
						Пример:
							Storage::disk('local')->prepend('1.txt', 'Begin');
					4) append() - метод добвляет в конец файла сожержимое 2-го аргумента. 1-й аргумент это название файла, с которым взаимодействует метод.
						Пример:
								Storage::disk('local')->append('1.txt', 'End');
								TODO ЗАМЕТКА: добавление в файл происходит без необходимости указывать перенос строки. Он вшит в метод.
					5) delete() - метод удаления файла. Может применяться без опасения ошибки, и в случаи отсутствия удаляемого файла. Аргумент: название удаляемого файла.
						Пример:
							Storage::disk('local')->delete('2.txt');
					6) copy() - метод копирования файла. 1-й аругмнет: название копируемого файла, 2-й аргумент: название скопированного файла.
						Пример:
							Storage::disk('local')->copy('1.txt', '2.txt');
					7) get() - метод чтения файла. Аргументом является название файла.  
						Пример:
							echo Storage::disk('local')->get('1.txt');
					8) url() - метод отображения URL файла. Аругментом выступает названеи файла. 
						Пример:
							echo Storage::url('1.txt').'<br>';
						TODO ЗАМЕТКА: ссылка имеет вид в зависимости от диска с которым она создавалась. Локальная - внутренний путь. Публичкая - публичная ссылка.
						Пример:
							Публичная ссылка на картинку: Storage::disk('public')->url($path)	=> http://localhost/storage/images/4vCA0Yk1tsq643IfWpCGlwrClUoM3kZ47po7GPu1.jpg 
							Локальная ссылка на картинку: Storage::url($path)	=> /storage/images/4vCA0Yk1tsq643IfWpCGlwrClUoM3kZ47po7GPu1.jpg
					
					9) putFile() - метод сохранения файла из формы в дерикторию.
						Пример:
							$path = Storage::disk('public')->putFile('images', $request->file('image'));
							где,
								public - драйвер
								images - директория, в которую сохраняется файл
								$request->file('image') - поле формы, которое вмещает сохраняемый файл
						TODO ЗАМЕТКА: данная заметка возвратщает путь до файла. 

						TODO ВАЖНО!  Файл доступен для пользователя и доступен в адрессной строке только через добавление с помощью диска "public" => disk('public'). 
						Если добавить 

					10) putFileAs() - метод сохранения файла из формы в дерикторию с возможностью задавать имя файлу.
						Пример:
							$path = Storage::disk('public')->putFileAs('images', $request->file('image'), 'fileName.png');
								TODO ЗАМЕТКА: данный метод сохранения используется, когда имя все же имеет генерируемую часть названия. Иначе оно перетерается.  

			ФОРМА ПЕРЕДАЧИ ФАЙЛА 
				В аттребуте "action" впишем => {{url()->current()}} - эта запись означает, что форма будет ссылаться на саму себя. 
					Хотя отсутствие адеса онзаначет тоже самое.
				В аттребуте "enctype" впишем => "multipart/form-data". 

				TODO ЗАМЕТКА: Laravel отслеживает даже замаскированные типы данных. Такеи как скрипты, замаскированные под картинки. 
				Методы работы с файлом из формы:				
					1) file() - метод указывает метод, с которым будут работать другие методы. Аргументом выступает название файла. 
						Прирмер:
							
					2) getClientOriginalName() - имя орегинального файла
						Прирмер:
							echo $request->file('image')->getClientOriginalName().'<br>';
					3) >getClientOriginalExtension() - вывод расширения файла
						Прирмер:
							echo $request->file('image')->getClientOriginalExtension().'<br>';
					4) extension() - расширение, определенное Laravel'ем (действительное)
						Прирмер:
							echo $request->file('image')->extension().'<br>';
					5) getSize() - вывод размера файла
						Прирмер:
							echo $request->file('image')->getSize().'<br>';
					6) getMimeType() - вывод типа файла
						Прирмер:
							echo $request->file('image')->getMimeType().'<br>';
					7) getHash() - вывод типа файла
						Прирмер:
							echo $request->file('image')->getHash().'<br>';

					После валидации файла сохраним его:
						$path = Storage::putFile('images', $request->file('image'));
		
				Пример кода добавления из другого курса:
						if ($request->hasFile('main_image')) {
							$file = $request->file('main_image')->getClientOriginalName();
							$image_name_without_ext = pathinfo($file, PATHINFO_FILENAME);
							$ext = $request->file('main_image')->getClientOriginalExtension();
							$image_name = $image_name_without_ext."_".time().".".$ext;
							$request->file('main_image')->storeAs('public/img/articles', $image_name);
						}else{
							$image_name = 'noimage.jpg';
						}
					где,
						$request	- даныне получаемые пользователем
						hasFile	- метод проверки поля на наличие файла
						file('')	- метод принимающий из переменной $request (смотреть выше) файл. В методе указывается поле формы из которой принимается файл.
						getClientOriginalName	- метод отображения полного имени файла
						$image_name_without_ext	- переменная, хранящая в себе название изображения
						pathinfo	- метод, получающий путь к файлу, обрезая формат файла
						($file, PATHINFO_FILENAME) - $file - название файла, PATHINFO_FILENAME - условие обрезания названия файла (все кроме имени файла).
						$ext		- переменная, хранящая в себе формат изображения
						getClientOriginalExtension	- метод обрезающий название файла до формата формата. 
						$image_name	- переменная хранящая в себе измененное-уникальное название файла форматом
						$request->file('main_image')->storeAs('public/img/articles', $image_name); - строка сохранения/загрузки файла
						storeAs	- метод загрузки файла 
						public/img/articles				- путь загрузки файла
						$image_name							- имя файла, под которым он загружается на сервер
						$image_name = 'noimage.jpg';	- в случаи если фото не прикреплено, прикрепляется картинка по-умолчанию. Оно будет добавлено позже. 
				*/

		