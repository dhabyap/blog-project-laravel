<x-app-layout>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success fw-bold">📌 Dashboard Blog</h2>
            <a href="{{ route('dashboard.create') }}" class="btn btn-primary">
                ✍️ Buat Post Baru
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">📝 Daftar Postingan Anda</h5>
            </div>
            <div class="card-body">
                @if($posts->isEmpty())
                <div class="alert alert-warning text-center">
                    Belum ada postingan. Yuk, buat yang pertama! 😊
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr class="align-middle">
                                <th class="bg-success text-white">📖 Judul</th>
                                <th class="bg-success text-white">📂 Kategori</th>
                                <th class="bg-success text-white">⚙️ Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <td class="align-middle">{{ $post->title }}</td>
                                <td class="align-middle text-center">
                                    <span class="badge bg-warning text-dark">{{ $post->category->name }}</span>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('dashboard.show', encrypt($post->id)) }}"
                                        class="btn btn-info btn-sm">
                                        👁️ Lihat
                                    </a>
                                    <a href="{{ route('dashboard.edit', encrypt($post->id)) }}"
                                        class="btn btn-warning btn-sm">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('dashboard.destroy', encrypt($post->id)) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>