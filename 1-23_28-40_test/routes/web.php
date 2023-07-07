<?php

//use GuzzleHttp\Psr7\Request;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Маршрутизация - день 3
Route::get('/', function () {
   return view('welcome');
});

Route::get('/user/{id?}', function($id='not found user'){
	return 'user: '.$id;
})->where('id', '[0-9]+');

Route::redirect('/before_str{id}', 'after_str{id}'); //301 - редирект временный
Route::permanentRedirect('/before_str{id}', 'after_str{id}'); //302 - редирект постоянный

//День 4 ограничение запосов
Route::group(['prefix' => 'feedback'], function(){ //передача посреднику настройку ограничения запросов
	Route::get('/', function () {return 'feedback';});
	Route::get('/user', function () {return 'feedback-user';});
});

//Урок №3 Контроллеры
Route::middleware("throttle:test_RateLimiter")->group(function () {//передача посреднику настройку ограничения запросов
	Route::get('/controller-first/{key}', [App\Http\Controllers\FirstController::class, 'index']);
});

Route::get('/testview', [App\Http\Controllers\FirstController::class, 'testView']);
Route::get('/mypage', [App\Http\Controllers\FirstController::class, 'viewPage']);
Route::get('/testblade', [App\Http\Controllers\FirstController::class, 'testBlade']);
Route::get('/extendsview', [App\Http\Controllers\FirstController::class, 'extendsView']);
Route::get('/testcomponent', [App\Http\Controllers\FirstController::class, 'viewComponent']);
Route::get('/testlayout', [App\Http\Controllers\FirstController::class, 'viewLayout']);
Route::get('/request', App\Http\Controllers\FirstController::class); 
Route::get('/testresponse', [App\Http\Controllers\FirstController::class, 'viewResponse']);
Route::get('/testurl', [App\Http\Controllers\FirstController::class, 'viewUrl'])->name('tUrl');
Route::get('/activate', [App\Http\Controllers\FirstController::class, 'viewActivate'])->middleware('signed')->name('activate');
Route::get('/counter', [App\Http\Controllers\FirstController::class, 'viewCounter']);
Route::get('/testexception', [App\Http\Controllers\FirstController::class, 'testException']);
Route::get('/testlog', [App\Http\Controllers\FirstController::class, 'testLog']);
Route::get('/testldb', [App\Http\Controllers\DBController::class, 'testDB']);
Route::get('/testquerybilder', [App\Http\Controllers\DBController::class, 'testQB']);
Route::get('/testpaginate', [App\Http\Controllers\DBController::class, 'testPaginate']);
Route::get('/testmodel', [App\Http\Controllers\PostController::class, 'testModel']);
Route::get('/testam', [App\Http\Controllers\PostController::class, 'testAm']);
Route::get('/testobserver', [App\Http\Controllers\PostController::class, 'testObserver']);
Route::get('/testrelations', [App\Http\Controllers\PostController::class, 'testRelations']);
Route::resource('/addresses', App\Http\Controllers\AddressController::class);
Route::get('/testform/', [App\Http\Controllers\FormController::class, 'testForm']);
//Route::post('/testform/send', [App\Http\Controllers\FormController::class, 'send']);
Route::post('/testform/sendbyrequest', [App\Http\Controllers\FormController::class, 'sendByRequest']);
Route::get('/testupload', [App\Http\Controllers\FormController::class, 'testUpLoad']);
//Route::match(['get', 'post'], '/testupload', [App\Http\Controllers\FormController::class, 'testUpLoad']);
Route::any('/testupload', [App\Http\Controllers\FormController::class, 'testUpLoad']);

//маршруты с 28-го дня
Route::get('/testmail', [App\Http\Controllers\AdvancedController::class, 'testMail']);
Route::get('/testnotification', [App\Http\Controllers\AdvancedController::class, 'testNotification']);
Route::get('/testevent', [App\Http\Controllers\AdvancedController::class, 'testEvent']);
Route::get('/testlocalization', [App\Http\Controllers\AdvancedController::class, 'testLocalization']);
Route::get('/testhelpers', [App\Http\Controllers\AdvancedController::class, 'testHelpers']);

