@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="mb-5">
                    <h1 class="display-5 fw-bold mb-2">Edit Category</h1>
                    <p class="text-muted">Update category information</p>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('categories.update', $category) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Category Name -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-folder-fill me-2 text-success"></i>Category Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                    class="form-control form-control-lg" required>
                                <small class="text-muted">Current slug: <code>{{ $category->slug }}</code></small>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-text-paragraph me-2 text-success"></i>Description
                                </label>
                                <textarea name="description" rows="5" class="form-control">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <!-- Stats Info -->
                            <div class="alert alert-light border mb-5">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-bar-chart-fill text-success me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>{{ $category->blogPosts->count() }}</strong> blog posts
                                        are currently using this category
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 pt-3 border-top">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="bi bi-check-circle me-2"></i>Update Category
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Section -->
                <div class="card border-danger mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                        </h5>
                        <p class="card-text text-muted mb-3">
                            Delete this category. Blog posts will <strong>not</strong> be deleted,
                            but they will no longer be associated with this category.
                        </p>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
        }

        .form-control:focus,
        .form-control-lg:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
        }

        .form-label {
            color: #495057;
            margin-bottom: 0.5rem;
        }
    </style>
@endsection
