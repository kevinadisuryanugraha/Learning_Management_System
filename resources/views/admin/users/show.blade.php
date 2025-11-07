<!-- Large Modal -->
<div class="modal fade" id="showModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">👥 Detail Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
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
                <div class="row">
                    <div class="col mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="col mb-3">
                        <label for="jurusuran" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusuran" name="jurusuran"
                            value="{{ $user->id_jurusuran }}">
                    </div>
                    <div class="col mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <input type="jenis_kelamin" class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                    </div>
                    <div class="col mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ $user->nik }}">
                    </div>
                    <div class="col mb-3">
                        <label for="angkatan" class="form-label">Angkatan</label>
                        <input type="text" class="form-control" id="angkatan" name="angkatan"
                            value="{{ $user->angkatan }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            required>
                    </div>
                    <div class="col mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30"
                            rows="10">{{ $user->alamat }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                            value="{{ $user->tempat_lahir }}" required>
                    </div>
                    <div class="col mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ $user->tanggal_lahir }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="no_telp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $user->no_telp }}"
                            required>
                    </div>
                    <div class="col mb-3">
                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                        <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir"
                            value="{{ $user->pendidikan_terakhir }}" required>
                    </div>
                    <div class="col mb-3">
                        <label for="pengalaman" class="form-label">Pengalaman</label>
                        <input type="text" class="form-control" id="pengalaman" name="pengalaman"
                            value="{{ $user->pengalaman }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
