<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		
      $names = ['Freed', 'Helga', 'Nicolas', 'Василий', 'Григорий'];
		for ($i=0; $i < 200; $i++) { 
			$post_id = mt_rand(1, 10);
			$name = Arr::random($names); //хелпер, работы с массивом (метод "random" выбирает случайны элемент). 
			$text = Str::random(mt_rand(30, 100)); //хелпер, генерации текста (метод "random" выбирает одно из предложенных значений). 
			$created_at = date('Y-m-d H:i:s');
			$updated_at = $created_at;
			
			/*1-й способ написания запоса
			DB::insert('INSERT INTO `comments` (`post_id`, `name`, `text`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)',	[
				$post_id, $name, $text, $created_at, $updated_at
			]);*/
			//2-й способ передачи данных в таблицу
			DB::table('comments')->insert([
				'post_id' => $post_id, 
				'name' => $name, 
				'text' => $text, 
				'created_at' => $created_at, 
				'updated_at' => $updated_at
			]);
		}
    }
}
