@extends('layouts.app')

@section('title', 'Kelola Konselor')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Kelola Konselor</h4>
                    <a href="{{ route('users.create') }}" class="btn btn-light">Tambah Konselor</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($konselors as $konselor)
                                <tr>
                                    <td>{{ $konselor->id }}</td>
                                    <td>{{ $konselor->name }}</td>
                                    <td>{{ $konselor->email }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('users.edit', $konselor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('users.destroy', $konselor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konselor ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data konselor</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection