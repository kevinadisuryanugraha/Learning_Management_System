@extends('layouts.app')

@section('title', 'Submodul • ' . $modul->judul)

@section('content')
    <div class="container-xxl py-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div
                class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 rounded-top-4">
                <h5 class="mb-0">
                    📘 <strong class="text-white">Submodul : {{ $modul->judul }}</strong>
                </h5>
                <a href="{{ route('instruktur.modul.index') }}" class="btn btn-light btn-sm fw-semibold">
                    ⬅ Kembali ke Modul
                </a>
            </div>

            <div class="card-body bg-light mt-4">
                {{-- Alert success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        ✅ {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Form Tambah Submodul --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 text-primary">+ Tambah Submodul Baru</h6>
                        <form action="{{ route('instruktur.submodul.store', $modul->id) }}" method="POST">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Judul Submodul</label>
                                    <input type="text" name="judul" class="form-control shadow-sm"
                                        placeholder="Masukkan judul submodul..." required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold">Deskripsi</label>
                                    <input type="text" name="deskripsi" class="form-control shadow-sm"
                                        placeholder="Tuliskan deskripsi singkat...">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Urutan</label>
                                    <input type="number" name="order_index" class="form-control shadow-sm" min="0">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Daftar Submodul --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary mb-3">📋 Daftar Submodul</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Urutan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($modul->submodul as $index => $sub)
                                        <tr>
                                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                            <td class="fw-semibold">{{ $sub->judul }}</td>
                                            <td class="text-muted">{{ $sub->deskripsi ?? '-' }}</td>
                                            <td class="text-center">{{ $sub->order_index }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $sub->is_active ? 'success' : 'secondary' }}">
                                                    {{ $sub->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    {{-- Edit --}}
                                                    <button class="btn btn-sm btn-warning rounded-3" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $sub->id }}">
                                                        ✏️
                                                    </button>

                                                    {{-- Hapus --}}
                                                    <form action="{{ route('instruktur.submodul.destroy', $sub->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin hapus submodul ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger rounded-3">🗑</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal Edit Submodul --}}
                                        <div class="modal fade" id="editModal{{ $sub->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-4 border-0 shadow-sm">
                                                    <form action="{{ route('instruktur.submodul.update', $sub->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-semibold mb-3 text-white">✏️ Edit
                                                                Submodul</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Judul</label>
                                                                <input type="text" name="judul" class="form-control"
                                                                    value="{{ $sub->judul }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control">{{ $sub->deskripsi }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Urutan</label>
                                                                <input type="number" name="order_index"
                                                                    class="form-control" value="{{ $sub->order_index }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Status</label>
                                                                <select name="is_active" class="form-select">
                                                                    <option value="1"
                                                                        {{ $sub->is_active ? 'selected' : '' }}>Aktif
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ !$sub->is_active ? 'selected' : '' }}>Nonaktif
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                🚫 Belum ada submodul. Tambahkan submodul baru di atas.
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
