<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         // Валідація запиту
    $request->validate([
        'title' => 'required|string|max:150',
        'description' => 'required|string', // Додайте це
        'content' => 'required|string',
        'category_id' => 'required|exists:categories,category_id',
    ]);

    // Створення поста
    Post::create([
        'title' => $request->title,
        'description' => $request->description, // Додайте це
        'content' => $request->content,
        'category_id' => $request->category_id,
        'user_id' => '1', // Встановлюємо ID адміна як автора поста
    ]);

    return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $post_id)
    {
        $post = Post::with(['comments.user', 'likes.user'])->findOrFail($post_id);
        $users = User::all();

        return view('posts.show', compact('post', 'users'));

        // Отримуємо пост за його ID
        //$post = Post::findOrFail($post_id);
    
        // Передаємо пост до вигляду
        //return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $post_id)
    {
        $post = Post::findOrFail($post_id); // Отримуємо пост з бази даних
        // Отримуємо всі категорії для селектора
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $post_id)
    {
        // Валідація вхідних даних
    $request->validate([
        'title' => 'required|string|max:150',
        'description' => 'required|string',
        'content' => 'required|string',
        'category_id' => 'required|exists:categories,category_id',
    ]);

    // Знаходження поста
    $post = Post::findOrFail($post_id);

    // Оновлення поста
    $post->update([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'content' => $request->input('content'),
        'category_id' => $request->input('category_id'),
    ]);

    return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $post_id)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }



    public function likePost(Request $request, $postId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
        ]);

        Like::create([
            'post_id' => $postId,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('posts.show', $postId);
    }

    // Метод для видалення лайку
    public function unlikePost($postId)
    {
        $like = Like::where('post_id', $postId)
                    ->where('user_id', auth()->id())
                    ->first();

        if ($like) {
            $like->delete();
        }

        return redirect()->route('posts.show', $postId);
    }

    // Метод для створення коментаря
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'content' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $postId,
            'user_id' => $request->user_id,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $postId);
    }

    // Метод для видалення коментаря
    public function destroyComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return redirect()->back();
    }
}
