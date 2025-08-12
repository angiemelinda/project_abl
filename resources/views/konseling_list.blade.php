@extends('layouts.app')

@section('title', 'Daftar Konseling Terjadwal')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Konseling Terjadwal</h1>

    @if($konselings->isEmpty())
        <div class="alert alert-warning">Tidak ada konseling yang dijadwalkan.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Pengaju</th>
                    <th>Konselor</th>
                    <th>Jadwal</th>
                    <th>Topik</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($konselings as $index => $k)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $k->nama_pengaju }}</td>
                        <td>{{ $k->nama_konselor }}</td>
                        <td>{{ \Carbon\Carbon::parse($k->jadwal)->format('d M Y H:i') }}</td>
                        <td>{{ $k->topik ?? '-' }}</td>
                        <td>
                            <span class="badge bg-success">{{ ucfirst($k->status) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection