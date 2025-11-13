<!-- Large Modal -->
<div class="modal fade" id="showModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    👥 Detail Pengguna - {{ $user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @php
                    $profile = $user->profile;
                @endphp

                {{-- FOTO PROFIL --}}
                <div class="text-center mb-4">
                    <img src="{{ $profile && $profile->foto_profil ? asset('storage/' . $profile->foto_profil) : asset('assets/assets/img/avatars/1.png') }}"
                        class="rounded-circle border shadow-sm" width="120" height="120" alt="Foto Profil">
                    <h6 class="mt-2 mb-0 fw-bold">{{ $user->name }}</h6>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>

                <hr>

                {{-- ROLE --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Role Pengguna</label>
                    <p class="form-control-plaintext text-capitalize">
                        {{ $user->roles->first()->display_name ?? 'Belum diset' }}
                    </p>
                </div>

                {{-- DATA PRIBADI --}}
                <h6 class="fw-bold text-primary mb-3">🧍 Data Pribadi</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" value="{{ $profile->nik ?? '-' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control"
                            value="{{ optional($profile)->jenis_kelamin === 'L' ? 'Laki-laki' : (optional($profile)->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control"
                            value="{{ $profile->ttl ? \Carbon\Carbon::parse($profile->ttl)->translatedFormat('d F Y') : '-' }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" value="{{ $profile->no_telp ?? '-' }}" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="2" readonly>{{ $profile->alamat ?? '-' }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                {{-- DATA AKADEMIK --}}
                <h6 class="fw-bold text-primary mb-3">🎓 Data Akademik</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Jurusan</label>
                        <input type="text" class="form-control" value="{{ $profile->jurusan->nama_jurusan ?? '-' }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Angkatan</label>
                        <input type="text" class="form-control" value="{{ $profile->angkatan ?? '-' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <input type="text" class="form-control" value="{{ $profile->pendidikan_terakhir ?? '-' }}"
                            readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Pengalaman</label>
                        <div class="border rounded p-2" style="min-height: 100px; background-color:#f9f9f9;">
                            {!! $profile->pengalaman ?? '<span class="text-muted">Belum ada data pengalaman</span>' !!}
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- BERKAS & PORTOFOLIO --}}
                <h6 class="fw-bold text-primary mb-3">📁 Berkas & Portofolio</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Curriculum Vitae (CV)</label>
                        @if ($profile && $profile->cv)
                            <p>
                                <a href="{{ asset('storage/' . $profile->cv) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-file me-1"></i> Lihat CV
                                </a>
                            </p>
                        @else
                            <p class="text-muted">Belum mengunggah CV</p>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Portofolio</label>
                        @if ($profile && $profile->portofolio)
                            @if (Str::startsWith($profile->portofolio, ['http://', 'https://']))
                                <p>
                                    <a href="{{ $profile->portofolio }}" target="_blank"
                                        class="btn btn-outline-success btn-sm">
                                        🌐 Lihat Portofolio Website
                                    </a>
                                </p>
                            @else
                                <p>
                                    <a href="{{ asset('storage/' . $profile->portofolio) }}" target="_blank"
                                        class="btn btn-outline-info btn-sm">
                                        📂 Lihat File Portofolio
                                    </a>
                                </p>
                            @endif
                        @else
                            <p class="text-muted">Belum mengunggah portofolio</p>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                {{-- INFORMASI SISTEM --}}
                <h6 class="fw-bold text-primary mb-3">🖥️ Informasi Sistem</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Alamat IP</label>
                        <input type="text" class="form-control" value="{{ $profile->ip_address ?? '-' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Dibuat Pada</label>
                        <input type="text" class="form-control"
                            value="{{ $user->created_at->translatedFormat('d F Y H:i') }}" readonly>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
