<?php
/**
 * Created by PhpStorm.
 * User: VOVANCHO
 * Date: 01.05.2018
 * Time: 16:01
 */

namespace App\Services;


use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductService
{
    public function all()
    {
        return Product::paginate();
    }

    public function create(ProductRequest $request)
    {
        Product::create($request->only(['name', 'price']));
    }

    public function edit(Product $product, ProductRequest $request)
    {
        $product->update($request->only(['name', 'price']));
    }

    public function remove(Product $product)
    {
        $product->delete();
    }
}