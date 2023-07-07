<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Mail\Hello;
use App\Models\User;
use App\Notifications\ImportantError;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AdvancedController extends Controller
{
	private $a = 'параметр';
    public function testMail(){
		 $pushmessage = Mail::to('koliya@example.com')->send(new Hello('Николай'));
		 $pushmessage = ($pushmessage) ? 'Письмо успешно отправлено!' : '' ; 
		 return 'Проверка работы отправки письма: '.$pushmessage;
	 }
    
	 public function testNotification(){
		//User::factory()->count(10)->create();
		//Notification::send(User::find(1), new ImportantError(150)); //1-й способ отправки уведомлений
		return (new MailMessage)->subject('Ошибка на сайте')->view(
				['emails.important_error', 'email.important_text'],
				['param' => $this->a, 'cufra' => 100]
		);
		return 'Проверка';
	 }

	 public function testEvent(){		
		$param = 'переданные данные в событие';
		MyEvent::dispatch($param);
		//event(new MyEvent($param)); так тоже можно
	 }

	 public function testLocalization(){	
		App::setLocale('ru');	
		echo 'Текущая локаль: '.App::currentLocale().'<br>';
		echo 'Метод "trans": '.trans('testLocation.welcome').'<br>';
		echo 'Метод "__": '.__('testLocation.welcome').'<hr>';
		echo __('welcome', ['name' => 'переданное имя']).'<hr>';
	 }

	 public function testHelpers(){	
		
		//Str::contains('строка из символов в которой есть Str', 'Str');
		echo (Str::contains('строка из символов в которой есть Str', 'Str')) ? 'Строка нашлась'.'<br>' : 'строка не нашлась'.'<br>';
		echo (Str::endsWith('строка из символов в которой есть Str', 'Str')) ? 'Заканчивается на X подстраку'.'<br>' : 'Не заканчивается на X подстраку'.'<br>';
		echo (Str::startsWith('строка из символов в которой есть Str', 'Str')) ? 'начинается на X подстраку'.'<br>' : 'Не начинается на X подстраку'.'<br>';
		echo Str::replaceLast('Str', 'replaceLast', 'строка из символов в которой есть Str').'<br>';
		echo Str::words('несколько слов в предложении', 2).'<br>';
		echo Str::random(10).'<br>';

	 }
}
