@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow-sm p-4">
            <h3>👥 Kelola Pengguna</h3>
            <p>Berikut daftar pengguna dan perannya.</p>

            @if (session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered mt-2">
                <a type="button" class="btn btn-primary w-25 mb-2 ms-auto text-white" data-bs-toggle="modal"
                    data-bs-target="#largeModal">
                    <i class="bx bx-plus"></i> Tambah Pengguna
                </a>
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-white">No</th>
                        <th class="text-white">Nama</th>
                        <th class="text-white">Email</th>
                        <th class="text-white">Role Saat Ini</th>
                        <th class="text-white">Ubah Role</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->roles->isNotEmpty())
                                    <span class="badge bg-success">{{ $user->roles->first()->display_name }}</span>
                                @else
                                    <span class="badge bg-secondary">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.users.assign', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <select name="role" class="form-select">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ $user->roles->first()?->name === $role->name ? 'selected' : '' }}>
                                                    {{ ucfirst($role->display_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </div>
                                </form>
                            </td>
                            <td class="d-flex gap-3 justify-content-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bx bx-pencil"></i>
                                </a>
                                <a type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#showModal{{ $user->id }}">
                                    <i class="bx bx-show text-white"></i>
                                </a>
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="bx bx-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        {{-- modaaallll --}}

                        <!-- Large Modal -->
                        <div class="modal fade" id="showModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold mb-3 text-white">
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
                                                class="rounded border shadow-sm" width="150" height="150"
                                                alt="Foto Profil">
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
                                                <input type="text" class="form-control"
                                                    value="{{ $profile->nik ?? '-' }}" readonly>
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
                                                    value="{{ optional($profile)->ttl ? \Carbon\Carbon::parse(optional($profile)->ttl)->translatedFormat('d F Y') : '-' }}"
                                                    readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Nomor Telepon</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $profile->no_telp ?? '-' }}" readonly>
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
                                            <div class="col-md-4">
                                                <label class="form-label">Jurusan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $profile->jurusan->nama_jurusan ?? '-' }}" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Angkatan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $profile->angkatan ?? '-' }}" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Pendidikan Terakhir</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $profile->pendidikan_terakhir ?? '-' }}" readonly>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Pengalaman</label>
                                                <div class="border rounded p-2"
                                                    style="min-height: 100px; background-color:#f9f9f9;">
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
                                                            <a href="{{ asset('storage/' . $profile->portofolio) }}"
                                                                target="_blank" class="btn btn-outline-info btn-sm">
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
                                            <div class="col-md-4">
                                                <label class="form-label">Alamat IP</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $profile->ip_address ?? '-' }}" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Dibuat Pada</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->created_at->translatedFormat('d F Y H:i') }}"
                                                    readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Di Update Pada</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->updated_at->translatedFormat('d F Y H:i') }}"
                                                    readonly>
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
                    @endforeach
                </tbody>
            </table>

            @include('admin.users.create')
            {{-- @include('admin.users.show') --}}
        </div>
    </div>
@endsection
