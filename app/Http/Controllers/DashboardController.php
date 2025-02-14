<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->get();

        $posts->transform(function ($post) {
            $post->encrypted_id = encrypt($post->id);
            return $post;
        });

        return view('dashboard.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
        ]);

        Post::create([
            'title' => $request->title,
            'slug' => Post::generateSlug($request->title),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Post berhasil dibuat!');
    }

    public function show($encryptedId)
    {
        $id = decrypt($encryptedId);
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dashboard.show', compact('post'));
    }

    public function edit($encryptedId)
    {
        $id = decrypt($encryptedId);
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dashboard.edit', compact('post'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($encryptedId)
    {
        $id = decrypt($encryptedId);
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->route('dashboard.index')->with('success', 'Post deleted successfully.');
    }
}
