<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Address;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class PostController extends Controller
{
	public function testModel(){
		//Запись строки
		//1-й способ записи
		//$post = new Post();
		//$post->author = 'Федор';
		//$post->title = 'новый пост';
		//$post->is_publish = false;
		//$post->save();

		//2-й способ записи
		//$post = Post::factory()->make();
		//echo '2-й способ записи: '.$post->author; //вывод поля со случайным значением
		//$post->title = 'Добавленный пост';
		//$post->save();

		//3-й способ записи
		//$post = Post::create(['author' => 'Ванек', 'is_publish' => true]); //данный меотд добавит запись в БД и создаст объект на основе добавленной записи

		//Вспомогательные методы
		$post = Post::find(4);
		echo 'Вывод поля строки: "'.$post->title.'"<br>';
		echo 'Проверка объекта на изменения через "isClean()" '.$post->isClean().'<br>';
		echo 'Проверка объекта на изменения через "isClean(\'title\')" '.$post->isClean('title').'<br>';
		echo 'Проверка объекта на изменения через "isClean(\'author\')" '.$post->isClean('author').'<br>';
		echo 'Проверка объекта на изменения через "isDirty()" '.$post->isDirty().'<br>';
		echo 'Проверка объекта на изменения через "isDirty(\'title\')" '.$post->isDirty('title').'<br>';

		foreach (Post::all() as $post) {
			echo 'Вывод всех значений поля объекта: "'.$post->title.'"<br>';
		}echo '<br><hr>';

		$post = Post::findOrFail(4);

		$posts = Post::where('is_publish', 0)->get();
		foreach ($posts as $post) {
			echo 'Вывод всех значений поля объекта: "'.$post->title.'"<br>';
		}echo '<br><hr>';

		$post = Post::where('is_publish', 1)->first();
		echo 'Вывод всех значений поля объекта: "'.$post->author.'"<br>';

		$posts = Post::where('is_publish', 0)->orderByDesc('author')->get();
		foreach ($posts as $post) {
			echo 'Вывод всех значений поля объекта: "'.$post->author.'"<br>';
		}echo '<br><hr>';

		$posts = Post::all();
		$posts = $posts->reject(function($posts){
			return $posts->author == 'Eladio Thiel';
		});
		foreach ($posts as $post) {
			echo 'Вывод всех значений поля объекта: "'.$post->author.'"<br>';
		}echo '<br><hr>';
		
		Post::where('is_publish', 0)->chunk(3, function($posts){
			foreach ($posts as $post) {
				echo $post->author.'<br>';
			}echo '.............<br>';
		});

		
		foreach (Post::where('is_publish', 0)->cursor() as $post){
			echo $post->title.'<br>.............<br>';
		}
		
		Post::where('id', '<', 5)->update(['is_publish' => 1]);
		echo '<hr>';
		//Post::find(11)->delete();

		//Post::destroy(11);

		//Post::destroy([6, 8, 9]); //удаление множества записей
		
		$posts = Post::withTrashed()->get();
		//Post::withTrashed()->where('id', '<', 5)->get();
		foreach ($posts as $post) {
			echo $post->author.'<br>^^^^^^^^^^^^^^<br>';
		}
	}

	public function testAm(){
		//работа аксессора
			$post = Post::find(1);
			echo $post->author.'<br>';
		//работа мутатора
			$post->author = 'Новый автор';
			$post->save();
			echo 'Новое название атвора: '.$post->author.'<br>';
			echo gettype($post->is_publish);
	}

	public function testObserver(){
		$post = Post::factory()->make();
		$post->title = 'Пост создан чреез testObserver';
		$post->save();

		$post = Post::orderByDesc('id')->first();
		$post->author = 'Обновленное имя автора';
		$post->delete();
		$post->restore();
		$post->forceDelete();
	}

	public function testRelations(){
		$client = Client::find(1);
			echo 'Вывод имени клиента: '.$client->name.'<br>';
			echo 'Вывод адреса клиента: '.$client->address->address.'<br><br>';

		$address = Address::find(1);
			echo 'Вывод адреса клиента: '.$address->address.'<br>';
			echo 'Вывод имени клиента: '.$address->client->name.'<br><br>';
				echo '<hr>';
	
		$orders = Client::find(1)->orders;
			foreach ($orders as $order) {
				echo 'Вывод номера Id заказа клиента: '.$order->id.'<br>';
			}

		$clien = Order::find(1)->client;
			echo 'Вывод клиента заказа: '.$clien->name.'<br>';
				echo '<hr>';	

		$products = Order::find(1)->products;
			foreach ($products as $product) {
				echo 'Товар из заказа: '.$product->title.'<br>';
			}
		$orders = Product::find(1)->orders;
			foreach ($orders as $order) {
				echo 'Вывод номера заказа, у которого товар имеет Id = 1: '.$order->id.'<br>';
			}
	}
}
