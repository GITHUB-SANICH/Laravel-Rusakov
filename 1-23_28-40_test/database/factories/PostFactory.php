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
        return [
			'author' => $this->faker->name(),
			'title' => $this->faker->text(mt_rand(10, 30)), //генерация случайного колличества символов от 10 до 30 (по-умолчанию метод "text()" максимум 200 символов).
			'is_publish' => mt_rand(1, 2) == 1 //рандомный вывод числа, при котором 1 == true
        ];
    }
}
