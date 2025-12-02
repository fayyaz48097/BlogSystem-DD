<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('blog-posts.index') }}">
            <i class="bi bi-journal-text me-2"></i>My Blog
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog-posts.*') ? 'active' : '' }}"
                        href="{{ route('blog-posts.index') }}">
                        <i class="bi bi-file-post me-1"></i>Blog Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">
                        <i class="bi bi-folder me-1"></i>Categories
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
