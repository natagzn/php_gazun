<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('likes', function (Blueprint $table) {
        $table->increments('like_id');
        $table->integer('post_id')->unsigned();
        $table->integer('user_id')->unsigned();
        $table->datetime('created_at');
        
        // Зв'язки
        $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
