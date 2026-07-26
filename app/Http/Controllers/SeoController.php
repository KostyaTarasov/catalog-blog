<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $xml = cache()->remember('sitemap', now()->addHour(), function () {
            $urls = collect([
                ['loc' => route('home')],
                ['loc' => route('catalog')],
                ['loc' => route('blog')],
            ])
                ->merge(Category::query()->get(['slug', 'updated_at'])
                    ->map(fn (Category $c) => ['loc' => route('category', $c), 'lastmod' => $c->updated_at]))
                ->merge(Product::query()->get(['slug', 'updated_at'])
                    ->map(fn (Product $p) => ['loc' => route('product', $p), 'lastmod' => $p->updated_at]))
                ->merge(Post::query()->published()->get(['slug', 'updated_at'])
                    ->map(fn (Post $p) => ['loc' => route('post', $p), 'lastmod' => $p->updated_at]));

            return '<?xml version="1.0" encoding="UTF-8"?>'."\n".view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots(): Response
    {
        return response(implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
        ]), 200, ['Content-Type' => 'text/plain']);
    }
}
