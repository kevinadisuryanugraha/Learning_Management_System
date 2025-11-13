<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil user yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();

        // Buat profil kosong jika belum ada
        $profile = $user->profile ?? Profile::create([
            'user_id' => $user->id,
        ]);

        // Ambil semua data jurusan untuk dropdown
        $jurusan = Jurusan::all();

        return view('profile.show', compact('user', 'profile', 'jurusan'));
    }

    /**
     * Update data profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? Profile::create(['user_id' => $user->id]);

        $data = $request->validate([
            'nik' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'ttl' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:30',
            'id_jurusan' => 'nullable|integer',
            'angkatan' => 'nullable|string|max:20',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'pengalaman' => 'nullable|string',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'portofolio_tipe' => 'nullable|in:file,link',
            'portofolio_file' => 'nullable|mimes:pdf,zip,rar,ppt,pptx,doc,docx|max:5120',
            'portofolio_link' => 'nullable|url|max:255',
            'foto_profil' => 'nullable|string', // base64 string dari kamera
        ]);

        // ✅ Handle foto profil (base64)
        if (!empty($data['foto_profil']) && str_starts_with($data['foto_profil'], 'data:image')) {
            if ($profile->foto_profil && Storage::disk('public')->exists($profile->foto_profil)) {
                Storage::disk('public')->delete($profile->foto_profil);
            }

            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $data['foto_profil']);
            $imageName = 'profile_photos/' . uniqid() . '.png';
            Storage::disk('public')->put($imageName, base64_decode($imageData));
            $data['foto_profil'] = $imageName;
        } else {
            unset($data['foto_profil']);
        }

        // ✅ Upload CV
        if ($request->hasFile('cv')) {
            if ($profile->cv && Storage::disk('public')->exists($profile->cv)) {
                Storage::disk('public')->delete($profile->cv);
            }
            $data['cv'] = $request->file('cv')->store('profile_cv', 'public');
        }

        // ✅ Portofolio - bisa link atau file
        if ($data['portofolio_tipe'] === 'file' && $request->hasFile('portofolio_file')) {
            if ($profile->portofolio && Storage::disk('public')->exists($profile->portofolio)) {
                Storage::disk('public')->delete($profile->portofolio);
            }
            $data['portofolio'] = $request->file('portofolio_file')->store('profile_portofolio', 'public');
        } elseif ($data['portofolio_tipe'] === 'link' && !empty($data['portofolio_link'])) {
            // Simpan sebagai URL
            $data['portofolio'] = $data['portofolio_link'];
        }

        // ✅ Simpan IP address
        $data['ip_address'] = $request->ip();

        // Bersihkan kolom tambahan agar tidak bentrok
        unset($data['portofolio_file'], $data['portofolio_link'], $data['portofolio_tipe']);

        $profile->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
