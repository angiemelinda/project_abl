@extends('layouts.app')

@section('title', 'Ajukan Konseling')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Form Pengajuan Konseling</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('konseling.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon') }}" required>
        </div>
        <div class="mb-3">
            <label>Topik Konseling</label>
            <input type="text" name="topik" class="form-control" value="{{ old('topik') }}" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi Masalah</label>
            <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
            <a href="{{ route('konseling.list') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </form>
</div>
@endsection