<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Pemuda Peduli')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,.1);
        }
        .btn {
            border-radius: 5px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #4361ee;
            border-color: #4361ee;
        }
        .btn-primary:hover {
            background-color: #3a56d4;
            border-color: #3a56d4;
        }
        .btn-success {
            background-color: #2ec4b6;
            border-color: #2ec4b6;
        }
        .btn-success:hover {
            background-color: #26a69a;
            border-color: #26a69a;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><span class="text-primary">Pemuda</span> <span class="text-success">Peduli</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}"><i class="fas fa-home me-1"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('konseling.list') }}"><i class="fas fa-comments me-1"></i> Konseling</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown" style="border-radius: 8px; border: none;">
                                @if(Auth::user()->role_id == 1)
                                <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard Admin</a></li>
                                @elseif(Auth::user()->role_id == 2)
                                <li><a class="dropdown-item py-2" href="{{ route('konselor.dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-success"></i> Dashboard Konselor</a></li>
                                @endif
                                <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2 text-info"></i> Edit Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @yield('content')
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="mb-3 fw-bold"><span class="text-primary">Pemuda</span> <span class="text-success">Peduli</span></h5>
                    <p>Platform yang menghubungkan para pemuda yang memiliki semangat sosial tinggi untuk berkolaborasi dalam berbagai kegiatan positif.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="mb-3">Tautan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-white"><i class="fas fa-angle-right me-1"></i> Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('konseling.list') }}" class="text-decoration-none text-white"><i class="fas fa-angle-right me-1"></i> Konseling</a></li>
                        <li><a href="{{ route('login') }}" class="text-decoration-none text-white"><i class="fas fa-angle-right me-1"></i> Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="mb-3">Kontak</h5>
                    <p><i class="fas fa-envelope me-2"></i> info@pemudapeduli.org</p>
                    <p><i class="fas fa-phone me-2"></i> +62 123 4567 890</p>
                    <div class="d-flex mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Pemuda Peduli. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
