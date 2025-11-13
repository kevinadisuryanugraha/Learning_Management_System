<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman register.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru.
     */

    public function store(Request $request): RedirectResponse
    {
        try {
            // Validasi data
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Pastikan role 'siswa' ada, cari hanya berdasarkan 'name'
            $role = Role::firstOrCreate(
                ['name' => 'siswa'],
                [
                    'display_name' => 'Siswa',
                    'description' => 'Akses default untuk user siswa',
                ]
            );

            // Hubungkan user ke role 'siswa'
            $user->attachRole($role);

            // Event Laravel bawaan
            event(new Registered($user));

            // Redirect dengan pesan sukses
            return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
