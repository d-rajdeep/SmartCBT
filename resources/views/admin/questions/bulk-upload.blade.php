@extends('layouts.admin')

@section('title', 'Bulk Upload Questions')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Bulk Upload Questions for: {{ $exam->title }}</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <h5>Instructions:</h5>
                <ul>
                    <li>Upload an Excel file (.xlsx or .csv) with the following columns:</li>
                    <li>Column 1: Question Text</li>
                    <li>Column 2: Option A</li>
                    <li>Column 3: Option B</li>
                    <li>Column 4: Option C</li>
                    <li>Column 5: Option D</li>
                    <li>Column 6: Correct Option (1, 2, 3, or 4)</li>
                    <li>Column 7: Difficulty (easy/medium/hard - optional)</li>
                    <li>Column 8: Marks (optional, defaults to 1)</li>
                </ul>
                <a href="#" class="btn btn-sm btn-success">Download Sample Template</a>
            </div>

            <form method="POST" action="{{ route('admin.questions.process-bulk-upload', $exam) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Select Excel File</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                        name="file" accept=".xlsx,.csv" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Upload Questions</button>
                <a href="{{ route('admin.exams.questions.index', $exam) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
