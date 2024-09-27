<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'comment_id';  // Замість 'id'

    protected $table = 'comments';

    protected $fillable = ['post_id', 'user_id', 'content'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
{
    return $this->hasMany(Like::class, 'post_id');
}

public function comments()
{
    return $this->hasMany(Comment::class, 'post_id');
}
}
