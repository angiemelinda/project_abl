@extends('layouts.app')

@section('title', 'Daftar Konseling')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Daftar Konseling</h1>
            <p class="text-muted">Kelola sesi konseling Anda di sini</p>
        </div>
        <div>
            <a href="{{ route('konseling.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Ajukan Konseling Baru</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($konselings->isEmpty())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>Tidak ada konseling yang tersedia.
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3">#</th>
                            <th class="py-3">Pengaju</th>
                            <th class="py-3">Konselor</th>
                            <th class="py-3">Jadwal</th>
                            <th class="py-3">Topik</th>
                            <th class="py-3">Status</th>
                            @if(Auth::check())
                                <th class="py-3">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($konselings as $index => $k)
                            <tr>
                                <td class="align-middle">{{ $index+1 }}</td>
                                <td class="align-middle">{{ $k->nama_pengaju ?? $k->nama_lengkap ?? 'Tidak diketahui' }}</td>
                                <td class="align-middle">{{ $k->nama_konselor ?? 'Belum ditentukan' }}</td>
                                <td class="align-middle">
                                    <i class="far fa-calendar-alt me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($k->jadwal)->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($k->jadwal)->format('H:i') }}
                                    </small>
                                </td>
                                <td class="align-middle">{{ $k->topik ?? '-' }}</td>
                                <td class="align-middle">
                                    @if($k->status == 'menunggu')
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                            <i class="fas fa-hourglass-half me-1"></i> Menunggu
                                        </span>
                                    @elseif($k->status == 'dijadwalkan')
                                        <span class="badge rounded-pill bg-success px-3 py-2">
                                            <i class="fas fa-calendar-check me-1"></i> Dijadwalkan
                                        </span>
                                    @elseif($k->status == 'selesai')
                                        <span class="badge rounded-pill bg-info px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i> Selesai
                                        </span>
                                    @elseif($k->status == 'dibatalkan')
                                        <span class="badge rounded-pill bg-danger px-3 py-2">
                                            <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary px-3 py-2">
                                            <i class="fas fa-info-circle me-1"></i> {{ ucfirst($k->status) }}
                                        </span>
                                    @endif
                                </td>
                                @if(Auth::check() && (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || (isset($k->user_id) && Auth::user()->id == $k->user_id)))
                                    <td class="align-middle">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('konseling.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('konseling.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection