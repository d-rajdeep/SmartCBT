@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit Category</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" class="text-decoration-none">Categories</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="glass-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-edit text-primary me-2"></i>Update Category Details</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium text-dark small ms-1">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-5">
                            <label for="description" class="form-label fw-medium text-dark small ms-1">Description <span class="text-muted fw-normal">(Optional)</span></label>
                            <textarea class="form-control bg-light border-0 @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2 border-top border-light border-opacity-50 pt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                <i class="fas fa-save me-2"></i> Update Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light text-dark rounded-pill px-4 py-2 fw-semibold border">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 d-none d-lg-block">
            <div class="glass-card border-0 shadow-sm bg-warning bg-opacity-10 border-warning border-opacity-25">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-warning-emphasis mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Note on Editing</h6>
                    <p class="text-muted small mb-0">
                        Changing the category name might also update its slug (URL identifier). If you have linked directly to this category using its slug from external pages, those links might break.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
