<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        return view('pages.blog', [
            'posts' => Post::query()->published()->with('media')->latest('published_at')->paginate(12),
        ]);
    }

    public function show(Post $post)
    {
        abort_unless($post->published_at?->isPast(), 404);

        return view('pages.post', ['post' => $post->load('tags', 'media')]);
    }
}
