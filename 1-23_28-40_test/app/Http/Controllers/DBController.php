<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DBController extends Controller
{
	public function showData($var){
		//echo gettype($var); каждый элемент массива является объектом
		echo 'Айдишник: '.$var->id.'<br>';
		echo 'Айдишник поста: '.$var->post_id.'<br>';
		echo 'Имя: '.$var->name.'<br>';
		echo 'Текст: '.$var->text.'<br>';
		echo 'Время создания: '.$var->created_at.'<br>';
		echo 'Время обновления: '.$var->updated_at.'<br>';
		echo '-_-_-_-_-_-_-_-_-_-_-_-'.'<br><br>';
		}

    public function testDB(){
		////Заносимые данные в БД
		//$names = ['Freed', 'Helga', 'Nicolas', 'Василий', 'Григорий'];
		//for ($i=0; $i < 100; $i++) { 
		//	$post_id = mt_rand(1, 10);
		//	$name = Arr::random($names); //хелпер, работы с массивом (метод "random" выбирает случайны элемент). 
		//	$text = Str::random(mt_rand(30, 100)); //хелпер, генерации текста (метод "random" выбирает одно из предложенных значений). 
		//	$created_at = date('Y-m-d H:i:s');
		//	$updated_at = $created_at;
		//}

		//Примеры использования фассада DB для работы с БД
		$dataComment = DB::select('SELECT * FROM `comments`');
		//echo gettype($dataComment); переменная с содержимом запроса является массивом
		foreach ($dataComment as $var) {
			$this->showData($var);
		}
		//DB::insert('INSERT INTO `comments` (`post_id`, `name`, `text`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)',	[
		//	$post_id, $name, $text, $created_at, $updated_at
		//]);
		//DB::update('UPDATE `comments` SET `post_id` = ? WHERE `post_id` = ?', [4, 10]); //значения массива это соотетственно 1-й и 2-й вопросы
		//DB::delete('DELETE FROM `comments` WHERE `name` = :name', ['name' => 'Freed']);
		//DB::transaction(function(){
		//	DB::insert('INSERT INTO `comments` (`post_id`, `text`) VALUES (?, ?)',	[2, 'Lorem, ipsum dolor.']);
		//	DB::update('UPDATE `comments` SET `post_id` = ? WHERE `post_id` = ?', [4, 10]);
		//});
	 }

    public function testQB(){
		//DB::table('comments')->insert([
		//	['post_id' => '5', 'name' => 'Вася', 'text' => 'некоторый текст2'],
		//	['post_id' => '6', 'name' => 'Федя', 'text' => 'некоторый текст3']
		//]);
		//DB::table('comments')->where('post_id', 5)->update(['post_id' => '2']);
		//DB::table('comments')->where('post_id', 2)->increment('post_id', 10);
		//DB::table('comments')->where('post_id', 12)->delete();
		//$comments = DB::table('comments')->where('post_id', 1)->get();
		//$comments = DB::table('comments')->where('post_id', '>', 1)->first();
		//$comments = DB::table('comments')->whereBetween('id', [2, 4])->get();
		//$comments = DB::table('comments')->whereNotBetween('id', [2, 4])->get();
		//$comments = DB::table('comments')->whereIn('id', [2, 4])->get();
		//$comments = DB::table('comments')->whereNotNull('post_id')->get();
		//$comments = DB::table('comments')->where(function($query){
		//	$query->where('post_id', 6)->where('name', 'Helga');
		//})->OrWhere('post_id', 3)->get();
		//$comments = DB::table('comments')->first(1);
		//$comments = DB::table('comments')->select('id')->where('post_id', 3)->get();
		//$comments = DB::table('comments')->orderBy('name')->orderBy('post_id')->get();
		//$comments = DB::table('comments')->inRandomOrder()->get();
		//$comments = DB::table('comments')->limit(2)->offset(3)->get();
		//$comments = DB::table('comments')->count();
		//$comments = DB::table('comments')->where('post_id', 1)->count();
		//$comments = DB::table('comments')->min('post_id');
		//$comments = DB::table('comments')->max('post_id');
		//$comments = DB::table('comments')->avg('post_id');
		//$comments = DB::table('comments')->sum('post_id'); 
		//$comments = DB::table('comments')->where('post_id', 1)->exists();
		//DB::table('comments')->where('post_id', 1)->dd();
		//DB::table('comments')->orderBy('id')->chunk(2, function($comments){
		//	foreach ($comments as $comment) {
		//		print_r($comment);
		//		echo '<br>';
		//	}
		//	echo 'Chank end<br><hr>';
		//});
		DB::table('comments')->orderBy('id')->lazy()->each(function($comment){
			print_r($comment);
			echo '<br><hr>';
		});
			//return $comments;
		//foreach ($comments as $var) { 
		//	$this->showData($var);
		//}
	}

    public function testPaginate(){
		$comments = DB::table('comments')->paginate(10);
		return view('pagination', ['comments' => $comments]);
	}
}
