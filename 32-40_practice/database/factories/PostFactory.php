<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
			$aliases = [ '5steps', 'ab-1', 'ab-2', 'ab-3', 'ab', 'actuser', 'admin', 'allusers', 'analysis-2', 'analysis-engine', 'analysis-wall', 'analysis', 'android', 'answers', 'api-vk', 'authuser', 'avatar', 'best-cms', 'best-framework', 'chat', 'choice-cms', 'cms']; //массив с алиасами
        return [
			  'is_release' => mt_rand(1, 2) == 1, //true || false
            'title' => $this->faker->realText(mt_rand(20, 100)), // текст от 20-100 чимволов
            'alias' => $this->faker->unique()->randomElement($aliases), //вместе с алиасом будет и картинка, отвечающая за пост: analist-img.png 
            'intro_text' => FactoryHelper::getFakeHTMLText($this->faker, 1), //генерация текста с HTML
            'full_text' => FactoryHelper::getFakeHTMLText($this->faker, mt_rand(2, 10)), //от 2 до 10 абзацов
            'meta_desc' => $this->faker->realText(mt_rand(20, 250)), //от 20 до 250 символов
            'meta_key' => implode(', ', $this->faker->words(mt_rand(3, 5))), //возврат массив случайных слов, преобразованных в строку
            'hits' => mt_rand(0, 1000), //число просмотров
            'date_show' => $this->faker->dateTimeBetween($startDate = '-1 year', $endDate = '+1 month') //время показа +-1 год/день
        ];
    }
}
