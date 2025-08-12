@extends('layouts.app')

@section('title', 'Selamat Datang di Pemuda Peduli')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
    <div class="container-fluid py-5 text-center">
        <h1 class="display-5 fw-bold">Bergabung dengan Gerakan Pemuda Peduli</h1>
        <p class="col-md-8 mx-auto fs-5">
            Kami adalah platform yang menghubungkan para pemuda yang memiliki semangat sosial tinggi 
            untuk berkolaborasi dalam berbagai kegiatan positif yang membangun masyarakat, khususnya melalui layanan konseling.
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Daftar Sekarang</a>
    </div>
</div>

<div class="row align-items-md-stretch mt-4">
    <div class="col-md-12">
        <div class="h-100 p-5 bg-success text-white rounded-3 shadow-sm">
            <h2>Layanan Konseling</h2>
            <p>
                Dapatkan bantuan profesional dari konselor berpengalaman. 
                Kami menyediakan layanan konseling yang aman, rahasia, dan mendukung, 
                untuk membantu Anda mengatasi berbagai masalah kehidupan.
            </p>
            <a href="{{ route('konseling.create') }}" class="btn btn-light">Ajukan Konseling</a>
        </div>
    </div>
</div>
@endsection