<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | SmartCBT</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Premium UI CSS -->
    <link rel="stylesheet" href="{{ asset('css/premium-ui.css') }}">
    
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg glass-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand text-gradient fw-bold fs-4" href="{{ route('user.dashboard') }}">
                <i class="fas fa-graduation-cap me-2 text-primary"></i>SmartCBT
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars text-primary"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('user.dashboard') ? 'text-primary' : 'text-secondary' }}" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link fw-medium {{ request()->routeIs('user.exams.*') ? 'text-primary' : 'text-secondary' }}" href="{{ route('user.exams.available') }}">
                            <i class="fas fa-book me-1"></i> Exams
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link fw-medium {{ request()->routeIs('user.results.*') ? 'text-primary' : 'text-secondary' }}" href="{{ route('user.results.index') }}">
                            <i class="fas fa-chart-line me-1"></i> Results
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link fw-medium {{ request()->routeIs('user.profile.*') ? 'text-primary' : 'text-secondary' }}" href="{{ route('user.profile.edit') }}">
                            <i class="fas fa-user me-1"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>

</html>
