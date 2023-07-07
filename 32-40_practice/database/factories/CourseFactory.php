<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
		$aliases = ['makeup','php','javascript','html5','php2','wp','fl','yii','im2','landing','reactjs','joomla','php7','web55','makeup2','java','android','wp5','javaproject','python','javascript2','ue4','csharp','cpp','pythonlife','django','php8'];
        return [
				'product_id' => mt_rand(1, 40), 
				'title' => $this->faker->realText(mt_rand(55, 60)), 
				'alias' => $this->faker->unique()->randomElement($aliases), //
				'slider_description' => $this->faker->realText(420), //
				'full_description' => FactoryHelper::getFakeHTMLText($this->faker, mt_rand(2, 4)), 
				'price' => mt_rand(1000, 45000), //цена
        ];
    }
}
