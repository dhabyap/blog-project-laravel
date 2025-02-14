<x-app-layout>
    <div class="container mt-4">
        <h2>Edit Post</h2>
        <form action="{{ route('dashboard.update', encrypt($post->id)) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
            </div>
            <div class="mb-3">
                <label>Konten</label>
                <textarea name="content" class="form-control" rows="4" required>{{ $post->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</x-app-layout>