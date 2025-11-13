<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submodul extends Model
{
    use HasFactory;

    protected $table = 'm_submodul';

    protected $fillable = [
        'modul_id',
        'judul',
        'deskripsi',
        'order_index',
        'is_active',
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }
}
