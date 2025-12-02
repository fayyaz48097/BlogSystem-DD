@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Back Button -->
                <a href="{{ route('blog-posts.index') }}" class="btn btn-link text-decoration-none mb-4 ps-0">
                    <i class="bi bi-arrow-left me-2"></i>Back to all posts
                </a>

                <!-- Article Card -->
                <article class="card border-0 shadow-sm">
                    <!-- Featured Image -->
                    @if ($blogPost->image)
                        <img src="{{ asset('storage/' . $blogPost->image) }}" class="card-img-top"
                            alt="{{ $blogPost->main_title }}"
                            style="max-height: 500px; object-fit: cover; border-radius: 12px 12px 0 0;">
                    @endif

                    <div class="card-body p-4 p-md-5">
                        <!-- Hashtags at Top -->
                        @if ($blogPost->hashtags_string)
                            <div class="mb-4">
                                @foreach (explode(',', $blogPost->hashtags_string) as $tag)
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-normal px-3 py-2 me-2 mb-2">
                                        #{{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        @if ($blogPost->category)
                            <div class="mb-3">
                                <span class="badge bg-success bg-opacity-20  px-3 py-2">
                                    {{ $blogPost->category->name }}
                                </span>
                            </div>
                        @endif
                        <!-- Main Title -->
                        <h1 class="display-5 fw-bold mb-3">{{ $blogPost->main_title }}</h1>

                        <!-- Secondary Title -->
                        @if ($blogPost->secondary_title)
                            <h2 class="h4 text-muted fw-normal mb-4 pb-3 border-bottom">
                                {{ $blogPost->secondary_title }}
                            </h2>
                        @endif

                        <!-- Content -->
                        <div class="article-content my-5" style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                            {!! nl2br(e($blogPost->content)) !!}
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mt-5 pt-4 border-top">
                            <a href="{{ route('blog-posts.edit', $blogPost) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square me-2"></i>Edit Post
                            </a>
                            <a href="{{ route('blog-posts.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-grid-3x3-gap me-2"></i>All Posts
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
        }

        .article-content {
            text-align: justify;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
