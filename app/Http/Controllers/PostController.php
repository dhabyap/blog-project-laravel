<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $sortOrder = $request->query('sort', 'desc');

        $author = $request->query('author');
        $categorySlug = $request->query('category');

        $postQuery = Post::with('author', 'category')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', $sortOrder);

        if ($categorySlug) {
            $postQuery->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($author) {
            $postQuery->whereHas('author', function ($q) use ($author) {
                $q->where('id', $author);
            });
        }

        $posts = $postQuery->paginate(6);

        return view('home', compact('posts', 'sortOrder', 'query', 'categorySlug', 'author'));
    }


    public function filterByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::where('category_id', $category->id)->orderBy('created_at', 'desc')->paginate(9);

        return view('home', compact('posts', 'category'));
    }


    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('detail', compact('post'));
    }

    

}
