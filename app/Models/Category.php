<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false; // Вимкнення відстеження часу, якщо не потрібні timestamps
    protected $fillable = ['name', 'description'];

    // Вказуємо, що первинний ключ - це 'category_id'
    protected $primaryKey = 'category_id';
}
