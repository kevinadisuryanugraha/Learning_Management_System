@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow-sm p-4">
            <h3>✏️ Edit Pengguna</h3>
            <p>Perbarui informasi pengguna di bawah ini.</p>

            @if (session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                class="mt-3">
                @csrf
                @method('PUT')

                {{-- ROLE --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->roles->first()?->name === $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->display_name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                            required>
                    </div>
                </div>

                {{-- INFORMASI DASAR --}}
                <div class="row">

                    <div class="col mb-3">
                        <label for="id_jurusan" class="form-label">Jurusan</label>
                        <select id="id_jurusan" name="id_jurusan" class="form-select">
                            <option value="">Pilih Jurusan</option>
                            @foreach ($jurusan as $j)
                                <option value="{{ $j->id }}"
                                    {{ optional($user->profile)->id_jurusan == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                            <option value="" disabled
                                {{ !optional($user->profile)->jenis_kelamin ? 'selected' : '' }}>
                                Pilih</option>
                            <option value="L" {{ optional($user->profile)->jenis_kelamin === 'L' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="P" {{ optional($user->profile)->jenis_kelamin === 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik"
                            value="{{ optional($user->profile)->nik }}">
                    </div>

                    <div class="col mb-3">
                        <label for="angkatan" class="form-label">Angkatan</label>
                        <input type="text" class="form-control" id="angkatan" name="angkatan"
                            value="{{ optional($user->profile)->angkatan }}">
                    </div>
                </div>

                {{-- KONTAK & LOGIN --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $user->email }}" required>
                    </div>
                    <div class="col mb-3">
                        <label for="password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3">{{ optional($user->profile)->alamat }}</textarea>
                    </div>

                    <div class="col mb-3">
                        <label for="ttl" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="ttl" name="ttl"
                            value="{{ optional($user->profile)->ttl ? \Carbon\Carbon::parse($user->profile->ttl)->format('Y-m-d') : '' }}">
                    </div>
                </div>

                {{-- TANGGAL LAHIR --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="no_telp" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                            value="{{ optional($user->profile)->no_telp }}">
                    </div>

                    <div class="col mb-3">
                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                        <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir"
                            value="{{ optional($user->profile)->pendidikan_terakhir }}">
                    </div>
                </div>

                {{-- PENDIDIKAN & PENGALAMAN --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="pengalaman" class="form-label text-center">Pengalaman</label>
                        <textarea class="form-control" id="pengalaman" name="pengalaman" rows="3">{{ optional($user->profile)->pengalaman }}</textarea>
                    </div>
                </div>

                {{-- FILE UPLOAD --}}
                <div class="row">
                    <div class="col mb-3">
                        <label for="cv" class="form-label">CV (PDF, DOC, DOCX)</label>
                        @if (optional($user->profile)->cv)
                            <p><a href="{{ asset('storage/' . optional($user->profile)->cv) }}" target="_blank">📄 Lihat
                                    CV</a></p>
                        @endif
                        <input type="file" class="form-control" id="cv" name="cv"
                            accept=".pdf,.doc,.docx">
                    </div>

                    <div class="col mb-3">
                        <label for="portofolio" class="form-label">Portofolio</label>
                        @if (optional($user->profile)->portofolio && Str::startsWith(optional($user->profile)->portofolio, 'http'))
                            <p><a href="{{ optional($user->profile)->portofolio }}" target="_blank">🌐 Lihat Link
                                    Portofolio</a></p>
                        @elseif(optional($user->profile)->portofolio)
                            <p><a href="{{ asset('storage/' . optional($user->profile)->portofolio) }}"
                                    target="_blank">📁
                                    Lihat File Portofolio</a></p>
                        @endif
                        <input type="file" class="form-control mb-2" id="portofolio_file" name="portofolio_file"
                            accept=".pdf,.zip,.rar,.ppt,.pptx,.doc,.docx">
                        <input type="text" class="form-control" id="portofolio_link" name="portofolio_link"
                            placeholder="Atau masukkan link portofolio"
                            value="{{ Str::startsWith(optional($user->profile)->portofolio, ['http://', 'https://']) ? optional($user->profile)->portofolio : '' }}">
                    </div>
                </div>

                {{-- FOTO PROFIL --}}
                <div class="mb-3">
                    <label for="foto_profil" class="form-label">Foto Profil</label>
                    @if (optional($user->profile)->foto_profil)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . optional($user->profile)->foto_profil) }}" alt="Foto Profil"
                                class="rounded" width="100">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                </div>

                {{-- SIMPAN --}}
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // textarea tinyt
        tinymce.init({
            selector: '#pengalaman',
            height: 300,
            menubar: false,
            plugins: 'lists link image table code help wordcount',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link image | alignleft aligncenter alignright | removeformat | code',
            branding: false,
            content_style: `
        body {
            font-family: "Poppins", sans-serif;
            font-size: 14px;
            color: #333;
        }
        p {
            margin: 0;
        }
    `
        });
    </script>

@endsection
