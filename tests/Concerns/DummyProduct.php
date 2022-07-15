<?php

namespace Tests\Concerns;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;

trait DummyProduct
{
    use WithFaker;

    /**
     * Create a dummy product
     *
     * @return Product
     */
    public function createDummyProduct()
    {
        $category = Category::create([
            'name' => $this->faker()->safeColorName()
        ]);
        $user = User::create([
            'name'     => $this->faker()->name(),
            'email'    => $this->faker()->email(),
            'password' => $this->faker()->password()
        ]);

        $product = Product::create([
            'name'        => $this->faker()->text(20),
            'user_id'     => $user->id,
            'category_id' => $category->id,
            'description' => $this->faker()->realText(),
            'price'       => $this->faker()->numberBetween(1, 999),
        ]);

        return $product;
    }
}