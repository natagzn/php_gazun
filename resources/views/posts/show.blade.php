@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    <!-- Відображення кількості лайків -->
    <p class="lead">Likes: <strong>{{ $post->likes->count() }}</strong></p>

    <!-- Випадаючий список для вибору користувача -->
    <form action="{{ route('posts.toggleLike', $post->post_id) }}" method="POST" class="mb-3">
        @csrf
        <div class="input-group mb-2">
            <select name="user_id" class="form-select" required>
                <option value="" disabled selected>Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->user_id }}">{{ $user->username }}</option>
                @endforeach
            </select>

            <!-- Перевірка, чи користувач вже лайкнув пост -->
            @php
                $userLiked = $post->likes->contains('user_id', old('user_id'));
            @endphp

            <!-- Кнопка для лайку/унлайку -->
            <button type="submit" class="btn btn-primary">
                {{ $userLiked ? 'Unlike' : 'Like' }}
            </button>
        </div>
    </form>

    <!-- Коментарі -->
    <h3>Comments</h3>
    @foreach($post->comments as $comment)
        <div class="alert alert-info">
            <strong>{{ $comment->user->username }}:</strong> {{ $comment->content }}
            <form action="{{ route('comments.destroy', $comment->comment_id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete Comment</button>
            </form>
        </div>
    @endforeach

    <!-- Додавання нового коментаря -->
    <form action="{{ route('comments.store', $post->post_id) }}" method="POST" class="mt-4">
        @csrf
        <div class="input-group mb-3">
            <select name="user_id" class="form-select" required>
                <option value="" disabled selected>Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->user_id }}">{{ $user->username }}</option>
                @endforeach
            </select>
            <textarea name="content" class="form-control" placeholder="Enter your comment" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Comment</button>
    </form>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
</div>
@endsection
