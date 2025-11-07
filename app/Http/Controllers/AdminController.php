<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        $roles = Role::all(); // ✅ Tambahkan ini
        return view('admin.users.create', compact('roles')); // ✅ Kirim $roles ke view
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Mendapatkan semua role

        return view('admin.users.edit', compact('user', 'roles')); // Mengirim data user dan roles ke view
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Perbarui role pengguna
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Mendapatkan semua role

        return view('admin.users.show', compact('user', 'roles')); // Mengirim data user dan roles ke view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
        ]);
        // dd($validate);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->addRole($request->role);

        $roles = Role::all();

        return redirect()->route('admin.users', compact('roles'))->with('success', 'Pengguna baru berhasil ditambahkan');
    }

    public function manageUsers()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.users.users', compact('users', 'roles'));
    }

    public function assignRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles([$request->role]);
        return back()->with('success', 'Role pengguna berhasil diperbarui');
    }

    public function viewReports()
    {
        return view('admin.reports');
    }
}
