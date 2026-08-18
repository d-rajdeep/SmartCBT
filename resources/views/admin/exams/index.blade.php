@extends('layouts.admin')

@section('title', 'Manage Exams')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Manage Exams</h2>
            <p class="text-muted mb-0">Create, edit, and manage all your examinations.</p>
        </div>
        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
            <i class="fas fa-plus me-2"></i> Create Exam
        </a>
    </div>

    <div class="glass-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table mb-0">
                    <thead class="text-uppercase text-muted small fw-semibold">
                        <tr>
                            <th class="ps-3 border-0">Exam Title</th>
                            <th class="border-0">Category</th>
                            <th class="border-0 text-center">Questions</th>
                            <th class="border-0 text-center">Duration</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($exams as $exam)
                            <tr>
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 text-primary">
                                            <i class="fas fa-file-signature"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $exam->title }}</h6>
                                            <small class="text-muted">ID: #{{ $exam->id ?? $loop->index + 1 }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-normal">
                                        {{ $exam->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-medium text-dark">{{ $exam->total_questions }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted small"><i class="fas fa-clock me-1"></i>{{ $exam->duration }} min</span>
                                </td>
                                <td>
                                    @if ($exam->is_published)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">
                                            <i class="fas fa-check-circle me-1 small"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill">
                                            <i class="fas fa-pen me-1 small"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit Exam">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-sm btn-outline-info shadow-sm" title="Manage Questions">
                                            <i class="fas fa-question-circle"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm ms-1" onclick="deleteExam({{ $exam->id }})" title="Delete Exam">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="delete-form-{{ $exam->id }}" action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-file-alt fa-3x text-light"></i>
                                    </div>
                                    <h6 class="text-muted fw-medium">No exams found</h6>
                                    <p class="text-muted small mb-3">Get started by creating your first examination.</p>
                                    <a href="{{ route('admin.exams.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">Create Exam</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($exams->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $exams->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function deleteExam(id) {
        if (confirm('Are you sure you want to delete this exam? This action cannot be undone.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
