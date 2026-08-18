@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit User</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user) }}" class="text-decoration-none">{{ $user->name }}</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="glass-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Update User Details</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium text-dark small ms-1">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control bg-light border-0 @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium text-dark small ms-1">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-medium text-dark small ms-1">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" id="password"
                                        name="password" placeholder="Leave blank to keep current">
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @else
                                    <div class="form-text small">Minimum 6 characters. Leave blank if unchanged.</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium text-dark small ms-1">Phone Number <span class="text-muted fw-normal">(Optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-phone-alt"></i></span>
                                    <input type="text" class="form-control bg-light border-0" id="phone" name="phone"
                                        value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label fw-medium text-dark small ms-1">Date of Birth <span class="text-muted fw-normal">(Optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control bg-light border-0" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch mt-4 ms-2 custom-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium ms-2" for="is_active">Active Account</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 border-top border-light border-opacity-50 pt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light text-dark rounded-pill px-4 py-2 fw-semibold border">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 d-none d-lg-block">
            <div class="glass-card border-0 shadow-sm bg-primary bg-opacity-10 mb-4">
                <div class="card-body p-4 text-center">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-3 text-primary" style="width: 80px; height: 80px;">
                        <span class="display-5 fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        @if ($user->is_active)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">Active Status</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2">Inactive Status</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="glass-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="fas fa-shield-alt text-primary me-2"></i>Security Note</h6>
                    <p class="text-muted small mb-0">
                        If you update the user's password, they will be required to use the new password upon their next login. Make sure to communicate this change securely.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
