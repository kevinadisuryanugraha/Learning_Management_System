@extends('layouts.app')

@section('title', 'Kelola Modul')

@section('content')
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>📘 Daftar Modul</h3>
            <a href="{{ route('instruktur.modul.create') }}" class="btn btn-primary">+ Tambah Modul</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Jurusan</th>
                    <th>Instruktur</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modul as $m)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $m->judul }}</td>
                        <td>{{ $m->jurusan->nama_jurusan ?? '-' }}</td>
                        <td>{{ $m->instruktur->name ?? '-' }}</td>
                        <td>{{ $m->order_index }}</td>
                        <td>
                            <span class="badge bg-{{ $m->is_active ? 'success' : 'secondary' }}">
                                {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('instruktur.modul.edit', $m->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('instruktur.modul.destroy', $m->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
