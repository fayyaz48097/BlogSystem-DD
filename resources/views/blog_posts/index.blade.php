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
                                <span class="badge bg-success bg-opacity-20  small mb-2">
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

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
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
    </style>
@endsection
