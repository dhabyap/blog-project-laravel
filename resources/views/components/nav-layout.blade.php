<div class="sidebar d-flex flex-column justify-content-between">
    <div class="text-center py-4 w-100">
        <h2 class="fw-bold text-uppercase fs-5">Dhaby's Blog</h2>
        <img src="{{ asset('profile.png') }}" class="rounded-circle border border-light mb-3" width="80" alt="Profile">
        <p class="text-white-50 px-2">Hi, my name is Dhaby Anggika Putra. I'am a Web Developer.</p>

        <br>

        @auth
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        @endauth

        @guest
        <a href="{{ route('login') }}" class="btn btn-success border-1 border-black shadow-md">Login</a>
        @endguest

    </div>

    <ul class="nav flex-column text-center w-100">
        <li class="nav-item">
            <a class="nav-link text-white py-2 active sidebar-link" href="/">
                <i class="fas fa-home me-2"></i> Blog Home
            </a>
        </li>

        @auth
        <li class="nav-item">
            <a class="nav-link text-white py-2 sidebar-link" href="{{ route('dashboard.index') }}">
                <i class="fas fa-bookmark me-2"></i> Dashboard
            </a>
        </li>
        @endauth

    </ul>

    <footer class="text-center text-white py-3">
        <small>© 2025 Dhaby's Blog</small>
    </footer>

</div>