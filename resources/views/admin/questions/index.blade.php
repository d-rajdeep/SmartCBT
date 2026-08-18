@extends('layouts.admin')

@section('title', 'Questions for ' . $exam->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Manage Questions</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.exams.index') }}" class="text-decoration-none">Exams</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $exam->title }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.questions.bulk-upload', $exam) }}" class="btn btn-info rounded-pill px-3 shadow-sm me-2 text-white">
                <i class="fas fa-file-upload me-2"></i> Bulk Upload
            </a>
            <a href="{{ route('admin.questions.create', $exam) }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
                <i class="fas fa-plus me-2"></i> Add Question
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="glass-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($questions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle custom-table mb-0">
                        <thead class="text-uppercase text-muted small fw-semibold">
                            <tr>
                                <th class="ps-3 border-0" width="5%">#</th>
                                <th class="border-0" width="45%">Question Text</th>
                                <th class="border-0 text-center" width="10%">Difficulty</th>
                                <th class="border-0 text-center" width="10%">Marks</th>
                                <th class="border-0 text-center" width="15%">Options</th>
                                <th class="border-0 text-end pe-3" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach ($questions as $index => $question)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ ($questions->currentPage() - 1) * $questions->perPage() + $index + 1 }}</td>
                                    <td>
                                        <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ Str::limit($question->question_text, 100) }}</p>
                                    </td>
                                    <td class="text-center">
                                        @if($question->difficulty == 'easy')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1">Easy</span>
                                        @elseif($question->difficulty == 'medium')
                                            <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 rounded-pill px-2 py-1">Medium</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1">Hard</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-dark">{{ $question->marks }}</span>
                                    </td>
                                    <td class="text-center text-muted small">
                                        {{ $question->options->count() }} options
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.questions.edit', [$exam, $question]) }}" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit Question">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.questions.destroy', [$exam, $question]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm ms-1" onclick="return confirm('Are you sure you want to delete this question?')" title="Delete Question">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($questions->hasPages())
                    <div class="mt-4 d-flex justify-content-end">
                        {{ $questions->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-question-circle fa-3x text-light"></i>
                    </div>
                    <h6 class="text-muted fw-medium">No questions added yet</h6>
                    <p class="text-muted small mb-3">Build your exam by adding questions manually or uploading them in bulk.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.questions.create', $exam) }}" class="btn btn-sm btn-primary rounded-pill px-3">Add Manually</a>
                        <a href="{{ route('admin.questions.bulk-upload', $exam) }}" class="btn btn-sm btn-info rounded-pill px-3 text-white">Bulk Upload</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
