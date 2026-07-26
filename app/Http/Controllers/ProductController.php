<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->load(['category.ancestors', 'attributeValues.attribute', 'media']);

        return view('pages.product', [
            'product' => $product,
            'related' => Product::query()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->with('media')
                ->take(8)
                ->get(),
        ]);
    }
}
