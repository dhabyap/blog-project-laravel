<x-app-layout>
    <header
        class="hero-section text-white text-center d-flex align-items-center justify-content-center position-relative"
        style="height: 50vh; overflow: hidden;">

        <div class="hero-bg position-absolute top-0 start-0 w-100 h-100" style="background: url('{{ asset('tech.jpg') }}') no-repeat center center/cover;
               filter: blur(5px) brightness(60%);
               z-index: -1;">
        </div>

        <div class="container position-relative fade-in">
            <h1 class="display-3 fw-bold text-uppercase">
                Welcome to <span class="text-warning">My</span> Website
            </h1>
            <p class="lead mt-3">Discover amazing content and <span class="text-warning">experiences.</span></p>
            <a href="#search-section" class="btn btn-warning btn-lg mt-3 fw-bold shadow-sm">Explore Now ⬇</a>
        </div>
    </header>

    <section id="search-section" class="cta-section bg-light py-5 text-center">
        <div class="container">
            <h2 class="fw-bold text-success">Dhaby Blog Website</h2>
            <p class="lead text-muted">Find the latest blog posts by searching below.</p>

            <!-- Search Form -->
            <div class="pt-3 mx-auto" style="max-width: 500px;">
                <form class="row g-2 align-items-center" action="{{ route('posts.index') }}" method="GET">
                    @if(isset($category))
                    <input type="hidden" name="category" value="{{ $category->slug }}">
                    @endif
                    <div class="col-md-9">
                        <input type="text" id="search" name="search" class="form-control rounded-pill shadow-sm px-3"
                            placeholder="Search posts..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold shadow-sm">
                            🔍 Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>



    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="fw-bold text-success text-uppercase">
                @if(isset($categorySlug))
                LIST CATEGORY - {{ strtoupper($categorySlug) }}
                @if(request('home'))
                (SEARCH RESULTS FOR "{{ request('search') }}")
                @endif
                @elseif(request('search'))
                SEARCH RESULTS FOR "{{ request('search') }}"
                @elseif(request('author'))
                POSTS BY {{ \App\Models\User::find(request('author'))->name ?? 'Unknown Author' }}
                @else
                LIST BLOG
                @endif
            </h2>

            @if(isset($categorySlug) || request('search') || request('author'))
            <a href="{{ route('home') }}" class="btn btn-outline-success btn-sm">🏠 Back to Home</a>
            @endif
        </div>

        <form method="GET" action="{{ route('posts.index') }}" class="d-flex justify-content-end mb-4">
            @if(isset($categorySlug))
            <input type="hidden" name="category" value="{{ $categorySlug }}">
            @endif
            @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if(request('author'))
            <input type="hidden" name="author" value="{{ request('author') }}">
            @endif
            <select name="sort" class="form-select w-auto" onchange="this.form.submit()">
                <option value="desc" {{ request('sort', 'desc' )=='desc' ? 'selected' : '' }}>Newest First</option>
                <option value="asc" {{ request('sort')=='asc' ? 'selected' : '' }}>Oldest First</option>
            </select>
        </form>

        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded overflow-hidden">
                    <img src="{{ asset('komputer.jpg') }}" class="card-img-top" alt="Blog Post"
                        style="height: 200px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <a href="{{ route('posts.show', $post->slug) }}"
                                class="text-decoration-none text-success fw-bold">
                                {{ $post->title }}
                            </a>
                        </h5>

                        <p class="mb-1">
                            <a href="{{ route('posts.index', $post->category->slug) }}"
                                class="badge bg-warning text-white text-decoration-none">
                                {{ strtoupper($post->category->name) }}
                            </a>
                        </p>

                        <p class="text-muted small">
                            📅 {{ $post->created_at->diffForHumans() }} | ✍️ By
                            <a href="{{ route('posts.index', ['author' => $post->author->id]) }}" class="text-primary">
                                {{ $post->author->name }}
                            </a>
                        </p>

                        <p class="card-text small text-secondary">
                            {{ Str::limit($post->content, 80) }}
                        </p>

                        <a href="{{ route('posts.show', $post->slug) }}"
                            class="btn btn-outline-success btn-sm mt-auto fw-bold">
                            Read more &rarr;
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $posts->appends(['sort' => request('sort'), 'search' => request('search'), 'category' =>
            request('category'), 'author' => request('author')])->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pagination .page-link:hover {
            background-color: #28a745;
            color: #fff;
        }

        .pagination .active .page-link {
            background-color: #28a745;
            border-color: #28a745;
        }

        .latest-blog-title {
            font-size: 28px;
            font-weight: bold;
            color: #198754;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .latest-blog-title::after {
            content: "";
            width: 60px;
            height: 3px;
            background-color: #198754;
            display: block;
            margin: 8px auto 0;
            border-radius: 2px;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        .card-img-top:hover {
            opacity: 0.85;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-text {
            flex-grow: 1;
        }

        .btn-outline-success {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-success:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 10px;
            color: #ffc107 !important;
        }
    </style>

</x-app-layout>