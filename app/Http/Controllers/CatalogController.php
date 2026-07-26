<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CatalogController extends Controller
{
    public function index()
    {
        return view('pages.catalog', [
            'categories' => Category::cachedRoots(),
        ]);
    }

    public function category(Category $category)
    {
        return view('pages.category', ['category' => $category]);
    }
}
