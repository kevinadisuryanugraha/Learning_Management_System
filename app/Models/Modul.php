<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'm_modul';

    protected $fillable = [
        'judul',
        'deskripsi',
        'id_jurusan',
        'id_member_instruktur',
        'order_index',
        'is_active',
    ];

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    // Relasi ke instruktur (user)
    public function instruktur()
    {
        return $this->belongsTo(User::class, 'id_member_instruktur');
    }
}
