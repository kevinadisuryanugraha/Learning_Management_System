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
        $roles = Role::all();
        return view('admin.users.create', compact('roled'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Mendapatkan semua role
        $jurusan = \App\Models\Jurusan::all();

        return view('admin.users.edit', compact('user', 'roles', 'jurusan')); // Mengirim data user dan roles ke view
    }

    public function update(Request $request, $id)
    {
        $user = User::with('profile')->findOrFail($id);

        // Validasi dasar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
            'nik' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'ttl' => 'nullable|date',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'id_jurusan' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string|max:10',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|string',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'portofolio_file' => 'nullable|mimes:pdf,zip,rar,ppt,pptx,doc,docx|max:5120',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'portofolio_link' => 'nullable|url',
        ]);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Jika ada password baru
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        // Update atau buat profile baru
        $profile = $user->profile ?? new \App\Models\Profile(['user_id' => $user->id]);

        $profile->nik = $request->nik;
        $profile->jenis_kelamin = $request->jenis_kelamin;
        $profile->ttl = $request->ttl;
        $profile->no_telp = $request->no_telp;
        $profile->alamat = $request->alamat;
        $profile->id_jurusan = $request->id_jurusan;
        $profile->angkatan = $request->angkatan;
        $profile->pendidikan_terakhir = $request->pendidikan_terakhir;
        $profile->pengalaman = $request->pengalaman;

        // Upload CV
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public');
            $profile->cv = $cvPath;
        }

        // Upload Portofolio (file)
        if ($request->hasFile('portofolio_file')) {
            $portofolioPath = $request->file('portofolio_file')->store('portofolio', 'public');
            $profile->portofolio = $portofolioPath;
        } elseif ($request->filled('portofolio_link')) {
            $profile->portofolio = $request->portofolio_link;
        }

        // Upload Foto Profil
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('foto_profil', 'public');
            $profile->foto_profil = $fotoPath;
        }

        $profile->save();

        // Update role user
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users')->with('success', 'Data pengguna dan profil berhasil diperbarui.');
    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus');
    }

    public function show($id)
    {
        $user = User::with(['profile.jurusan', 'roles'])->findOrFail($id);
        $roles = Role::all();
        $profile = $user->profile ?? new \App\Models\Profile();

        return view('admin.users.show', compact('user', 'profile', 'roles'));
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
