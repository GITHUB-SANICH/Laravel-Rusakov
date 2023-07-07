<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FreeCourse>
 */
class FreeCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		{ 
			$aliases = ['html','freephp','freemakeup','freeim','book','freejs','freephp2','freehtml5','freefl','freeim2','freelanding','freereactjs','freephp7','freejoomla','freemakeup2','freejava','freeandroid','freewp5','freejavaproject','freepython','freejavascript2','freeue4','freecsharp','freecpp','freepythonlife','freedjango','freephp8'];

			  return [
				'delivery_id' => mt_rand(1, 100), 
				'title' => $this->faker->realText(mt_rand(55, 60)), 
				'alias' => $this->faker->unique()->randomElement($aliases), //
				'description' => FactoryHelper::getFakeHTMLText($this->faker, mt_rand(2, 4)), 
			  ];
		 }
    }
}
