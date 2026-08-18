@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12 text-center text-md-start">
                <h2 class="fw-bold text-dark mb-1">My Profile</h2>
                <p class="text-muted">Manage your personal information and account security.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Info Card -->
            <div class="col-lg-4">
                <div class="glass-card border-0 shadow-sm text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 120px; height: 120px;">
                        <span class="display-3 fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-4">{{ $user->email }}</p>
                    
                    <hr class="border-secondary border-opacity-10 mb-4">
                    
                    <ul class="list-unstyled text-start mb-0">
                        <li class="mb-3 d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-muted">
                                <i class="fas fa-calendar-plus fa-fw"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-semibold">Member Since</small>
                                <span class="text-dark fw-medium">{{ $user->created_at->format('F d, Y') }}</span>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="bg-light rounded p-2 me-3 text-muted">
                                <i class="fas fa-shield-alt fa-fw"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-semibold">Account Status</small>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1 mt-1">Active</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Profile Form Card -->
            <div class="col-lg-8">
                <div class="glass-card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Update Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-medium text-dark small ms-1">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control bg-light border-0 @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium text-dark small ms-1">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-medium text-dark small ms-1">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-phone-alt"></i></span>
                                        <input type="tel" class="form-control bg-light border-0 @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label fw-medium text-dark small ms-1">Date of Birth</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control bg-light border-0 @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" name="date_of_birth"
                                            value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                    </div>
                                    @error('date_of_birth')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="border-secondary border-opacity-10 mb-5">
                            
                            <h5 class="fw-bold text-dark mb-4"><i class="fas fa-lock text-primary me-2"></i>Change Password <span class="text-muted fw-normal fs-6">(Optional)</span></h5>

                            <div class="row g-4 mb-4">
                                <div class="col-12">
                                    <label for="current_password" class="form-label fw-medium text-dark small ms-1">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-key"></i></span>
                                        <input type="password" class="form-control bg-light border-0" id="current_password" name="current_password" placeholder="Enter current password to verify">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="new_password" class="form-label fw-medium text-dark small ms-1">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control bg-light border-0" id="new_password" name="new_password" placeholder="Minimum 6 characters">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="new_password_confirmation" class="form-label fw-medium text-dark small ms-1">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-check-circle"></i></span>
                                        <input type="password" class="form-control bg-light border-0" id="new_password_confirmation"
                                            name="new_password_confirmation" placeholder="Re-enter new password">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end pt-3">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
