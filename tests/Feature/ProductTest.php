<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductTest extends TestCase
{
    use WithFaker;

    /**
     * Test a product data is validated
     *
     * @return void
     */
    public function test_all_required_product_data_is_validated()
    {
        $response = $this->postJson('api/products', [
        ], [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'category', 'name', 'price', 'description'
        ]);
    }

    /**
     * Test a product can be created
     *
     * @return void
     */
    public function test_a_product_can_be_created()
    {
        Storage::fake('local');

        $file     = UploadedFile::fake()->create('test.jpg');

        $response = $this->postJson('api/products', [
            'name'         => $this->faker()->text(20),
            'category'     => 'Some category',
            'description'  => $this->faker()->realText(),
            'price'        => $this->faker()->numberBetween(1, 999),
            'avatar'       => $file,
        ], [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertCreated();

        //Assert file was stored
        Storage::disk('local')->assertExists('avatars/' . $response['avatar']);

        $response->assertJsonStructure([
            'id', 'name', 'price', 'description'
        ]);
    }

    /**
     * Test only an image is accepted as avatar
     *
     * @return void
     */
    public function test_only_an_image_is_accepted_as_avatar()
    {
        Storage::fake('local');

        $file     = UploadedFile::fake()->create('test.pdf');

        $response = $this->postJson('api/products', [
            'name'         => $this->faker()->text(20),
            'category'     => 'Some category',
            'description'  => $this->faker()->realText(),
            'price'        => $this->faker()->numberBetween(1, 999),
            'avatar'       => $file,
        ], [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'avatar'
        ]);
    }

    /**
     * Test price is numeric
     *
     * @return void
     */
    public function test_product_price_is_a_valid_number()
    {
        $response = $this->postJson('api/products', [
            'name'        => $this->faker()->text(20),
            'category'    => 'Some category',
            'description' => $this->faker()->realText(),
            'price'       => 'abc',
        ], [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'price'
        ]);
    }

    /**
     * Test a product can be deleted
     *
     * @return void
     */
    public function test_a_product_can_be_deleted()
    {
        $product  = $this->createDummyProduct();

        $response = $this->deleteJson('api/product/' . $product->id, headers : [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
        $response->assertSee(1);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /**
     * Test a product can be retrieved
     *
     * @return void
     */
    public function test_a_product_can_be_retreived()
    {
        $product = $this->createDummyProduct();

        $response = $this->postJson('api/product/' . $product->id, headers :[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test a collection of products can be retreived
     *
     * @return void
     */
    public function test_a_collection_of_products_can_be_retreived()
    {
        $response = $this->getJson('api/products', headers :[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test an invalid product results in not found
     *
     * @return void
     */
    public function test_an_invalid_product_is_not_found()
    {
        $response = $this->postJson('api/product/invalid-id', headers :[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(404);
        $response->assertExactJson([
            'message' => 'Resource not found'
        ]);
    }

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

    public function getToken()
    {
        return User::first()->createToken('test')->plainTextToken;
    }
}
