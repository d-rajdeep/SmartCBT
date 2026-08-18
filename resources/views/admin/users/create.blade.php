@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Add User</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Create New</li>
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
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-plus text-primary me-2"></i>User Details</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium text-dark small ms-1">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control bg-light border-0 @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name') }}" placeholder="John Doe" required>
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
                                        name="email" value="{{ old('email') }}" placeholder="john@example.com" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-medium text-dark small ms-1">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" id="password"
                                        name="password" required>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium text-dark small ms-1">Phone Number <span class="text-muted fw-normal">(Optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-phone-alt"></i></span>
                                    <input type="text" class="form-control bg-light border-0" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 234 567 8900">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label fw-medium text-dark small ms-1">Date of Birth <span class="text-muted fw-normal">(Optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control bg-light border-0" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch mt-4 ms-2 custom-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label fw-medium ms-2" for="is_active">Active Account</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 border-top border-light border-opacity-50 pt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Create User
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
            <div class="glass-card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>About Users</h6>
                    <p class="text-muted small mb-3">
                        Creating a user manually allows them to bypass the public registration process.
                    </p>
                    <ul class="text-muted small ps-3 mb-0">
                        <li class="mb-1">Ensure the email is valid and unique.</li>
                        <li class="mb-1">Users will use the email and password you set here to log in.</li>
                        <li>You can deactivate the user later if needed.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
