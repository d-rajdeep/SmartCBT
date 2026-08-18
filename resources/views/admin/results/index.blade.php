@extends('layouts.admin')

@section('title', 'Exam Results')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Exam Results</h2>
            <p class="text-muted mb-0">Monitor and analyze student performance across all exams.</p>
        </div>
        <a href="{{ route('admin.results.export') }}" class="btn btn-success rounded-pill px-4 py-2 shadow-sm text-white fw-medium">
            <i class="fas fa-file-export me-2"></i> Export Data
        </a>
    </div>

    <div class="glass-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.results.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="exam_id" class="form-label fw-medium text-dark small ms-1">Filter by Exam</label>
                    <select name="exam_id" id="exam_id" class="form-select bg-light border-0">
                        <option value="">All Exams</option>
                        @foreach ($exams as $exam)
                            <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label fw-medium text-dark small ms-1">Date From</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" name="date_from" id="date_from" class="form-control bg-light border-0"
                            value="{{ request('date_from') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label fw-medium text-dark small ms-1">Date To</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-calendar-check"></i></span>
                        <input type="date" name="date_to" id="date_to" class="form-control bg-light border-0"
                            value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm fw-bold py-2">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="glass-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table mb-0">
                    <thead class="text-uppercase text-muted small fw-semibold">
                        <tr>
                            <th class="ps-3 border-0" width="5%">ID</th>
                            <th class="border-0" width="20%">Student</th>
                            <th class="border-0" width="25%">Exam</th>
                            <th class="border-0 text-center" width="10%">Score</th>
                            <th class="border-0" width="15%">Performance</th>
                            <th class="border-0 text-center" width="10%">Result</th>
                            <th class="border-0" width="10%">Date</th>
                            <th class="border-0 text-end pe-3" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($results as $result)
                            <tr>
                                <td class="ps-3 fw-medium text-dark">#{{ $result->id ?? $loop->index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm" style="width: 35px; height: 35px;">
                                            <span class="fw-bold small">{{ strtoupper(substr($result->user->name, 0, 1)) }}</span>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $result->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-dark">{{ Str::limit($result->exam->title, 40) }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-dark">{{ $result->total_marks_obtained }}</span>
                                    <span class="text-muted small">/{{ $result->total_marks }}</span>
                                </td>
                                <td>
                                    @php
                                        $pct = $result->percentage;
                                        $color = $pct >= 80 ? 'success' : ($pct >= 60 ? 'primary' : ($pct >= 40 ? 'warning' : 'danger'));
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-{{ $color }} me-2" style="width: 45px;">{{ number_format($pct, 1) }}%</span>
                                        <div class="progress flex-grow-1 bg-{{ $color }} bg-opacity-10 shadow-sm" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $color }} rounded-pill" role="progressbar" style="width: {{ $pct }}%" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($result->is_passed)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1">Passed</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1">Failed</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small fw-medium">{{ $result->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('admin.results.show', $result) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm" title="View Detailed Result">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-search fa-3x text-light"></i>
                                    </div>
                                    <h6 class="text-muted fw-medium">No results found</h6>
                                    <p class="text-muted small mb-0">Try adjusting your filters or wait for students to complete exams.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($results->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $results->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
