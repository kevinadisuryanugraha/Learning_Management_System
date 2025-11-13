@extends('layouts.app')

@section('title', 'Manage Profile')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings /</span> Account
        </h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>

                    <div class="card-body text-center">
                        <img src="{{ $profile && $profile->foto_profil ? asset('storage/' . $profile->foto_profil) : asset('assets/assets/img/avatars/1.png') }}"
                            alt="user-avatar" class="d-block rounded object-fit-cover mx-auto"
                            style="width: 120px; height: 120px; object-fit: cover;" id="uploadedAvatar" />

                        <div class="mt-3">
                            <button id="bukaKamera" type="button" class="btn btn-outline-primary me-2">📷 Buka
                                Kamera</button>
                            <button id="ambil" type="button" class="btn btn-success me-2" style="display:none;">Ambil
                                Foto</button>
                            <button id="tutupKamera" type="button" class="btn btn-danger" style="display:none;">Tutup
                                Kamera</button>
                        </div>

                        <div class="mt-3" id="kameraContainer" style="display:none;">
                            <video id="kamera" width="250" height="200" autoplay class="border rounded"></video>
                            <canvas id="hasil" style="display:none;"></canvas>
                        </div>

                        <form id="formAccountSettings" method="POST" action="{{ route('profile.update') }}"
                            enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <input type="hidden" name="foto_profil" id="foto_profil">

                            {{-- =================== FOTO PROFIL =================== --}}
                            <div class="text-center mb-4">

                                <div>
                                    <label for="upload" class="btn btn-primary btn-sm me-2" tabindex="0">
                                        <i class="bx bx-upload me-1"></i> Upload Foto Baru
                                        <input type="file" id="upload" name="foto_profil"
                                            class="account-file-input d-none" accept="image/*" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary btn-sm account-image-reset">
                                        <i class="bx bx-reset me-1"></i> Reset
                                    </button>
                                </div>
                                <p class="text-muted small mt-2 mb-0">Format: JPG/PNG, maksimal 2MB</p>
                            </div>

                            <hr class="my-4">

                            {{-- =================== DATA PRIBADI =================== --}}
                            <h6 class="fw-bold mb-3 text-primary">Data Pribadi</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nik" class="form-label fw-semibold">NIK</label>
                                    <input type="text" id="nik" name="nik" class="form-control"
                                        value="{{ old('nik', $profile->nik ?? '') }}" placeholder="Masukkan NIK Anda">
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L"
                                            {{ ($profile->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-Laki
                                        </option>
                                        <option value="P"
                                            {{ ($profile->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="ttl" class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" id="ttl" name="ttl" class="form-control"
                                        value="{{ old('ttl', isset($profile->ttl) ? \Carbon\Carbon::parse($profile->ttl)->format('Y-m-d') : '') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="no_telp" class="form-label fw-semibold">Nomor Telepon</label>
                                    <input type="text" id="no_telp" name="no_telp" class="form-control"
                                        value="{{ old('no_telp', $profile->no_telp ?? '') }}" placeholder="08xxxxxxxxxx">
                                </div>

                                <div class="col-12">
                                    <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap">{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- =================== DATA AKADEMIK =================== --}}
                            <h6 class="fw-bold mb-3 text-primary">Data Akademik</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="id_jurusan" class="form-label fw-semibold">Jurusan</label>
                                    <select id="id_jurusan" name="id_jurusan" class="form-select">
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ ($profile->id_jurusan ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="angkatan" class="form-label fw-semibold">Angkatan</label>
                                    <input type="text" id="angkatan" name="angkatan" class="form-control"
                                        value="{{ old('angkatan', $profile->angkatan ?? '') }}"
                                        placeholder="Contoh: 2023">
                                </div>

                                <div class="col-md-6">
                                    <label for="pendidikan_terakhir" class="form-label fw-semibold">Pendidikan
                                        Terakhir</label>
                                    <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir"
                                        class="form-control"
                                        value="{{ old('pendidikan_terakhir', $profile->pendidikan_terakhir ?? '') }}"
                                        placeholder="Contoh: SMA / SMK / D3 / S1">
                                </div>

                                <div class="col-12">
                                    <label for="pengalaman" class="form-label fw-semibold">Pengalaman</label>
                                    <textarea id="pengalaman" name="pengalaman" class="form-control"
                                        placeholder="Tuliskan pengalaman kerja, magang, atau proyek yang pernah kamu ikuti...">
        {{ old('pengalaman', $profile->pengalaman ?? '') }}
    </textarea>
                                    <small class="text-muted">Kamu dapat menambahkan teks tebal, miring, daftar, atau
                                        link.</small>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- =================== FILE & PORTOFOLIO =================== --}}
                            <h6 class="fw-bold mb-3 text-primary">Berkas & Portofolio</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="cv" class="form-label fw-semibold">Curriculum Vitae (CV)</label>
                                    <input type="file" id="cv" name="cv" class="form-control"
                                        accept=".pdf,.doc,.docx">
                                    @if ($profile->cv)
                                        <small class="text-success">File saat ini:
                                            <a href="{{ asset('storage/' . $profile->cv) }}" target="_blank">Lihat CV</a>
                                        </small>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Portofolio</label>
                                    <select id="portofolioType" name="portofolio_tipe" class="form-select mb-2">
                                        <option value="file">Upload File</option>
                                        <option value="link">Link Website</option>
                                    </select>

                                    <input type="file" id="portofolioFile" name="portofolio_file"
                                        class="form-control mb-2" accept=".pdf,.zip,.rar,.ppt,.pptx,.doc,.docx">

                                    <input type="url" id="portofolioLink" name="portofolio_link"
                                        class="form-control d-none" placeholder="https://contoh-portofolio.com">

                                    @if ($profile->portofolio)
                                        @if (Str::startsWith($profile->portofolio, ['http://', 'https://']))
                                            <small class="text-success">Link:
                                                <a href="{{ $profile->portofolio }}" target="_blank">Lihat Portofolio</a>
                                            </small>
                                        @else
                                            <small class="text-success">File:
                                                <a href="{{ asset('storage/' . $profile->portofolio) }}"
                                                    target="_blank">Lihat File</a>
                                            </small>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- =================== INFORMASI SISTEM =================== --}}
                            <h6 class="fw-bold mb-3 text-primary">Informasi Sistem</h6>
                            <div class="mb-3 col-md-6">
                                <label for="ip_address" class="form-label fw-semibold">IP Address</label>
                                <input type="text" id="ip_address" name="ip_address" class="form-control"
                                    value="{{ request()->ip() }}" readonly>
                                <small class="text-muted">Alamat IP ini disimpan untuk pelacakan keamanan.</small>
                            </div>

                            {{-- =================== TOMBOL SIMPAN =================== --}}
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-4 me-2">
                                    <i class="bx bx-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bx bx-x me-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== SCRIPT ====================== --}}

    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        const video = document.getElementById('kamera');
        const canvas = document.getElementById('hasil');
        const bukaKamera = document.getElementById('bukaKamera');
        const tutupKamera = document.getElementById('tutupKamera');
        const ambil = document.getElementById('ambil');
        const kameraContainer = document.getElementById('kameraContainer');
        const inputFoto = document.getElementById('foto_profil');
        const uploadedAvatar = document.getElementById('uploadedAvatar');
        let stream;

        // SCRIPT UNTUK PORTOFOLIO SWITCH
        const portofolioType = document.getElementById('portofolioType');
        const portofolioFile = document.getElementById('portofolioFile');
        const portofolioLink = document.getElementById('portofolioLink');

        portofolioType.addEventListener('change', function() {
            if (this.value === 'file') {
                portofolioFile.classList.remove('d-none');
                portofolioLink.classList.add('d-none');
            } else {
                portofolioFile.classList.add('d-none');
                portofolioLink.classList.remove('d-none');
            }
        });


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

        // Buka kamera
        bukaKamera.addEventListener('click', () => {
            kameraContainer.style.display = 'block';
            ambil.style.display = 'inline-block';
            tutupKamera.style.display = 'inline-block';
            bukaKamera.style.display = 'none';

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                })
                .catch(err => alert("Tidak dapat mengakses kamera: " + err.message));
        });

        // Ambil foto
        ambil.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            const dataUrl = canvas.toDataURL('image/png');
            inputFoto.value = dataUrl;
            uploadedAvatar.src = dataUrl;
            alert('📸 Foto berhasil diambil! Klik "Save changes" untuk menyimpan.');
        });

        // Tutup kamera
        tutupKamera.addEventListener('click', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            kameraContainer.style.display = 'none';
            ambil.style.display = 'none';
            tutupKamera.style.display = 'none';
            bukaKamera.style.display = 'inline-block';
        });

        // Preview jika upload manual
        document.getElementById('upload').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadedAvatar.src = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endsection
