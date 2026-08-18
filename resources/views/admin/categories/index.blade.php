@extends('layouts.admin')

@section('title', 'Exam Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Exam Categories</h2>
            <p class="text-muted mb-0">Manage and organize your examination categories.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
            <i class="fas fa-plus me-2"></i> Add Category
        </a>
    </div>

    <div class="glass-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table mb-0">
                    <thead class="text-uppercase text-muted small fw-semibold">
                        <tr>
                            <th class="ps-3 border-0">ID</th>
                            <th class="border-0">Category Name</th>
                            <th class="border-0">Slug</th>
                            <th class="border-0">Description</th>
                            <th class="border-0 text-center">Exams</th>
                            <th class="border-0">Created Date</th>
                            <th class="border-0 text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-3 fw-medium text-dark">{{ $loop->index + 1 }}</td>
                                <td class="fw-bold text-dark">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 text-primary">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                        {{ $category->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-normal">
                                        {{ $category->slug }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ Str::limit($category->description, 40) ?: 'No description provided' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-2 py-1">
                                        {{ $category->exams_count }}
                                    </span>
                                </td>
                                <td class="text-muted small fw-medium">
                                    {{ $category->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm ms-1" onclick="return confirm('Are you sure you want to delete this category?')" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-folder-open fa-3x text-light"></i>
                                    </div>
                                    <h6 class="text-muted fw-medium">No categories found</h6>
                                    <p class="text-muted small">Get started by creating your first category.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($categories->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
