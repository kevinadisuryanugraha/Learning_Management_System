<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Field yang boleh diisi secara mass-assignment.
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'nik',
        'jenis_kelamin',
        'ttl',
        'alamat',
        'no_telp',
        'id_jurusan',
        'angkatan',
        'pendidikan_terakhir',
        'pengalaman',
        'cv',
        'portofolio',
        'foto_profil',
    ];

    /**
     * Field yang akan dianggap sebagai tipe data khusus.
     */
    protected $casts = [
        'ttl' => 'date',
    ];

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel jurusan.
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    /**
     * Helper untuk mendapatkan URL foto profil.
     */
    public function getFotoProfilUrlAttribute()
    {
        if ($this->foto_profil && file_exists(storage_path('app/public/' . $this->foto_profil))) {
            return asset('storage/' . $this->foto_profil);
        }

        return asset('assets/assets/img/avatars/1.png'); // fallback default
    }

    /**
     * Helper untuk mendapatkan tipe portofolio (file atau link).
     */
    public function getPortofolioTypeAttribute()
    {
        return filter_var($this->portofolio, FILTER_VALIDATE_URL) ? 'link' : 'file';
    }
}
