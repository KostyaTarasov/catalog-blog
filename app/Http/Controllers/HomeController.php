<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('pages.home', [
            'products' => Product::query()->with('media')->latest()->take(8)->get(),
            'categories' => Category::cachedRoots(),
            'posts' => Post::query()->published()->with('media')->latest('published_at')->take(6)->get(),
        ]);
    }
}
