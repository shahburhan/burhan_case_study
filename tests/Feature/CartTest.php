<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;

class CartTest extends TestCase
{
    /**
     * A session or user is available
     *
     * @return void
     */
    public function test_a_session_or_user_is_available()
    {
        $response = $this->getJson('api/cart');

        $response->assertStatus(401);
        $response->assertExactJson([
            'message' => 'A session or login is required'
        ]);
    }

    /**
     * Product can be added to cart
     *
     * @return void
     */
    public function test_a_product_can_be_added_to_cart()
    {
        $response = $this->postJson('api/cart/' . Product::first()->id, [
            'qty'        => 1
        ], headers: [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'product_id', 'user_id', 'session_id'
        ]);
    }

    /**
     * Quantity is required to add a product
     *
     * @return void
     */
    public function test_a_product_cannot_be_added_to_cart_without_quantity()
    {
        $response = $this->postJson('api/cart/' . Product::first()->id, headers: [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'qty'
        ]);
    }

    /**
     * Product can be deleted from cart
     * @depends test_a_product_can_be_added_to_cart
     * @return void
     */
    public function test_a_product_can_be_deleted_from_cart()
    {
        $cart = Cart::create([
            'product_id' => Product::first()->id,
            'user_id'    => User::first()->id,
            'qty'        => 1,
        ]);

        $response = $this->deleteJson('api/cart/' . $cart->id, headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
        $response->assertSee(1);
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    /**
     * Products from cart can be retrived
     * @depends test_a_product_can_be_added_to_cart
     * @return void
     */
    public function test_products_in_cart_can_be_retrieved()
    {
        $response = $this->getJson('api/cart', headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'quantity',
                    'product'
                ]
            ]
        ]);
    }

    /**
     * Products in cart can be updated
     * @depends test_products_in_cart_can_be_retrieved
     * @return void
     */
    public function test_a_product_can_be_updated_in_cart()
    {
        $cart     = Cart::first();
        $response = $this->putJson('api/cart/' . $cart->id, ['qty' => $cart->qty + 1], headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);

        $this->assertEquals($cart->qty + 1, $response['qty']);
    }

    /**
     * Supplying 0 as quantity removes product from cart on update
     *
     * @return void
     */
    public function test_zero_quantity_removes_product_from_cart_on_update()
    {
        $cart     = Cart::first();
        $response = $this->putJson('api/cart/' . $cart->id, ['qty' => 0], headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    /**
     * Supplying 0 as quantity does not add a product to cart
     *
     * @return void
     */
    public function test_adding_zero_quantity_does_not_add_product_to_cart()
    {
        $response = $this->postJson('api/cart/' . Product::first()->id, ['qty' => 0], headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'qty'
        ]);
    }

    /**
     * Quantity is always an integer
     *
     * @return void
     */
    public function test_quantity_is_always_an_integer()
    {
        $response = $this->postJson('api/cart/' . Product::first()->id, ['qty' => 1.5], headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'qty'
        ]);
    }

    /**
     * Added product is valid
     *
     * @return void
     */
    public function test_a_valid_product_is_being_added_to_cart()
    {
        $response = $this->postJson('api/cart/invalid-product', ['qty' => 1], headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(404);
        $response->assertExactJson([
            'message' => 'Resource not found'
        ]);
    }

    /**
     * A valid cart is supplied
     *
     * @return voidgetJson
     */
    public function test_a_valid_cart_is_supplied()
    {
        $response = $this->putJson('api/cart/invalid-cart', ['qty' => 1], headers:[
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(404);
        $response->assertExactJson([
            'message' => 'Resource not found'
        ]);
    }

    /**
     * Cart works with a session
     *
     * @return voidgetJson
     */
    public function test_adding_to_cart_works_with_a_session()
    {
        $response = $this->postJson('api/cart/' . Product::first()->id, [
            'qty'        => 1
        ], headers: [
            'SessionId' => $this->getToken()
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'product_id', 'user_id', 'session_id'
        ]);
    }

    /**
     * Cart retreival works with a session
     *
     * @return voidgetJson
     */
    public function test_retrieving_from_cart_works_with_a_session()
    {
        $response = $this->getJson('api/cart', headers: [
            'SessionId' => $this->getToken()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['product', 'quantity']
            ]
        ]);
    }

    public function getToken()
    {
        return User::first()->createToken('test')->plainTextToken;
    }
}
