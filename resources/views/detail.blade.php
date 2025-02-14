<x-app-layout>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h1 class="fw-bold text-dark">{{ $post->title }}</h1>

                <h5>
                    <span class="badge bg-success text-white px-3 py-2">{{ $post->category->name }}</span>
                </h5>

                <p class="text-muted">
                    📅 Published {{ $post->created_at->diffForHumans() }} | ✍️ By <strong>{{ $post->author->name
                        }}</strong>
                </p>

                <div class="text-center">
                    <img src="{{ asset('komputer.jpg') }}" class="img-fluid rounded shadow-sm mb-3" alt="Post Image"
                        style="max-height: 400px; object-fit: cover;">
                </div>

                <p class="text-dark" style="line-height: 1.8; font-size: 1.1rem;">
                    {{ $post->content }}
                </p>
            </div>


            <div class="col-md-4">
                <h3 class="text-success fw-bold">💬 Komentar</h3>
                <div class="comment-box p-3 bg-light rounded shadow-sm"
                    style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd;">
                    @forelse($post->comments as $comment)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <span class="badge bg-warning text-white">👤 {{ $comment->user->name }}</span>
                                </div>
                                <small class="text-muted">📅 {{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mt-2">{{ $comment->content }}</p>

                            @auth
                            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <div class="input-group">
                                    <input type="text" name="content" class="form-control"
                                        placeholder="✍️ Balas komentar..." required>
                                    <button class="btn btn-outline-success">Balas</button>
                                </div>
                            </form>
                            @endauth

                            @foreach($comment->replies as $reply)
                            <div class="card mt-2 ms-4 border-0 bg-light shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <span class="badge bg-secondary text-white">👤 {{ $reply->user->name
                                                }}</span>
                                        </div>
                                        <small class="text-muted">📅 {{ $reply->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mt-2">{{ $reply->content }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">Belum ada komentar. Jadilah yang pertama! 🚀</p>
                    @endforelse
                </div>

                <div class="m-3 p-3 border rounded bg-white shadow-sm">
                    @auth
                    <h5 class="fw-bold">✏️ Tambahkan Komentar</h5>
                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        <textarea name="content" class="form-control" rows="3" placeholder="Tulis komentar Anda..."
                            required></textarea>
                        <button type="submit" class="btn btn-success mt-2">💬 Kirim</button>
                    </form>
                    @else
                    <p><a href="{{ route('login') }}" class="text-decoration-none text-primary">🔐 Login</a> untuk
                        memberi komentar.</p>
                    @endauth
                </div>
            </div>


        </div>

    </div>


</x-app-layout>