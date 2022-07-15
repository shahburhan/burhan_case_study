<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Resources\ProductResource;
use App\Http\Requests\CreateProductRequest;

class ProductController extends Controller
{
    /**
     * Get list of products
     *
     * @return Collection
     */
    public function index()
    {
        return ProductResource::collection(Product::with(['category', 'user'])->paginate(100));
    }

    /**
     * Get a single product
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Create a new Product
     *
     * @param CreateProductRequest $request
     * @return Product
     */
    public function store(CreateProductRequest $request)
    {
        return Product::create([
            'name'         => $request->name,
            'user_id'      => auth()->id(),
            'category_id'  => $this->getCategory($request->category)->id,
            'description'  => $request->description,
            'price'        => $request->price,
            'avatar'       => $this->saveAvatar(),
        ]);
    }

    /**
     * Delete a product
     *
     * @param Product $product
     * @return boolean
     */
    public function destroy(Product $product)
    {
        return $product->delete();
    }

    /**
     * Get or create a category
     *
     * @param string $category
     * @return Category
     */
    public function getCategory($category)
    {
        return Category::firstOrCreate([
            'name' => $category
        ]);
    }

    /**
     * Save Uploaded avatar
     *
     * @return string
     */
    public function saveAvatar()
    {
        if (request()->file('avatar') !== null) {
            //Generate a file name
            $as = md5(time() . request()->file('avatar')->getClientOriginalName()) . '.' . request()->file('avatar')->getClientOriginalExtension();

            request()->file('avatar')->storeAs('avatars', $as);

            //return file name for association
            return $as;
        }

        return null;
    }
}
