@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="mb-5">
                    <h1 class="display-5 fw-bold mb-2">Edit Blog Post</h1>
                    <p class="text-muted">Update your content</p>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('blog-posts.update', $blogPost) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Main Title -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-type-h1 me-2 text-primary"></i>Main Title
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="main_title"
                                    value="{{ old('main_title', $blogPost->main_title) }}"
                                    class="form-control form-control-lg" required>
                            </div>

                            <!-- Secondary Title -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-type-h2 me-2 text-primary"></i>Secondary Title
                                </label>
                                <input type="text" name="secondary_title"
                                    value="{{ old('secondary_title', $blogPost->secondary_title) }}" class="form-control">
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-image me-2 text-primary"></i>Featured Image
                                </label>

                                <!-- Current Image -->
                                @if ($blogPost->image)
                                    <div class="current-image mb-3 p-3 bg-light rounded">
                                        <p class="small text-muted mb-2">Current Image:</p>
                                        <img src="{{ asset('storage/' . $blogPost->image) }}"
                                            class="img-fluid rounded shadow-sm" style="max-height: 300px;"
                                            id="currentImage">
                                    </div>
                                @else
                                    <div class="alert alert-info mb-3">
                                        <i class="bi bi-info-circle me-2"></i>No image uploaded yet
                                    </div>
                                @endif

                                <!-- Upload New Image -->
                                <div class="input-group">
                                    <input type="file" name="image" class="form-control" accept="image/*"
                                        id="imageInput">
                                    <label class="input-group-text" for="imageInput">
                                        <i class="bi bi-upload me-2"></i>Choose New File
                                    </label>
                                </div>
                                <small class="text-muted">Leave empty to keep current image</small>

                                <!-- New Image Preview -->
                                <div id="newImagePreview" class="mt-3" style="display: none;">
                                    <p class="small text-muted mb-2">New Image Preview:</p>
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
                                <textarea name="content" rows="12" class="form-control" required>{{ old('content', $blogPost->content) }}</textarea>
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
                                <input type="text" name="hashtags"
                                    value="{{ old('hashtags', $blogPost->hashtags_string) }}" class="form-control"
                                    placeholder="laravel, php, webdev, coding">
                                <small class="text-muted">Separate tags with commas</small>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 pt-3 border-top">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="bi bi-check-circle me-2"></i>Update Post
                                </button>
                                <a href="{{ route('blog-posts.show', $blogPost) }}" class="btn btn-outline-info btn-lg">
                                    <i class="bi bi-eye me-2"></i>View Post
                                </a>
                                <a href="{{ route('blog-posts.index') }}" class="btn btn-outline-secondary btn-lg">
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
                        <p class="card-text text-muted mb-3">Once you delete this post, there is no going back. Please be
                            certain.</p>
                        <form action="{{ route('blog-posts.destroy', $blogPost) }}" method="POST"
                            onsubmit="return confirm('Are you absolutely sure you want to delete this post? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Post Permanently
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
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .form-label {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .current-image {
            transition: all 0.3s ease;
        }
    </style>

    <script>
        // Image Preview for new upload
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('newImagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('newImagePreview').style.display = 'none';
            }
        });
    </script>
@endsection
