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

    public function manageUsers()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
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
