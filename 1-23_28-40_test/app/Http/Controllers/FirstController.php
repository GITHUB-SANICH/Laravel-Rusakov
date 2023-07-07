<?php

namespace App\Http\Controllers;

use App\Exceptions\MyException;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class FirstController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        return 'Проверка мидлвара завершена';
    }
	 public function testView(Request $request)
	 {
		 return view('example')
		 	->with('id', 'айдишник')
		 	->with('name', 'Имя')
		 	->with('email', 'мыло');
	}   

	public function viewPage(Request $request)
    {
		$clients = ['Jone', 'Nike', 'Todd'];
		return View::make('mypage', ['clients' => $clients]);
    }
	public function testBlade(Request $request)
    {
		return view('testblade', ['a' => 'Какие нибуть данные', 'b' => 'Коммент']);
    }

	public function extendsView(Request $request)
    {
		return view('childs.index');   
    }

	public function viewComponent(Request $request)
    {
		return view('testcomponents', ['a' => 'Data from justen controller']);   
    }

	public function viewLayout(Request $request)
    {
		return view('childs.indexlayout');   
    }

	 public function viewResponse()
	 {
		echo '1) response()/response()->header(): <br>'.response('Сожержимое тела запроса', 200)->header('Content-type', 'text/plain').'<br>';
		echo '2) response()->json(): <br>'.Response::json(['par1' => 'var1', 'par2' => ['var2.1', 'var2.2', 'var2.3'], 'par3' => true]).'<br>';
		echo '3) response()->download(): <br>'.response()->download('H:\SERVAK\OPEN_SERVER_pgu\OSPanel\domains\Laravel-Rusakov\storage\app\public\img\txt.txt').'<br>';
		return response()->download('H:\SERVAK\OPEN_SERVER_pgu\OSPanel\domains\Laravel-Rusakov\README.md');
		echo '4) response()->file(): <br>'.response()->file('H:\SERVAK\OPEN_SERVER_pgu\OSPanel\domains\Laravel-Rusakov\storage\app\public\img\txt.txt').'<br>';
		return response()->file('H:\SERVAK\OPEN_SERVER_pgu\OSPanel\domains\Laravel-Rusakov\storage\app\public\img\txt.txt');
		return 'Response GET';
	 }

	 public function viewUrl(Request $request)
	 {
		echo '1) url()->current(): <br>'.url()->current().'<br>';
		echo '2) url()->full(): <br>'.URL::full().'<br>';
		echo '3) url()->previous(): <br>'.url()->previous().'<br>';
		echo '4) route(): <br>'.route('tUrl', ['id' => 15]).'<br>';
		//5-й пример генерации секретных ссылок в методе "viewActivate"
		//URL::signedRoute ссыллается на ссылку/псевданим "activate", которая запускает метод "viewActivate" для проверки подписи.
		echo '5) url()->signedRoute(): <br>'.URL::signedRoute('activate', ['id' => 1]).'<br>';
		echo '6) url()->temporarySignedRoute(): <br>'.URL::temporarySignedRoute('activate', now()->addMinutes(5), ['id' => 1]).'<br>';
	 }

	 public function viewActivate(Request $request)
	 { 
		//if($request->hasValidSignature()) return 'Ссылка успешно подписана: '.$request->id;
			abort(401);
	 }

	 public function viewCounter(Request $request)
	 {
		echo '1) session()->all():';
		echo '<pre>';
			print_r(session()->all());
		echo '</pre>';
		echo '2) ->exisat():  '.session()->exists('var').'<br>';
		echo '3) ->has():  '.session()->has('var').'<br>';
		echo '4) ->put():  '.session()->put('var', "var_session").' => '.session()->get('var').'<br>';
		session(['mass', ['var1', 'var2', 'var3']]);
		//echo '5) ->push():  '.session()->push('mass', 'var4').' => '.session()->get('mass').'<br>';
		//echo '6) ->pull():  '.session()->pull('mass').' => '.session()->get('mass').'<br>';
		echo '7) ->forget():  '.session()->forget('var').'<br>';
		//$counter = session()->get('counter', 0);
		//$counter++;
		//session()->put'counter', $counter);
		//return $counter;
		session()->increment('counter');
		return session()->get('counter');
	}

	 public function testException(Request $request)
	 {
		throw new MyException();
	}

	 public function testLog(Request $request)
	 {
		//Log::debug('debug-level message'); //все, что в методе - сообщение отправляемое в лог
		//Log::info('info-level message');
		//Log::notice('normal but significant condition');
		//Log::warning('warning conditions');
		//Log::error('error conditions');
		//Log::critical('critical conditions');
		//Log::alert('action must be taken immediately');
		//Log::emergency('system is unusable');
		//передача логов по каналу не по-умолчанию

		Log::channel('daily')->info('Сообщение по каналу "daily"');
		Log::channel('mychannel')->info('Сообщение по созданному вручную каналу "mychannel"', ['data' => 'значение массива с передаваемыми данными']);
	 }
	
    public function __invoke(Request $request)
    {
		echo 'Вызов метода: invoke<br>
		<b>Вызов методов объекта "Request":</b><br>';
			echo '1) ->header:  '.$request->header('Host').'<br>';
			echo '2) ->method:  '.$request->method().'<br>';
			echo '3) ->isMethod:  '.$request->isMethod('GET').'<br>';
			echo '4) ->ip:  '.$request->ip().'<br>';
			echo '5) ->path:  '.$request->path().'<br>';
			echo '6) ->url:  '.$request->url().'<br>';
			echo '7) ->fullUrl:  '.$request->fullUrl().'<br>';
			echo '8) ->fullUrlWithQuery:  '.$request->fullUrlWithQuery(['par1' => 'var1']).'<br>';
			echo '9) ->input:';
				echo '<pre>';
					print_r($request->input());
				echo '</pre>';
			echo '10) ->query:';
				echo '<pre>';
					print_r($request->query());
				echo '</pre>';
			echo '11) ->has:  '.$request->has('b').'<br>';
			echo '12) ->filled:  '.$request->filled('b').'<br>';
    }

}
