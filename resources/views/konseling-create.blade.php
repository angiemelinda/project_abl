@extends('layouts.app')

@section('title', 'Ajukan Konseling')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Form Pengajuan Konseling</h2>
    <form action="{{ url('/konseling') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Topik Konseling</label>
            <input type="text" name="topik" class="form-control">
        </div>
        <div class="mb-3">
            <label>Deskripsi Masalah</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
    </form>
</div>
@endsection