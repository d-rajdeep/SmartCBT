@extends('layouts.admin')

@section('title', 'Manage Exams')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Exams</h2>
        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Exam
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Questions</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $exam->title }}</td>
                                <td>{{ $exam->category->name ?? 'N/A' }}</td>
                                <td>{{ $exam->total_questions }}</td>
                                <td>{{ $exam->duration }} min</td>
                                <td>
                                    @if ($exam->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-question-circle"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteExam({{ $exam->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $exam->id }}"
                                        action="{{ route('admin.exams.destroy', $exam) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No exams found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    闭itable
            </div>
            {{ $exams->links() }}
        </div>
    </div>

    <script>
        function deleteExam(id) {
            if (confirm('Are you sure you want to delete this exam?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endsection
