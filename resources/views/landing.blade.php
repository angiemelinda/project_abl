@extends('layouts.app')

@section('title', 'Selamat Datang di Pemuda Peduli')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="p-5 mb-5 bg-primary bg-gradient text-white rounded-3 shadow position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('https://images.unsplash.com/photo-1529156069898-49953e39b3ac?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2089&q=80') no-repeat center center; background-size: cover; opacity: 0.2;"></div>
    <div class="container-fluid py-5 text-center position-relative">
        <h1 class="display-4 fw-bold mb-4">Bergabung dengan Gerakan <span class="text-warning">Pemuda Peduli</span></h1>
        <p class="col-md-8 mx-auto fs-5 mb-4">
            Kami adalah platform yang menghubungkan para pemuda yang memiliki semangat sosial tinggi 
            untuk berkolaborasi dalam berbagai kegiatan positif yang membangun masyarakat, khususnya melalui layanan konseling.
        </p>
        <div>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2 px-4 shadow-sm"><i class="fas fa-user-plus me-2"></i>Daftar Sekarang</a>
        </div>
    </div>
</div>

<div class="row align-items-md-stretch mt-5">
    <div class="col-12 text-center mb-4">
        <h2 class="fw-bold">Layanan <span class="text-success">Konseling</span> Kami</h2>
        <p class="text-muted">Solusi profesional untuk berbagai masalah kehidupan</p>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="fas fa-user-shield fa-2x text-primary"></i>
                </div>
                <h4>Privasi Terjamin</h4>
                <p class="text-muted">
                    Kami menjamin kerahasiaan setiap sesi konseling. Informasi Anda aman bersama kami.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="fas fa-users fa-2x text-success"></i>
                </div>
                <h4>Konselor Profesional</h4>
                <p class="text-muted">
                    Tim konselor kami terdiri dari profesional berpengalaman yang siap membantu Anda.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="fas fa-calendar-check fa-2x text-warning"></i>
                </div>
                <h4>Jadwal Fleksibel</h4>
                <p class="text-muted">
                    Pilih jadwal konseling yang sesuai dengan kebutuhan dan waktu luang Anda.
                </p>
            </div>
        </div>
    </div>
    <div class="col-12 text-center mt-3">
        <a href="{{ route('konseling.create') }}" class="btn btn-success btn-lg shadow-sm"><i class="fas fa-calendar-plus me-2"></i>Ajukan Konseling Sekarang</a>
    </div>
</div>
@endsection
