<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h1>{{ $post->title }}</h1>
                <p class="text-muted">Published {{ $post->created_at->diffForHumans() }} | By {{ $post->author->name }}
                </p>
                <img src="{{ asset('komputer.jpg') }}" class="img-fluid mb-3" alt="Post Image">
                <p>{{ $post->content }}</p>
                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

</x-app-layout>