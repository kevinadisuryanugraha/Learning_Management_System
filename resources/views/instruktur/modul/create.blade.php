@extends('layouts.app')

@section('title', 'Tambah Modul')

@section('content')
    <div class="container-xxl py-4">
        <div class="card border-0 shadow-sm rounded-4">
            {{-- Header --}}
            <div
                class="card-header bg-primary text-white rounded-top-4 py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-semibold text-white">
                    ➕ Tambah Modul Baru
                </h4>
                <a href="{{ route('instruktur.modul.index') }}" class="btn btn-light fw-semibold shadow-sm">
                    ⬅ Kembali
                </a>
            </div>

            {{-- Body --}}
            <div class="card-body bg-light rounded-bottom-4 px-4 py-4">
                <p class="text-muted mb-4">
                    Isi informasi lengkap untuk membuat modul pembelajaran baru.
                </p>

                {{-- Form tambah modul --}}
                <form action="{{ route('instruktur.modul.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row g-4">
                        {{-- Judul --}}
                        <div class="col-md-6">
                            <label for="judul" class="form-label fw-semibold">Judul Modul <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control shadow-sm"
                                placeholder="Contoh: Pemrograman Dasar" required>
                            <div class="invalid-feedback">Judul modul wajib diisi.</div>
                        </div>

                        {{-- Urutan --}}
                        <div class="col-md-3">
                            <label for="order_index" class="form-label fw-semibold">Urutan Modul</label>
                            <input type="number" name="order_index" id="order_index" class="form-control shadow-sm"
                                value="0" min="0">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-3">
                            <label for="is_active" class="form-label fw-semibold">Status</label>
                            <select name="is_active" id="is_active" class="form-select shadow-sm">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Modul</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control shadow-sm"
                                placeholder="Tuliskan deskripsi singkat mengenai isi modul..."></textarea>
                        </div>

                        {{-- Jurusan --}}
                        <div class="col-md-6">
                            <label for="id_jurusan" class="form-label fw-semibold">Jurusan</label>
                            <select name="id_jurusan" id="id_jurusan" class="form-select shadow-sm">
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Instruktur --}}
                        <div class="col-md-6">
                            <label for="id_member_instruktur" class="form-label fw-semibold">Instruktur</label>
                            <select name="id_member_instruktur" id="id_member_instruktur" class="form-select shadow-sm">
                                <option value="">Pilih Instruktur</option>
                                @foreach ($instruktur as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                            💾 Simpan Modul
                        </button>
                        <a href="{{ route('instruktur.modul.index') }}"
                            class="btn btn-secondary px-4 py-2 fw-semibold shadow-sm ms-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Validasi Form --}}
    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
