@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <h1>Create Category</h1>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" rows="4" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save Category</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
