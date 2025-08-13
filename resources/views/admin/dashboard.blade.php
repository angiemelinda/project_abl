@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-4 bg-primary text-white p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user-shield fa-lg"></i>
                                </div>
                                <h3 class="mb-0 fw-bold">Admin Dashboard</h3>
                            </div>
                            <p class="mb-4">Selamat datang di panel administrasi Pemuda Peduli. Di sini Anda dapat mengelola semua aspek platform.</p>
                            <div class="d-flex align-items-center">
                                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">{{ Auth::user()->name }}</h5>
                                    <p class="mb-0 small">Administrator</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 p-4">
                            <h4 class="fw-bold mb-4">Ringkasan Sistem</h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-users text-primary"></i>
                                            </div>
                                            <h6 class="mb-0">Pengguna</h6>
                                        </div>
                                        <h3 class="fw-bold mb-0">{{ App\Models\User::count() }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rounded-circle bg-success bg-opacity-10 p-2 d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user-tie text-success"></i>
                                            </div>
                                            <h6 class="mb-0">Konselor</h6>
                                        </div>
                                        <h3 class="fw-bold mb-0">{{ App\Models\User::where('role_id', 2)->count() }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rounded-circle bg-info bg-opacity-10 p-2 d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-comments text-info"></i>
                                            </div>
                                            <h6 class="mb-0">Konseling</h6>
                                        </div>
                                        <h3 class="fw-bold mb-0">{{ App\Models\Konseling::count() }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <h4 class="fw-bold mb-3">Menu Utama</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Kelola Pengguna</h5>
                    <p class="card-text text-muted">Tambah, edit, dan hapus pengguna platform</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary w-100"><i class="fas fa-cog me-2"></i>Kelola</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-flex mb-3">
                        <i class="fas fa-user-tie fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">Kelola Konselor</h5>
                    <p class="card-text text-muted">Tambah, edit, dan hapus konselor platform</p>
                    <a href="{{ route('konselors.index') }}" class="btn btn-success w-100"><i class="fas fa-cog me-2"></i>Kelola</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-flex mb-3">
                        <i class="fas fa-calendar-alt fa-2x text-info"></i>
                    </div>
                    <h5 class="card-title fw-bold">Kelola Konseling</h5>
                    <p class="card-text text-muted">Lihat dan kelola sesi konseling platform</p>
                    <a href="{{ route('konseling.manage') }}" class="btn btn-info text-white w-100"><i class="fas fa-cog me-2"></i>Kelola</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection