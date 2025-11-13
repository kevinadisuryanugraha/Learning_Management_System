@extends('layouts.app')

@section('title', 'Kelola Modul')

@section('content')
    <div class="container-xxl py-4">
        <div class="card border-0 shadow-sm rounded-4">
            {{-- Header --}}
            <div
                class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4 py-3">
                <h4 class="mb-0 fw-semibold text-white">
                    📘 Manajemen Modul
                </h4>
                <a href="{{ route('instruktur.modul.create') }}" class="btn btn-light fw-semibold shadow-sm">
                    + Tambah Modul
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body bg-light rounded-bottom-4">
                {{-- Alert success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        ✅ {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Tabel daftar modul --}}
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary mb-3">📋 Daftar Modul Pembelajaran</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center" width="50">#</th>
                                        <th>Judul Modul</th>
                                        <th>Jurusan</th>
                                        <th>Instruktur</th>
                                        <th class="text-center" width="100">Urutan</th>
                                        <th class="text-center" width="100">Status</th>
                                        <th class="text-center" width="200">Aksi</th>
                                        <th class="text-center" width="160">Submodul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($modul as $m)
                                        <tr>
                                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                            <td class="fw-semibold">{{ $m->judul }}</td>
                                            <td>{{ $m->jurusan->nama_jurusan ?? '-' }}</td>
                                            <td>{{ $m->instruktur->name ?? '-' }}</td>
                                            <td class="text-center">{{ $m->order_index }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $m->is_active ? 'success' : 'secondary' }}">
                                                    {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('instruktur.modul.edit', $m->id) }}"
                                                        class="btn btn-sm btn-warning rounded-3 px-3 shadow-sm">
                                                        ✏️ Edit
                                                    </a>
                                                    <form action="{{ route('instruktur.modul.destroy', $m->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus modul ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger rounded-3 shadow-sm px-3">
                                                            🗑 Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('instruktur.submodul.index', $m->id) }}"
                                                    class="btn btn-sm btn-info rounded-3 shadow-sm px-3">
                                                    📚 Kelola
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                🚫 Belum ada modul yang ditambahkan.
                                            </td>
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
