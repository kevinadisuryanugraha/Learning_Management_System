@extends('layouts.app')

@section('title', 'Tambah Modul')

@section('content')
    <div class="card shadow-sm p-4">
        <h3>➕ Tambah Modul</h3>
        <p>Isi informasi modul baru di bawah ini.</p>

        <form action="{{ route('instruktur.modul.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label fw-semibold">Judul Modul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id_jurusan" class="form-label fw-semibold">Jurusan</label>
                    <select name="id_jurusan" id="id_jurusan" class="form-select">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="id_member_instruktur" class="form-label fw-semibold">Instruktur</label>
                    <select name="id_member_instruktur" id="id_member_instruktur" class="form-select">
                        <option value="">Pilih Instruktur</option>
                        @foreach ($instruktur as $i)
                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="order_index" class="form-label fw-semibold">Urutan Modul</label>
                    <input type="number" name="order_index" id="order_index" class="form-control" value="0">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="is_active" class="form-label fw-semibold">Status</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('instruktur.modul.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
