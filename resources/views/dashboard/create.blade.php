<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="text-center fw-bold text-success">Buat Post Baru</h2>
                        <hr>

                        <form action="{{ route('dashboard.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">
                                    <i class="fas fa-heading me-1"></i> Judul
                                </label>
                                <input type="text" name="title" id="title"
                                    class="form-control rounded-pill shadow-sm px-3"
                                    placeholder="Masukkan judul post..." required>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-semibold">
                                    <i class="fas fa-folder me-1"></i> Kategori
                                </label>
                                <select name="category_id" id="category_id" class="form-select rounded-pill shadow-sm"
                                    required>
                                    <option value="" selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold">
                                    <i class="fas fa-edit me-1"></i> Konten
                                </label>
                                <textarea name="content" id="content" class="form-control shadow-sm px-3" rows="5"
                                    placeholder="Tulis isi post di sini..." required></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success rounded-pill fw-bold px-4 shadow-sm">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</x-app-layout>