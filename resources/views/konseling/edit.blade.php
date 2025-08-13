@extends('layouts.app')

@section('title', 'Edit Konseling')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Jadwal Konseling</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('konseling.update', $konseling->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Pengaju</label>
                    <input type="text" class="form-control" id="nama_lengkap" value="{{ $konseling->nama_lengkap }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $konseling->email }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="topik" class="form-label">Topik</label>
                    <input type="text" class="form-control @error('topik') is-invalid @enderror" id="topik" name="topik" value="{{ old('topik', $konseling->topik) }}">
                    @error('topik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="konselor_id" class="form-label">Konselor</label>
                    <select class="form-select @error('konselor_id') is-invalid @enderror" id="konselor_id" name="konselor_id">
                        @foreach($konselors as $konselor)
                            <option value="{{ $konselor->id }}" {{ old('konselor_id', $konseling->konselor_id) == $konselor->id ? 'selected' : '' }}>
                                {{ $konselor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('konselor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="jadwal" class="form-label">Jadwal</label>
                    <input type="datetime-local" class="form-control @error('jadwal') is-invalid @enderror" id="jadwal" name="jadwal" value="{{ old('jadwal', $konseling->jadwal ? date('Y-m-d\TH:i', strtotime($konseling->jadwal)) : '') }}">
                    @error('jadwal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="menunggu" {{ old('status', $konseling->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="dijadwalkan" {{ old('status', $konseling->status) == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                        <option value="selesai" {{ old('status', $konseling->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ old('status', $konseling->status) == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $konseling->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('konseling.list') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection