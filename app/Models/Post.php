<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $primaryKey = 'post_id';


    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'description',
        'image',
    ];


    
    public function likes()
{
    return $this->hasMany(Like::class, 'post_id', 'post_id');
}

public function comments()
{
    return $this->hasMany(Comment::class, 'post_id', 'post_id');
}

}
