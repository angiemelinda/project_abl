@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-1"><span class="text-primary">Login</span> <span class="text-success">Pemuda Peduli</span></h2>
                        <p class="text-muted">Masuk untuk mengakses akun Anda</p>
                    </div>

                    {{-- Tampilkan pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Tampilkan pesan error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form login --}}
                    <form action="{{ route('login.authenticate') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-medium"><i class="fas fa-envelope me-2 text-primary"></i>Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium"><i class="fas fa-lock me-2 text-primary"></i>Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password Anda" required>
                        </div>
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Daftar sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection