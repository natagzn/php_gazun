@extends('layouts.app')

@section('content')
    <h1>Edit Category</h1>

    <form action="{{ route('categories.update', $category->category_id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Category Name:</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>

    <!-- Відображення повідомлення про успішне оновлення -->
    @if(session('status'))
        <div class="alert alert-success mt-2">
            {{ session('status') }}
        </div>
    @endif
@endsection
<!--hello world-->