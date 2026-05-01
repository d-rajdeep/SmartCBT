@extends('layouts.admin')

@section('title', 'Questions for ' . $exam->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Questions: {{ $exam->title }}</h2>
        <div>
            <a href="{{ route('admin.questions.bulk-upload', $exam) }}" class="btn btn-info">
                <i class="fas fa-upload me-2"></i>Bulk Upload
            </a>
            <a href="{{ route('admin.questions.create', $exam) }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Question
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($questions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Difficulty</th>
                                <th>Marks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $index => $question)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ Str::limit($question->question_text, 100) }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $question->difficulty == 'easy' ? 'success' : ($question->difficulty == 'medium' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($question->difficulty) }}
                                        </span>
                                    </td>
                                    <td>{{ $question->marks }}</td>
                                    <td>
                                        <a href="{{ route('admin.questions.edit', [$exam, $question]) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.questions.destroy', [$exam, $question]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this question?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $questions->links() }}
            @else
                <p class="text-center text-muted">No questions added yet. Click "Add Question" to get started.</p>
            @endif
        </div>
    </div>
@endsection
