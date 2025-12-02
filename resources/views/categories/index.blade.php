@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="display-4 fw-bold mb-2">Categories</h1>
                <p class="text-muted">Organize your blog posts</p>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-success btn-lg shadow-sm">
                <i class="bi bi-folder-plus me-2"></i>Add Category
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Categories Grid -->
        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-lift">
                        <div class="card-body p-4">
                            <!-- Icon & Post Count -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="category-icon bg-success bg-opacity-10 p-3 rounded-3">
                                    <i class="bi bi-folder-fill text-success" style="font-size: 2rem;"></i>
                                </div>
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    {{ $category->blogPosts->count() }} posts
                                </span>
                            </div>

                            <!-- Category Name -->
                            <h5 class="card-title fw-bold mb-2">{{ $category->name }}</h5>

                            <!-- Slug -->
                            <p class="text-muted small mb-3">
                                <code class="bg-light px-2 py-1 rounded">{{ $category->slug }}</code>
                            </p>

                            <!-- Description -->
                            @if ($category->description)
                                <p class="card-text text-secondary mb-4">
                                    {{ Str::limit($category->description, 100) }}
                                </p>
                            @else
                                <p class="card-text text-muted fst-italic mb-4">No description</p>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex mt-auto">
                                <a href="{{ route('categories.edit', $category) }}"
                                    class="btn btn-warning btn-sm flex-grow-1 me-2">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="m-0"
                                    onsubmit="return confirm('Delete this category? Posts will not be deleted.')">
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
                        <i class="bi bi-folder-x" style="font-size: 5rem; color: #dee2e6;"></i>
                        <h3 class="mt-4 text-muted">No categories yet</h3>
                        <p class="text-muted">Create your first category to organize posts</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-success mt-3">
                            <i class="bi bi-folder-plus me-2"></i>Create First Category
                        </a>
                    </div>
                </div>
            @endforelse
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
        }

        .category-icon {
            transition: transform 0.3s ease;
        }

        .card:hover .category-icon {
            transform: scale(1.1);
        }
    </style>
@endsection
