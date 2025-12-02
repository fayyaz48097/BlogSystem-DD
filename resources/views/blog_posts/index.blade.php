@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="display-4 fw-bold mb-2">Blog Posts</h1>
                <p class="text-muted">Share your thoughts with the world</p>
            </div>
            <a href="{{ route('blog-posts.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="bi bi-plus-circle me-2"></i>Create New Post
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Results Info -->
        @if ($posts->total() > 0)
            <div class="mb-4">
                <p class="text-muted">
                    Showing <strong>{{ $posts->firstItem() }}</strong> to <strong>{{ $posts->lastItem() }}</strong>
                    of <strong>{{ $posts->total() }}</strong> posts
                </p>
            </div>
        @endif

        <!-- Blog Cards Grid -->
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-lift">
                        <!-- Image -->
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top"
                                alt="{{ $post->main_title }}" style="height: 250px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center"
                                style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-image text-white" style="font-size: 4rem; opacity: 0.5;"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <!-- Title -->
                            <h5 class="card-title fw-bold mb-2">{{ Str::limit($post->main_title, 60) }}</h5>

                            @if ($post->secondary_title)
                                <p class="card-text text-muted small mb-3">{{ Str::limit($post->secondary_title, 80) }}</p>
                            @endif
                            @if ($post->category)
                                <span class="badge bg-success bg-opacity-20 small mb-2">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            <!-- Content Preview -->
                            <p class="card-text text-secondary mb-3 flex-grow-1">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <!-- Hashtags -->
                            @if ($post->hashtags_string)
                                <div class="mb-3">
                                    @foreach (explode(',', $post->hashtags_string) as $tag)
                                        <span class="badge bg-light text-primary me-1 mb-1">#{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex mt-auto">
                                <a href="{{ route('blog-posts.show', $post) }}"
                                    class="btn btn-primary btn-sm flex-grow-1 me-2">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                                <a href="{{ route('blog-posts.edit', $post) }}"
                                    class="btn btn-outline-warning btn-sm me-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('blog-posts.destroy', $post) }}" method="POST" class="m-0"
                                    onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 5rem; color: #dee2e6;"></i>
                        <h3 class="mt-4 text-muted">No posts yet</h3>
                        <p class="text-muted">Start creating your first blog post!</p>
                        <a href="{{ route('blog-posts.create') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-circle me-2"></i>Create Your First Post
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Enhanced Pagination -->
        @if ($posts->hasPages())
            <div class="mt-5">
                <nav aria-label="Blog posts pagination">
                    <ul class="pagination pagination-modern justify-content-center">
                        {{-- Previous Button --}}
                        @if ($posts->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                            @if ($page == $posts->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($posts->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>

                {{-- Page Info --}}
                <div class="text-center mt-3">
                    <small class="text-muted">
                        Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}
                    </small>
                </div>
            </div>
        @endif
    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-img-top {
            border-radius: 0;
        }

        /* Enhanced Pagination Styles */
        .pagination-modern {
            gap: 8px;
        }

        .pagination-modern .page-link {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            color: #495057;
            font-weight: 500;
            padding: 10px 16px;
            transition: all 0.3s ease;
            min-width: 45px;
            text-align: center;
        }

        .pagination-modern .page-link:hover {
            background-color: #f8f9fa;
            border-color: #0d6efd;
            color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.15);
        }

        .pagination-modern .page-item.active .page-link {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            transform: scale(1.05);
        }

        .pagination-modern .page-item.disabled .page-link {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
        }

        .pagination-modern .page-link i {
            font-size: 0.9rem;
            vertical-align: middle;
        }

        /* Smooth scroll to top on page change */
        @media (prefers-reduced-motion: no-preference) {
            html {
                scroll-behavior: smooth;
            }
        }
    </style>
@endsection
