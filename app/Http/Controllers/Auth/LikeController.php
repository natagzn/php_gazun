<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    /*public function store(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id' => $request->user_id,
        ]);

        return redirect()->back();
    }

    public function destroy(Like $like)
    {
        $like->delete();
        return redirect()->back();
    }*/



    public function toggleLike(Request $request, Post $post)
    {
        $user_id = $request->user_id;

        // Перевіряємо, чи користувач вже лайкнув цей пост
        $like = Like::where('post_id', $post->post_id)
            ->where('user_id', $user_id)
            ->first();

        if ($like) {
            // Якщо лайк вже існує, видаляємо його
            $like->delete();
            return redirect()->back()->with('status', 'Like removed');
        } else {
            // Якщо лайка немає, створюємо новий лайк
            Like::create([
                'post_id' => $post->post_id,
                'user_id' => $user_id,
            ]);
            return redirect()->back()->with('status', 'Like added');
        }
    }
}
