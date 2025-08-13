@extends('layouts.app')

@section('title', 'Kelola Konseling')

@section('content')
<div class="container">
    <h1 class="mb-4">Kelola Jadwal Konseling</h1>

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

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Filter Konseling</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('konseling.manage') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="dijadwalkan" {{ request('status') == 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="date_from" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-4">
                    <label for="date_to" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('konseling.manage') }}" class="btn btn-secondary ms-2">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Konseling</h5>
            <a href="{{ route('konseling.create') }}" class="btn btn-light btn-sm">Tambah Baru</a>
        </div>
        <div class="card-body">
            @if($konselings->isEmpty())
                <div class="alert alert-warning">Tidak ada konseling yang tersedia.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Pengaju</th>
                                <th>Konselor</th>
                                <th>Jadwal</th>
                                <th>Topik</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($konselings as $index => $k)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $k->nama_pengaju ?? $k->nama_lengkap ?? 'Tidak diketahui' }}</td>
                                    <td>{{ $k->nama_konselor ?? 'Belum ditentukan' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($k->jadwal)->format('d M Y H:i') }}</td>
                                    <td>{{ $k->topik ?? '-' }}</td>
                                    <td>
                                        @if($k->status == 'menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($k->status == 'dijadwalkan')
                                            <span class="badge bg-success">Dijadwalkan</span>
                                        @elseif($k->status == 'selesai')
                                            <span class="badge bg-info">Selesai</span>
                                        @elseif($k->status == 'batal')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($k->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('konseling.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('konseling.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection