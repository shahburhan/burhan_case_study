<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->text(20),
            'user_id'     => User::first()->id,
            'category_id' => Category::get()->random()->id,
            'description' => $this->faker->realText(),
            'price'       => $this->faker->numberBetween(1, 999),
        ];
    }
}
