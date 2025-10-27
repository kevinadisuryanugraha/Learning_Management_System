@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="card shadow-sm p-4">
        <h3>👥 Kelola Pengguna</h3>
        <p>Berikut daftar pengguna dan perannya.</p>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role Saat Ini</th>
                    <th>Ubah Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
