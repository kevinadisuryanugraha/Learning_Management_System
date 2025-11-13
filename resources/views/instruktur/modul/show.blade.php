@extends('layouts.app')

@section('title', 'Detail Modul')

@section('content')
    <div class="card shadow-sm p-4">
        <h3>📘 Detail Modul</h3>

        <table class="table table-bordered mt-3">
            <tr>
                <th>Judul Modul</th>
                <td>{{ $modul->judul }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{!! nl2br(e($modul->deskripsi)) !!}</td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td>{{ $modul->jurusan->nama_jurusan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Instruktur</th>
                <td>{{ $modul->instruktur->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Urutan</th>
                <td>{{ $modul->order_index }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-{{ $modul->is_active ? 'success' : 'secondary' }}">
                        {{ $modul->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Dibuat pada</th>
                <td>{{ $modul->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Diperbarui</th>
                <td>{{ $modul->updated_at->format('d M Y H:i') }}</td>
            </tr>
        </table>

        <div class="text-end mt-3">
            <a href="{{ route('admin.modul.edit', $modul->id) }}" class="btn btn-warning">✏️ Edit</a>
            <a href="{{ route('admin.modul.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
