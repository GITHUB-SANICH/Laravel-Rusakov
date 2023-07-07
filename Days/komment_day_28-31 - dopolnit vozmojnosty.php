
	<?php

use function Termwind\style;

	echo '<hr><hr><br><h2>Модуль №28.28-31: Дополнительные возможности</h2>' . "<br>";
	echo '<hr><hr><br><h3>Laravel - #28.1 - Отправка e-mail (День 28)</h3><hr><hr>' . "<br>";
		//!Урок 1: Отправка e-mail
		/*
			Продолжим работу в первом проекте, так как второй ориентирован на работу только с авторизацией. 
			В рамках нового модуля кодовая база не сильно выростит, однако, об этих разделах нужно знать. 

			Для разбора работы отправки почты ознакомимся с настройками: "\config\mail.php". 

			Способы отправки почтлвых сообщений (mailers):
				1) smtp		- использование SMTP сервере. Подходит при ограниченой отправки почты => т.к. скорость == ~ 1 сообщение/1 сек.
				2) ses		- amazon'овский метод. Оптимальный вариант за свою цену, при массовой отправки писем.
				3) mailgun	- не извезстный способ. Но цена вроде как гораздо больше чем у "ses".
				4) postmark	- не извезстный способ.
				5) sendmail	- способ, подазумевает отправку писем с своего сервера. Самый сложный, рискованный способ - так как требует настройки, но бесплатный и быстырй.
					TODO ЗАМЕТКА: настройка почтового сервера это сложная тема, достойная отдельного курса. При качественной настройке сервера метод "sendmail" примерно равен методу "ses". И то не во всех аспектах. Например некотрые почтовые клиенты не принимают почту от неправильно настроенного сервера даже в спам. 
				6) log		- вариант, подходящий для настройки и отладки функционала отправки почтовых сообщений.
				7) array		- способ, помещающий письма в массив вместо отправки. Подходит для дальнейшей обработки сообщения. Используется обычно после отправки письма. 
				8) failover	- список из ескольких способов отправки, выстроенный в порядке приоритетов, если прыдыдущий вариант не отправил сообщение. 

			От кого письмо (from):
				address - адрес отправителя (происывается в .env файле => "MAIL_FROM_ADDRESS").
				name - имя отправителя (происывается в .env файле => "MAIL_FROM_NAME" - по-умолчанию подтавляется название сайте => "${APP_NAME}").
				
			Создание шаблонов для писем:
				1) markdown - рамзетка создания шаблонов писем, из компанентов своих или гоотовых. 
				2) самописные шаблоны. 

			Для настройки отправки писем в с определенным шаблоном пропишем контроллекр, предварительно в файле .env, прописав оправку писем в log => MAIL_MAILER=log.

			СОЗДАНЕ ПИСЬМА
				Прежде чем отправить писмьмо - его нужно создать, и из контроллера вызвать фассад отправки писмьа. 
				Создадим класс для для отправки email уведомлений
					php artisan make:mail Hello
						Класс хранится по адресу: "app\Mail\Hello.php".	
					
					TODO ЗАМЕТКА: в 10-й версии Laravel метод "build()" отсутствует. Сейчас в 10-ке метды: envelope, content, attachments.
					По умолчанию в классе имеется два метода, где __construct - класс принимает данные, помещаемые в сообщение, а content - передача параметров email уведомлений.
						public function __construct(){
							$this->name = $name;
						}
					Например сюда могут помещаться имя зерегистрированного пользователя, которые передастся в шаблон письма.  

				Данные полученные классом передаются в шаблон заполнения данных "laravel\resources\views\emails\contact_form.blade.php". 
					Этот шаблон будет отправляться в виде письма - в нем находятся даныне из формы. 
					public function build(){
						Методы испольующиеся в методе "build()";
						$this->from('manager@example.com', 'Менеджер') - заменяет дефолтное занчение в файле .env
								->subject('Тема письма')
								->view('emails.messsage') - шаблон с разметкой HTML и текстом 
								->text('emails.hello_text') - письмо в виде текста (нужно для лучшей передачи письма, на случай не поддерживаемости HTML клиентом)
								->with(['a' => 10]); - дополнитльные передаваемые даныне
								Ппередача дополнительных заголовков в сообщение:
								$this->withSwiftMessage(function($message){
									$message->getHeaders()->addTextHeader(
										'My-Header', '123' 
									);
								});
						return $this; - возврат сообщения   
					} 
					withSwiftMessage()	- метод объявления заголовков
					$message	- собщение
					getHeaders()	- получение у сообщения заголовков
					addTextHeader()	- присвоение сообзению новых заголовков
					'My-Header', '123' - заголовк, значение

					TODO ПЕРЕДАЧА ПИСЬМА В НОВОЙ ВЕРСИИ:
						Тема письма и отправитель:
							use Illuminate\Mail\Mailables\Address;
							public function envelope(): Envelope
							{
								return new Envelope(
									
										from: new Address('admin@example.com', 'Менеджер'),
										subject: 'Тема письма',
								);
							}
						Подключение шаблона почты + передача текста + передача параметра:
							public function content(): Content
							{
								return new Content(
									view: 'emails.hello',
									text: 'emails.hello_text',
									with: [
										'a' => 10
									],
								);
							}
						Передача атберутов в письмо:
							public function attachments(): array
							{
								return ['a' => 10];
							}
						Подключене заголовков в письмао (не реализовано):
							public function headers(): Headers
								{
									return new Headers(
										messageId: 'custom-message-id@example.com',
										references: ['previous-message@example.com'],
										text: [
												'X-Custom-Header' => 'Custom Value',
										],
									);
								}
							
						
					TODO ВАЖНО! присвоение новых заголовков работало до 8-й версии Laravel. После используется метод "$this->withSymfonyMessage();", а не withSwiftMessage().
						Пример:
							$this->withSwiftMessage(function(Email $message){
								$message->getHeaders()->addTextHeader(
									'My-Header', '123' 
								);
							});

					TODO ЗАМЕТКА: дополнительные заголовки требуются при массовых рассылках (Precedence: bulk). Или некоторые почтовые сервисы присваивают заголовки сами.
					Еще заголовки являются средством сбора информации о прочитанных, открытых сообщениях. 

				Создаем шаблоны для письма:
					views\emails\hello.blade.php, views\emails\hello_text.blade.php: 
					Прмиер наполнения шаблонов:
						<div>
							<p>Здравствуйте, {{$name}}!</p>
							<p>Я рад вас приветствовать!</p>
							<p>Переменная a = {{ $a }}/</p>
						</div>
						Здравствуйте, {{$name}}!
						Я рад вас приветствовать!
						Переменная a = {{ $a }}

				ОТПРАВКА ПИСЬМА
					Когда шаблоны написаны и заполнены - через контроллер (метод 'testMail') обращаемся к фассаду "Mail::" для отправки письма. 
						public function testMail(){
							Mail::to('koliya@example.com')->send(new Hello('Николай'));
							return 'Проверка работы отправки письма';
						}
						где,
							to() - метод с почтой получателя
							send() - метод с аргументом - классом, в конструктор которого передается имя. 

				ОТПРАВКА ПАКЕТА ПИСЕМ 
					Отправка писем, обоченно черзе SMTP сервер - дело не быстрое.
					Для отправки группы писем в фассадe Mail лучше испольовать метод "qeue()".  
						Пример:
							Mail::to('koliya@example.com')->qeue(new Hello('Николай'));

						qeue() - метод, помещающий письма в очередь отправки. 

				ОЧЕРЕДИ
					Очереди - это функционал laravel, позволяющий невелировать время ожидания каких либо событий пользователем, помещая их выполнение в фоновый режим. 
					Они применяются буть то либо в отправке сообщений, либо в загрузки группы файлов пользователем.
					TODO ВАЖНО! Почта может отправляться некоторое время, поэтому при отправки почты лучше использовать "очереди" черзе запуск Cron скрипта, чтобы отправка письма прошла тогда, когда настала бы очередь отправки. Этот скипт выполняет запуск задач, помещенных в очереди => "php artisan qeue:work".

					TODO ЗАМЕТКА: функционал очередей в уроке не будет рассказан подробно и н будет реализован... напишу о очередях ниже. 
					ИНФОРМАЦИЯ ИЗ ДРУГОГО КУРСА
						1. Настройка очередей и типы очередей 
							Файл с конфигурацией очередей находится в "config\queue.php".
							В файле есть несколько типов очередей:
							sync, database, beanstalkd, sqs, redis.
								Рассмотрим только два типа:
									sync		- тип очереди выбранный по умолчанию. Задача в очереди начинает выполняться мгновенно, не влияя на скорость выполнения задачи. 
									database	- тип очереди, записывающий задачу в таблицу БД "jobs" - его и будем использовать. 
										Задачи записанные в таблицу начинают выполняться через воркер, т.е. задача записанная в очередь не начинает выполняться мгновенно, а по команде в фоновом режиме. 
						
						2. Создание таблицы, класса для записи очередей
							Для работы с очередями типа "database" - понадобиться создать таблицу "jobs" через миграцию, так  таблицы по умолчанию нет. 
								Команда создания миграции с таблицой:
									php artisan queue:table
								Команда выполнения миграции:
									php artisan migrate
								Команда создания класса, в который записываютяс задачи, кладущиеся в очередь:
									php artisan make:job ForgonUserEmailJob
										job - тип класса, записывающий задачу в очередь 
										ForgonUserEmailJob - название класса
											Появляется класс в папке "laravel\app\Jobs\ForgonUserEmailJob.php"
						
						3. Функционал класса записи очереди
							Функция "__construct" 	- принимает и присваивает данные, необходимые для задачи
							Функция "handle"			- выполняет задачу с значениями, полученными в "__construct"
								Пример записи отправки письма в очередь:
									private $user;
									private $password;
									public function __construct($user, $password){
										$this->user = $user;
										$this->password = $password;
									}
									public function handle(){
										Mail::to($this->user)->send(new ForgotPassword($this->password));
									}
								Пример вызова функционала занесения задачи в очедедь из контроллера 3-мя способами:
									1) dispatch(new ForgonUserEmailJob($user, $password));
									2) $this->dispatch(new ForgonUserEmailJob($user, $password));
									3) ForgonUserEmailJob::dispatch($user, $password);
														
						4. Настройка работы записи в очередь
							По-умолчанию сейчас стоит тип записи в очередь "sync", чтобы поменять его на "database" нужно:
								В файле ".env" поменять значение строки "QUEUE_CONNECTION" с "sync" на "database".
							
							При отправке сообщения пользователем задача попадает в таблицу "jobs" на оидание выполнения. 
								Для выполнения задачи, находящейся в ожидании прописывается воркер - кмоманда, запускающая выполнение задач в очереди. 
								После запуска команды воркер будет ождать поступления задачи до закрытия консоли. 
								Пример:
									php artisan queue:work 

							Для работы воркера на живом(нелакальном) сервере в laravel - используется "Supervison Configuration". Принцип работы тот же, но для хостинга. 

						5. Ошибка при выполнения задачи, находящейся в очереди. 
							Если задача, напимер прописана с ошибкой в классе "ForgonUserEmailJob" - то задача при вызове воркера перезаписывается из таблицы "jobs" в другую таблицу "failed_jobs".
							Таблицы "failed_jobs" в отличии от "jobs" находится в БД по умолчанию вне зависимости от создания таблицы "jobs". В "failed_jobs" прописывается ошибка выполнения задачи.

							Конманда отображения зафейленных задач:
								php artisan queue:failed
									Команда отображеет ID задачи, тип очереди, класс поставивший задачу в очередь, время записи задачи в таблицу "failed_jobs". 
							
							Команда выполнения зафейленных задач:
								php artisan queue:retry all
									all - выполнение проверки всех зафейлиных задач. Здесь можно записать ID конкретной задачи. 
										Команда проверяет задачу и перевод ее из таблицы "failed_jobs" в таблицу "jobs". 
										Далее задача выполняется воркером либо его запуском, если проект не на хостинге и если ошибка исправлена. 
		*/

	echo '<hr><hr><br><h3>Laravel - #29.1-2 - Отправка уведомлений, События (День 29)</h3><hr><hr>' . "<br>";
		//!Урок 1: Отправка уведомлений
		/*
			Отправка уведоблений чем то пожоже на отправку email, но отлиичия есть:
				1) Уведомления отправляютяс по разным каналам ... например в соц.сеть или по SMS, когда как email только на почтовый клиент. Хотя под уведомление по-умолчанию подразумевается уведомление на email, хотя каналов уведомлений множество. 
				Размерем классический вариант уведомлений - череp email. 

				Команда создания класса для отправки уведомлений:
					php artisan make:notification ImportantError			
				Адресс класса отправки уведомлений:
					app\Notifications\ImportantError.php
				
			ОБЗОР ФНКЦИОНАЛА КЛАССА ОТПРАВКИ УВЕДОМЛЕНИЙ
				1) __construct() - конструктор
				2) via() - возвратщает массив каналов, по каторым доставляется сообщение. 
					TODO ЗАМЕТКА: для каждого канала придется рарабатывать свою отдельную функцию.  Для так сказать рендернга дял каждого канала.
					Отвечат за обработку канала объект "new MailMessage":
						->line('The introduction to the notification.') - строка
						->action('Notification Action', url('/')) - ссылка
						->line('Thank you for using our application!'); - строка
				3) toMail() - настройка внешнего вида канала
				4)	toArray() - возможность просмотра сообщений в виде массива

			ОТПРАВКА УВЕДОМЛЕНИЙ
				1-й способ отправки уведоблений - с шаблонами уведомлений Laravel по-умолчанию
					Создадим новый маршрут для проверки функционала на практике.
					Для отправки уведобления в контроллере понадобится фассад "Notification::" и класс отправки уведоблений "ImportantError".
					Создадим пользователй так, как сидер для пользовталей создавался только для темы авторзации:
						User::factory()->count(10)->create();
					Отправка сообщения:
						Notification::send(User::find(1), new ImportantError(150));
						где,
							Notification:: - фассад отправки уведоблений
							send - метод передачи. Аргументы: 1-й пользователь и объект
							150 - передаваемый аргумент - число
							TODO ЗАМЕТКА: почта пользователя выбирается автоматически из БД для отправки уведомления. Если поле с почтой или иным контактом названо не "email", то для этого прописывается отдельная функция для возврата почты в классе отправки уведомлений - и уже на нее ссыллается клас контроллера. 
							Пример:
								public function routeNotifacationForMail($notification){
										return $this->email;
								}
							Т.е. нужно каким то образом получить контактные даные. 
							Уведобление должно быть отправлено в логи, куда отправку мы и настроили предварительно. 

				2-й способ отправки уведоблений (более удобный):
					return (new MailMessage)->subject('Ошибка на сайте')->view(
						['emails.important_error', 'email.important_text'],
						['param' => $this->a, 'cufra' => 100]
					);
					где,
						MailMessage - фассад отправки почтового сообщения
						subject() - тема письма
						view() - передача параметров. 1-й массив: HTML+текстовый шаблоны. 2-й массив: передаваемые параметры. 
				
				
			ВСТРОЕННЫЕ ШАБЛОНЫ УВЕДОМЛЕНИЙ, ПОЧТЫ В LARAVEL
				Команда копирования шаблонов уведомлений в проект:
					php artisan vendor:publish --tag=laravel-notifications
				Адрес хранения шаблонов с уведомленийми:
					resources\views\vendor\notifications\email.blade.php
					В этом шаблоне и прописываются поля объекта "MailMessage" в виде ->line/->action.

				Но имхо лучше прописывать шаблоны самому, дабы избежать повторяющихся шаблонов с другими разработчиками. 

				Команда копирования почтовых шаблонов в проект:
					php artisan vendor:publish --tag=laravel-mail
				Адрес хранения почтовых шаблонов:
					resources\views\vendor\mail\html
					resources\views\vendor\mail\text
				Все шаблоны относятся к Markdown'у и содержат либо только текст либо текст + HTML.

			ИЗМЕНЕНИЕ СТАНДАРТНОГО ШАБЛОНА ПРОВЕРКИ ПОЧТЫ LARAVEL
				Зайддем в исходник и посмотрим стандартный шаблон:
					\vendor\laravel\framework\src\Illuminate\Auth\Notifications\VerifyEmail.php
					
				В этом классе есть методы формирования уведомления:
					1) toMail
					2) buildMailMessage
						Эти методы формируют шаблон и отправку писем. Если они не устраивают - можно создать свои на их базе, не меняя исходные. 
					
					После это - созданное уведомление нужно подключить к моделе пользователй. 
						Пример:
							public function sendEmailVerificationNotification()
							{
								$this->notify(new VerifyEmail);
							}
							где,
								new VerifyEmail - самомозданный класс формирования шаблонов уведомлений
		*/

		//!Урок 2: События
		/*
			
		Событие - это класс (event/событие), выполняется в коде при определенных условиях и запускает работу множества классов-обработчиков событий (listener/слушатель). 
		Создание события без создания listener'а/слушателя - не имеет смысла.
		Буть то отправка сообщения боту, e-mail, выгрузка в SRM и т.д.		
		После совершения какого либо события в приложении подразумевается множество действий.  Например при оплате товара на сайте высылается e-mail сообщение покупателю, менеджеру и т.п. Чтобы не захломлять контроллер множеством кода - используются события. 
		Входной точкой для инициализации событий является файл "app\Providers\EventServiceProvider.php". 

	1. Создание события, листенера и их настройка
		В отличии от очередей - для работы с событиями не нужно ничего создавать в БД перед созданием самого события - например таблицы "job".

		Создание события происходит через командную строку:
			php artisan make:event MyEvent
			где,
				make:event 	- создание события
				MyEvent		- название события
		Класс-событие будет только принимать переменные через конструктор, полученные из контроллера и после передавать их классам-листенерам.
		После создания класс появляется в папке "\app\Events\MyEvent.php";

		Создание обработчика (listener), отслеживающего событие:
			php artisan make:listener MyEventNotification
				или так 
			php artisan make:listener NewCommentEmailNotification --event=\App\Events\MyEvent (омжно и так: --event=MyEvent)
			где,
				make:listener 								- создание обработчика события
				MyEventNotification				- название обработчика
				--event=\App\Events\MyEvent	- параметр, указывающий listener'у от какого event-class'а принимать параметры
		Класс-listener будет выполнять действия с переменными, полученными от класса-события. 
		Cозданный класс появляется в папке "\app\Listeners\MyEventNotification.php";
			
	2. Работа с созданными событием и листенером
		Так как event только принимает аргументы от контроллера, то в его распоряжении достаточно оставить только конструктор с присваиванием аргумента полю. 
			class MyEvent{...
					public $comment;
					public function __construct($comment){
						$this->comment=$comment;
					}
			...}

		И так как listener в лишь выполняет действие с полученными аргументами от события, то ему достаточно оставить лишь метод выполнения (без контроллера). 
		Т.е. слушатель ловит объект события в мтеод "handle()", а не "__construct()";
			public function handle(MyEvent $event){
				echo $event->data.'<br>';
			}
			где,
				$event - объект события MyEvent
		
	3. Связывание слушателя и события
		Для взяимодействия события и слушателянужно связать в провайдере:
			Входной точкой для инициализации событий является файл "app\Providers\EventServiceProvider.php". 
			Провайдер: app\Providers\EventServiceProvider.php
			В нем уже имеется одно событие и в нем (событии) вызов одного обработчика:
			Пример:
				protected $listen = [
					Registered::class => [
						SendEmailVerificationNotification::class,
					],
				];
			где, 
			Registered - класс события
			SendEmailVerificationNotification - класс-обработчик (листенер/listener), активирующийся при совершении события
			
			Предварительно событие и слушателя нужно подключить:
				use App\Events\MyEvent;
				use App\Listeners\MyEventNotification;

			Новое событие с листенером будет выглядеть так:
				MyEvent::class => [
					MyEventNotification::class,
				],
			После срабатывания события "MyEvent" - выполняется листенер "MyEventNotification". Количество листенеров неограничено. 

	4. Добавление вызова события в контроллере
		Создаем маршрут, подключаем к контроллеру событие, пишем код - результат передаем в событие. 
		Пример:
			$comment = $post->comments()->create($request->validated());
			event(new MyEvent($comment));
				ИЛИ
			MyEvent::dispatch($comment);
			где,
				dispatch - метод передачи даных в конструктор события, подключенный в событие через трейт "use Dispatchable".
				event - метод создания объекта события. Что тоже равносильно вызову его конструктора. 
			
		TODO ЗАМЕТКА: Чтобы обработчик - listener приступал к отправки сообщения не сразу, а с задержкой - то ему нужно имплементировать интерфейс "ShouldQueue". 
		Пример:
			class NewCommentEmailNotification implements ShouldQueue {...}

		TODO ЗАМЕТКА: Минусом работы с событием является нечитабельный код. Дело в том, что незнакомому с проектом разработчику не понять просто так, куда класс-event передает полученный аргумент, так как в нем нет информации о листенере, а только есть метод "__construct{}". Слушатель события проверяется только в провайдере.

		*/

	echo '<hr><hr><br><h3>Laravel - #30.1-2 - Создание собственных команд для Artisan, Планировщик задач (День 30)</h3><hr><hr>' . "<br>";
		//!Урок 1: Создание собственных команд для Artisan
		/*
			СОЗДАНИЕ КОМАНД:
				В Laravel есть возможность создавать и свои artisan команды. 
				Они прописываются в созданном файле.
				Требуется это тоько в крупных проектах и не часто. например, когда это относится к задачам, которые должны выполняться черзе какие то промежутки времени. Например проверка ответных писем от почтовых сервисов. Формирование ежедневного отчета, отправляемого в email. 
				А зетем поставить планировщик - о нем в следующем уроке. 

				Пример создания команды файла с самописными комнадами:
					php artisan make:command TestCommand
				Адрес хранения самописных команд: 
					app\Console\Commands\TestCommand.php

			
			ПОЛЯ И МЕТОДЫ В ФАЙЛЕ САМОПИСНЫХ КОМАНД
				1) $signature - переменная с описанием команды (как называется, какие есть аргументы, какие параметры).
					Пример:
						protected $signature = 'uset:test {data} {--a} {--b=} {--O|options}';
						где,
							uset:test - название команды
							data - имя аргумента команды. 
							--a - переключатель, который при наличии в команда передает => true - 1, при отсутствии => 0 - false.
							--b= - параметр, принимающий значение. Аналог data, но указвающий ключ занчения
							--O|options/--O|options= - переключатель/параметр, имеющий сокращенное значение. 

						В команду так же можно переадвать массивы и т.п. На практике и приведенный объем избыточен. 

					Пример записи команда в консоль:
						php artisan user:test perviyParavetr --a --b=vtoroyParametr --options=text_oprions// или --options
							TODO ВАЖНО! при создании команды важно оставлять в нахзвание префиксы ":" во избежении повторения пользовательских команд с служебными. 
				
				2) $description - описание команды. Отображается после ввода команды "php adtisan list"
				3) В предыдущих версиях был конструктор, но он не важен, поэтому его убрали. 
				4) handle() - функция, вызываемая при ввыполнении команды. 
					Функция подразумевает вызов из себя функции класса с самописыными командами:					
						4.1) line() - вывод линии в консоль
						4.2) argument() - получение значения аргумента
							Пример вывода переданного аргумента в консоль:
								$this->line($this->argument('data'));
								где,
									data - название аргумента, записанного в переменной $signature
						4.3) info() - выывод строки, подсвеченаной синим цветом.
							$this->info($this->option('b'));
						4.4) warn() - выывод строки, подсвеченаной желтым цветом.
							$this->warn($this->option('b'));
						4.5) error() - выывод строки, подсвеченаной оранжевым цветом.
							$this->error($this->option('b'));
						4.6) option() - функция полученияе командой параметра
							$this->info($this->option('options'));
						4.7) newLine() - пустая строка ... хотя возможен и аргумент в виде значения строки
							$this->newLine();
						4.8) ask() - сообщение с запросом ввести значение в консоль для принятия в аргумент. 
							$data = $this->ask('Введите данные: '); // $data принимает аргумент после ввода значения после вопроса
						4.9) comment() - вывод сообщения в консоль, прописанного в переменной. Аналог info/warn/error, но без цвета. 
							$this->comment($data);
						4.10) confirm() - метод с запросом подтверждения. 
							if ($this->confirm('Уверены?: ')) {
								$this->line('yes');
							}else{
								$this->line('no');
							}
						4.11) call() - функция запуска команды. 1-й аргумент: название запускаемой команды, 2-й: массив с передаваемыми параметрами. 
							$this->call('list');

		*/

		//!Урок 2: Планировщик задач
		/*
			Планировщие задач - это более гибкий и настраиваемый аналог скрипта Crone, встроенный в Laravel.	
			TODO ЗАМЕТКА: Crone кстати тоже вызывается чреез artisan.
			Зачем нужен плинировщик:
				Планировщик нужен для автоматизированного запуска определенных команд, например каждый четверх 3-й недели месяца. 
				1) В некоторых аспектах планировщик будет удобнее crone'а, а в некоторых просто незаменим им. 
				2) Когда нужно, чтобы команда не запускалась дважды подряд если весь пакет команд запускается по-новой из за сбоя например. Crone же пришлось бы костылить.
				3) На сайте может быть множество команд, на отправку уведомлений ежедневных или нет. При переезде на другой сервер Crone придется заново настраивать, а плинировщик же остается в проекте без необходимости перенастройки. Он запускается одной командой Crone'ом через artisan.
				
				СОЗДАНИЕ ЗАДАЧИ:
					php artisan make:command UpdateFileCommand
					Адрес файла, выполняющего задачу: app\Console\Commands\UpdateFileCommand.php

					Поля и метдоы представлены по подобию с классом созданных команд artisan. 
						signature - настройка команд в artisan. 
						$description - описание команды. 
						handle() - код запускаемый при обращении к планировщику.
					
					Пример:
						protected $signature = 'user:updatefile'; - даем название команде.
						handle(){
							$this->line('Start...'); - строка в терминале		  				
							Storage::disk('local')->put('comand.txt',  time()); - создание файла в диске local с текущей временной меткой
						}
					Запуск команды для проверки файла: 
						php artisan user:updatefile
						storage\app\comand.txt - файл создан: 1687636083

			ДОБАВЛЕНИЕ ЗАДАЧИ В ПЛАНИРОВЩИК ЗАДАЧ:
				Задачи, записанные в планировщик находятся в файле: app\Console\Kernel.php и метде: schedule().
				Пропишем записанную ранее задачу в планировщик.
					Пример:
						$schedule->command('user:updatefile'){
							->everyMinute()
							->between('12:00', '20:00')
							->WithoutOverlapping();
						}	
						где,
							command() - меотд запускающие комнаду
							user:updatefile - запускаемая команда
							everyMinute() - таймаут запуска команды
							between() - метод определяющий временной отрезок запуска команды
							WithoutOverlapping() - метод запрещающий запускать следующию иттерацию команды с таймаутом до ее полного выполнения. 
						Есть множество других инструментов в планировщике, но и эти достаточно часты.
						Метод Crone не имеет аналогичного метода "WithoutOverlapping()".
						TODO ЗАМЕТКА: запрет на перехд на следующую иттерацию очень важен. Иногда комнада может не выполниться полностью в таймаут 1 мин. Тогда следущая иттерация выполнит пункты задачи предудущей иттерации повторно. Это может быть отправка писем - тогда получатели письма получит его второй раз. После каждого отправленного письма выставлять пометку "отправлено" в БД - накладно для производительности - это делается одной командой в конце задачи, когда все писмьа отправлены.

			КОМАНДА ЗАПУСКА ПЛАНИРОВЩИКА:
				1) php artisan schedule:run
					Эта команда запускает все задачи в планировщике задач единоразово.
					TODO ВАЖНО! Именно эту комнаду (php artisan schedule:run) и нужно сиавить в Crone на таймаут указанный в планировщике => 1 мин. 
						Созержание файла storage\app\comand.txt: до запуска планировщика - 1687636083; до запуска планировщика: 1687685791
				2) php artisan schedule:work
					Эта команда запускает все задачи в планировщике задач циклично.
					TODO ВАЖНО! Для заврешения работы этого планировщика достаточно в терминале прожать CTRL+C.
					TODO ЗАМЕТКА: Эта команда запускается только на этапе разработке для проверки работы планировщика.
					

		*/

	echo '<hr><hr><br><h3>Laravel - #31.1-3 - Локализация, Helpers, Заключение (День 31)</h3><hr><hr>' . "<br>";
		//!Урок 1: Локализация
		/*
			НАСТРОЙКА ЛОКАЛИЗАЦИИ
				Папка локализации: lang
				В старых версиях она находилась в ресурсах. 
				В папке есть папки с самой локализацией - по-умолчнию "en".
				Папка вмещает языковые константы: ключ - значение своей локализации. 
				Прмиер константы en\pagination.php:
					'previous' => '&laquo; Previous',
					'next' => 'Next &raquo;',
					где,
						previous - ключ на который ссылается шаблон
						&laquo; Previous - значение ключа, выводимое при обращении к нему

			СОЗДАНИЕ СВОИХ КОНСТАНТ		
				а) Создать константу можно чрезе создание файла в папке локали с возвратом массива, где константа - ключ, значнеие - перевод локали. 
				Создавать файлы констант лучше для отдельных задач. Константы только для авторизации, контснты для паролей, константы для вывода ошибок и т.д. 
					Пример: validation/passwords/pagination ... и т.п.
				
				б) Так же константы можно объявлять без создани файла, а через внесения в файл "\lang\en|ru.json"
					Там так же прописываются связки ключ значения, но в виде JSON. 
						Пример:
							{
								"welcome": "Добро пожаловать из JSON :name!",
								"password": "пароль",
								"error": "ошибка",
								"hello": "привет"
							}
							где,
								password - константа
								пароль - значение
								:name - переманная, получаемую в шаблоне от контроллера
							Пример вызова константы с параметрами:
								echo __('welcome', ['name' => 'переданное имя']).'<hr>';

			МЕТДЫ РАБОЫТ С ЯЗЫКОВЫМИ КОНСТАНТАМИ
				Для работы языковой константы есть методы:
					1) trans() - функция обращения к константе. Аргументом выступает путь до константы в папке /locale/ru|en/.
						Пример:
							echo trans('testLocation.welcome'); "Добро пожаловать/welcome"; В файле: lang\ru\auth.php
							echo trans('welcome'); "Добро пожаловать/welcome"; В файле: lang\ru.json
							где,
								testLocation - константа 
								welcome - параметр константы
							TODO ЗАМЕТКА: в аргументах методов обращения к контснтам не находящихся в отдельном файле кроме JSON - указываюстя только константы. 
					2) __() - аналог мтеода trans(), выставленные через двойное подчеркивание.
						Пример:
							echo __('testLocation.welcome'); "Добро пожаловать/welcome";
							TODO ЗАМЕТКА: такой метод чаще используется в шаблонах.
					3) setLocale() - метод динамической смены локали. Используется через фассад "App". Аргументом выступает локаль. 
						Пример:
							App::setLocale('ru');	
					4) currentLocale() - метод проверки/вывода локали. Используется через фассад "App". 
						Пример:
							echo App::currentLocale('ru');	
		*/

		//!Урок 2: Helpers
		/*
			Некоторые задачи ситуации и задачи повторяются в проектах достаточно часто. 
			Для таких редовых ситуаций были созданы хелперы => Helpers. 
			Они избаляют от необходимости прописывать функционал часто повторяющихся функций. По-сути они выполняют роль стандартных функций языка, но и дополняют их.  
			Наример до PHP 8 функции "str_contains()" не было, поэтому приходилось пользоваться хелпером Str::constant(). Или методом вывода ошибок: abort(403).
			
			TODO ЗАМЕТКА: хелперы нужно подключать как и фассады.
				Пример:
					use Illuminate\Support\Str;

			Разберем в рамках курса несколько вариантов хелперов:	
				1) Str::contains() - метод происка в строке подстроки. 1-й аргумент строка, 2-й аргумент строка искомая в строке. 
					Пример:
						return (Str::contains('строка из символов в которой есть Str', 'Str')) ? 'Строка нашлась' : 'строка не нашлась';
				2) Str::endsWith() - метод проверки на заврешение строки определенным определенной подстрокой. 
					Пример:
						echo (Str::endsWith('строка из символов в которой есть Str', 'Str')) ? 'Заканчивается на X подстраку'.'<br>' : 'Не заканчивается на X подстраку'.
				3) Str::startsWith() - метод проверки на заврешение строки определенным определенной подстрокой. 
					Пример:
						echo (Str::startsWith('строка из символов в которой есть Str', 'Str')) ? 'начинается на X подстраку'.'<br>' : 'Не начинается на X подстраку'.<br>;
				4) Str::replaceLast() - функция замены последней указанной подстроки в строке, указанной подстрокой. 1-й аргумент - заменяемая подстрокастрока, 2-й - заменяющая подстрока, 3-й строка с заменяемой подстрокой. В то время как аналог PHP заменяет все указанный подстроки в строке. 
					Пример:
						echo Str::replaceLast('Str', 'replaceLast', 'строка из символов в которой есть Str').'<br>';
				5) Str::words() - обрезает строку до указанного количества слов. 1-й аргумент - брезаемая строка, 2-й количество оставляемых слов, 3-й (дополнительный) - строка, на которую заменяется строка удаленная.
					Пример:
						echo Str::words('несколько слов в предложении', 2).'<br>';
				6) Str::random() - фнкция генерации количества символов. Аргумент - количество случайно генерируемух символов.
					Пример:
						echo Str::random(10).'<br>';
		*/

		//!Урок 3: Заключение
		/*
			Курс подошел к концу. 
				Для дальнейшего обучения и устройства на работу нужны практика и подготовка проектов.
		*/