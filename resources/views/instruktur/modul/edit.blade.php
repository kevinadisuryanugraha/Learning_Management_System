@extends('layouts.app')

@section('title', 'Edit Modul')

@section('content')
    <div class="card shadow-sm p-4">
        <h3>✏️ Edit Modul</h3>
        <p>Perbarui informasi modul di bawah ini.</p>

        <form action="{{ route('instruktur.modul.update', $modul->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="judul" class="form-label fw-semibold">Judul Modul</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ $modul->judul }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control">{{ $modul->deskripsi }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id_jurusan" class="form-label fw-semibold">Jurusan</label>
                    <select name="id_jurusan" id="id_jurusan" class="form-select">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $j)
                            <option value="{{ $j->id }}" {{ $modul->id_jurusan == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="id_member_instruktur" class="form-label fw-semibold">Instruktur</label>
                    <select name="id_member_instruktur" id="id_member_instruktur" class="form-select">
                        <option value="">Pilih Instruktur</option>
                        @foreach ($instruktur as $i)
                            <option value="{{ $i->id }}"
                                {{ $modul->id_member_instruktur == $i->id ? 'selected' : '' }}>
                                {{ $i->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="order_index" class="form-label fw-semibold">Urutan Modul</label>
                    <input type="number" name="order_index" id="order_index" class="form-control"
                        value="{{ $modul->order_index }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="is_active" class="form-label fw-semibold">Status</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1" {{ $modul->is_active ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$modul->is_active ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="{{ route('instruktur.modul.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
