@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Manage Users</h2>
            <p class="text-muted mb-0">View and manage all registered users.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
            <i class="fas fa-user-plus me-2"></i> Add User
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="glass-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table mb-0">
                    <thead class="text-uppercase text-muted small fw-semibold">
                        <tr>
                            <th class="ps-3 border-0">User</th>
                            <th class="border-0">Contact Info</th>
                            <th class="border-0 text-center">Status</th>
                            <th class="border-0 text-center">Exams Taken</th>
                            <th class="border-0">Joined Date</th>
                            <th class="border-0 text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: #{{ $user->id ?? $loop->index + 1 }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark small"><i class="fas fa-envelope text-muted me-1"></i> {{ $user->email }}</span>
                                        <span class="text-muted small"><i class="fas fa-phone-alt me-1"></i> {{ $user->phone ?? 'Not provided' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($user->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">Active</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 py-1">
                                        {{ $user->exam_attempts_count ?? 0 }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small fw-medium">{{ $user->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info shadow-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm ms-1" onclick="return confirm('Are you sure you want to delete this user?')" title="Delete User">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-users fa-3x text-light"></i>
                                    </div>
                                    <h6 class="text-muted fw-medium">No users found</h6>
                                    <p class="text-muted small mb-3">No registered users in the system yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
