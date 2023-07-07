<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$dataTime = $this->faker->dateTime(); // случайное время
        return [
            'post_id' => mt_rand(1, 20),
				'name' => $this->faker->name(),
				'text' => $this->faker->realText(mt_rand(20, 300)),
				'access_token' => Str::random(32), //генератор токена доступа к комменту из 32 символов
				'created_at' => $dataTime, //время созданяи комментария 
				'updated_at' => $dataTime, //время обновления комментария 
        ];
    }
}
