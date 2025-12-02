@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="mb-5">
                    <h1 class="display-5 fw-bold mb-2">Create New Post</h1>
                    <p class="text-muted">Share your story with the world</p>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('blog-posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Main Title -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-type-h1 me-2 text-primary"></i>Main Title
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="main_title" class="form-control form-control-lg"
                                    placeholder="Enter an engaging title..." required>
                            </div>

                            <!-- Secondary Title -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-type-h2 me-2 text-primary"></i>Secondary Title
                                </label>
                                <input type="text" name="secondary_title" class="form-control"
                                    placeholder="Optional subtitle or description">
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-image me-2 text-primary"></i>Featured Image
                                </label>
                                <div class="input-group">
                                    <input type="file" name="image" class="form-control" accept="image/*"
                                        id="imageInput">
                                    <label class="input-group-text" for="imageInput">
                                        <i class="bi bi-upload me-2"></i>Choose File
                                    </label>
                                </div>
                                <small class="text-muted">Recommended: 1200x600px or similar aspect ratio</small>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-fluid rounded"
                                        style="max-height: 300px;">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-file-text me-2 text-primary"></i>Content
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="content" rows="12" class="form-control" placeholder="Write your blog post content here..."
                                    required></textarea>
                                <small class="text-muted">Write your thoughts, ideas, and stories...</small>
                            </div>
                            <!-- Category Dropdown -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Category
                                </label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- No Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $blogPost->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Hashtags -->
                            <div class="mb-5">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-hash me-2 text-primary"></i>Hashtags
                                </label>
                                <input type="text" name="hashtags" class="form-control"
                                    placeholder="laravel, php, webdev, coding">
                                <small class="text-muted">Separate tags with commas. Example: laravel, php, blog</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-check-circle me-2"></i>Publish Post
                                </button>
                                <a href="{{ route('blog-posts.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
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
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .form-label {
            color: #495057;
            margin-bottom: 0.5rem;
        }
    </style>

    <script>
        // Image Preview
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
