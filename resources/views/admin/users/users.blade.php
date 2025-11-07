@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
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
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role Saat Ini</th>
                <th>Ubah Role</th>
                <th>Action</th>
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
                        <button type="submit" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></button>
                    </form>
                </td>
            </tr>
            {{-- modaaallll --}}
            <div class="modal fade" id="showModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel3">👥 Detail Pengguna</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select" disabled>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->roles->first()?->name === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->display_name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="jurusuran" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusuran" name="jurusuran"
                                        value="{{ $user->id_jurusuran }}" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <input type="jenis_kelamin" class="form-control" id="jenis_kelamin"
                                        name="jenis_kelamin" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik"
                                        value="{{ $user->nik }}" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="angkatan" class="form-label">Angkatan</label>
                                    <input type="text" class="form-control" id="angkatan" name="angkatan"
                                        value="{{ $user->angkatan }}" readOnly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" readOnly required>
                                    <span class="text-danger">*) Isi jika ingin mengubah password</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" cols="30"
                                        rows="10" readonly>{{ $user->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                        value="{{ $user->tempat_lahir }}" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                        value="{{ $user->tanggal_lahir }}" readOnly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="no_telp" class="form-label">Nomor HP</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp"
                                        value="{{ $user->no_telp }}" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                    <input type="text" class="form-control" id="pendidikan_terakhir"
                                        name="pendidikan_terakhir" value="{{ $user->pendidikan_terakhir }}" readOnly>
                                </div>
                                <div class="col mb-3">
                                    <label for="pengalaman" class="form-label">Pengalaman</label>
                                    <input type="text" class="form-control" id="pengalaman" name="pengalaman"
                                        value="{{ $user->pengalaman }}" readOnly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a type="button" href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-secondary">Ubah Data</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    @include('admin.users.create')
    {{-- @include('admin.users.show') --}}
</div>
@endsection
