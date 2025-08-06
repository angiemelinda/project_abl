@extends('layouts.app')

@section('title', 'Selamat Datang di Pemuda Peduli')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bergabung dengan Gerakan Pemuda Peduli</h1>
        <p class="col-md-8 fs-4">Kami adalah platform yang menghubungkan para pemuda yang memiliki semangat sosial tinggi untuk berkolaborasi dalam berbagai kegiatan positif yang membangun masyarakat.</p>
        <button class="btn btn-primary btn-lg" type="button">Daftar Sekarang</button>
    </div>
</div>

<div class="row align-items-md-stretch">
    <div class="col-md-6">
        <div class="h-100 p-5 text-white bg-dark rounded-3">
            <h2>Program Kami</h2>
            <p>Lihat berbagai program sosial yang sedang dan akan kami laksanakan. Mulai dari pendidikan, lingkungan, hingga kesehatan. Temukan program yang sesuai dengan minatmu.</p>
            <button class="btn btn-outline-light" type="button">Lihat Program</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="h-100 p-5 bg-light border rounded-3">
            <h2>Jadi Relawan</h2>
            <p>Jadilah bagian dari perubahan dengan menjadi relawan di berbagai kegiatan kami. Dapatkan pengalaman berharga dan perluas jaringanmu dengan sesama pemuda inspiratif.</p>
            <button class="btn btn-outline-secondary" type="button">Gabung Jadi Relawan</button>
        </div>
    </div>
</div>
@endsection
