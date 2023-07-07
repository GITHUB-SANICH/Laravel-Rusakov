<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'address' => 'http://'.$this->faker->domainName(), //адрес сайта
			'description' => $this->faker->realText(mt_rand(20, 200)),
			'is_active' => mt_rand(1, 2) == 1,
        ];
    }
}
