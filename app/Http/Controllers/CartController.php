<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Http\Resources\CartResource;
use App\Http\Requests\AddToCartRequest;

class CartController extends Controller
{
    /**
     * Return cart items associated with user or session
     *
     * @return void
     */
    public function index()
    {
        return CartResource::collection(Cart::havingUserOrSession()->with('product')->get());
    }

    /**
     * Update quantity for a product in cart
     *
     * @param Cart $cart
     * @return void
     */
    public function update(Cart $cart)
    {
        //Validate Quantity
        request()->validate(['qty' => 'required|integer']);

        //Delete cart if quantity is 0
        if (request()->qty == 0) {
            return $this->destroy($cart);
        }

        //Update cart
        $cart->update([
            'qty' => request()->qty
        ]);

        return $cart;
    }

    /**
     * Add product to cart
     *
     * @param Product $product
     * @param AddToCartRequest $request
     * @return mixed
     */
    public function store(Product $product, AddToCartRequest $request)
    {
        if ($request->qty > 0) {
            return Cart::create([
                'session_id'           => request()->header('SessionId'),
                'user_id'              => auth()->id(),
                'qty'                  => $request->qty,
                'product_id'           => $product->id,
            ]);
        }

        return response()->json(['errors' => ['qty' => 'Quantity needs to greater than 0']], 422);
    }

    /**
     * Delete a cart item
     *
     * @param Cart $cart
     * @return int
     */
    public function destroy(Cart $cart)
    {
        return $cart->delete();
    }

    /**
     * Assign same session cart products to user post login
     *
     * @return boolean
     */
    public static function associateSessionCartWithUser()
    {
        //Check if session exists
        if (request()->header('SessionId') != null) {
            //Update cart to user
            Cart::havingSession(request()->header('SessionId'))->update([
                'user_id' => auth()->id()
            ]);
        }
        return true;
    }
}
