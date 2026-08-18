@extends('layouts.admin')

@section('title', 'User Details: ' . $user->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">User Profile</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
                <i class="fas fa-edit me-2"></i> Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 position-relative overflow-hidden">
                <div class="position-relative z-1">
                    <p class="text-muted fw-bold text-uppercase small mb-2">Total Exams Taken</p>
                    <h2 class="display-5 fw-bold text-primary mb-0">{{ $stats['total_exams'] }}</h2>
                </div>
                <div class="position-absolute opacity-10" style="bottom: -15px; right: -10px;">
                    <i class="fas fa-file-alt fa-5x text-primary"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 position-relative overflow-hidden">
                <div class="position-relative z-1">
                    <p class="text-muted fw-bold text-uppercase small mb-2">Average Score</p>
                    <h2 class="display-5 fw-bold text-success mb-0">{{ $stats['average_score'] }}%</h2>
                </div>
                <div class="position-absolute opacity-10" style="bottom: -15px; right: -10px;">
                    <i class="fas fa-percentage fa-5x text-success"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 position-relative overflow-hidden">
                <div class="position-relative z-1">
                    <p class="text-muted fw-bold text-uppercase small mb-2">Passed Exams</p>
                    <h2 class="display-5 fw-bold text-info mb-0">{{ $stats['passed_exams'] }}</h2>
                </div>
                <div class="position-absolute opacity-10" style="bottom: -15px; right: -10px;">
                    <i class="fas fa-check-circle fa-5x text-info"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 d-flex flex-column justify-content-center align-items-center">
                <p class="text-muted fw-bold text-uppercase small mb-3">Account Status</p>
                @if ($user->is_active)
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 60px; height: 60px;">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                    <span class="badge bg-success rounded-pill px-3 py-2 fw-semibold shadow-sm">Active</span>
                @else
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 60px; height: 60px;">
                        <i class="fas fa-user-times fa-2x"></i>
                    </div>
                    <span class="badge bg-danger rounded-pill px-3 py-2 fw-semibold shadow-sm">Inactive</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="glass-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-4 pb-3 border-bottom border-light">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 100px; height: 100px;">
                            <span class="display-4 fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                        <p class="text-muted small mb-0"><i class="fas fa-envelope me-1"></i> {{ $user->email }}</p>
                    </div>
                    
                    <h6 class="fw-bold text-dark mb-3 text-uppercase small">Contact Information</h6>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3 d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-muted">
                                <i class="fas fa-phone-alt fa-fw"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-semibold">Phone Number</small>
                                <span class="text-dark fw-medium">{{ $user->phone ?? 'Not provided' }}</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-muted">
                                <i class="fas fa-birthday-cake fa-fw"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-semibold">Date of Birth</small>
                                <span class="text-dark fw-medium">{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('F d, Y') : 'Not provided' }}</span>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-muted">
                                <i class="fas fa-calendar-plus fa-fw"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-semibold">Joined Date</small>
                                <span class="text-dark fw-medium">{{ $user->created_at->format('F d, Y') }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="glass-card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history text-primary me-2"></i>Exam History</h5>
                </div>
                <div class="card-body p-4">
                    @if ($results->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle custom-table mb-0">
                                <thead class="text-uppercase text-muted small fw-semibold">
                                    <tr>
                                        <th class="ps-3 border-0">Exam Name</th>
                                        <th class="border-0 text-center">Score</th>
                                        <th class="border-0 text-center">Percentage</th>
                                        <th class="border-0 text-center">Result</th>
                                        <th class="border-0">Date Taken</th>
                                        <th class="border-0 text-end pe-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach ($results as $result)
                                        <tr>
                                            <td class="ps-3 fw-bold text-dark">{{ $result->exam->title }}</td>
                                            <td class="text-center">
                                                <span class="fw-medium text-dark">{{ $result->total_marks_obtained }}</span>
                                                <span class="text-muted small">/{{ $result->total_marks }}</span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $pct = $result->percentage;
                                                    $colorClass = $pct >= 80 ? 'text-success' : ($pct >= 60 ? 'text-primary' : ($pct >= 40 ? 'text-warning' : 'text-danger'));
                                                @endphp
                                                <span class="fw-bold {{ $colorClass }}">{{ number_format($pct, 1) }}%</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($result->is_passed)
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1">Passed</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1">Failed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark small fw-medium">{{ $result->created_at->format('M d, Y') }}</span>
                                                    <span class="text-muted small">{{ $result->created_at->format('h:i A') }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-3">
                                                <a href="{{ route('admin.results.show', $result) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($results->hasPages())
                            <div class="mt-4 d-flex justify-content-end">
                                {{ $results->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="fas fa-clipboard-list fa-3x text-light"></i>
                            </div>
                            <h6 class="text-muted fw-medium">No exams taken yet</h6>
                            <p class="text-muted small mb-0">This user hasn't completed any exams.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
