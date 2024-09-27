@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">Create New Post</a>

    <ul class="list-group">
        @foreach ($posts as $post)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('posts.show', $post->post_id) }}">{{ $post->title }}</a>
                <span>
                    <!-- Кнопка для редагування поста -->
                    <a href="{{ route('posts.edit', $post->post_id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <!-- Форма для видалення поста -->
                    <form action="{{ route('posts.destroy', $post->post_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </span>
            </li>
        @endforeach
    </ul>
@endsection
