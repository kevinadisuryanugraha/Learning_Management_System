{{-- @extends('layouts.app') --}}

{{-- @section('title', 'Kelola Pengguna') --}}

{{-- @section('content') --}}
{{-- <div class="card shadow-sm p-4">
    <h3>👥 Tambah User</h3>
    <p>Silakan isi informasi user baru.</p>

    @if (session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-6 mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select">
                <option value="">Pilih Role</option>
                @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ ucfirst($role->display_name) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-6 mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
    </div>
    <button type="submit" class="btn w-25 btn-primary ms-auto">Tambah Pengguna</button>
    <a href="{{url()->previous()}}" class="text-muted btn btn-close-white">Kembali</a>
</form>
</div> --}}
{{-- @endsection --}}


<!-- Large Modal -->
<form action="{{ route('admin.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">👥 Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Silahkan Masukan Nama" required>
                        </div>
                        <div class="col mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->display_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Silahkan Masukan Email" required>
                        </div>
                        <div class="col mb-0">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Silahkan Masukan Password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                        Keluar
                    </button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>
