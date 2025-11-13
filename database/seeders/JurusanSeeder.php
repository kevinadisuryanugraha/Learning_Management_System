<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([
            ['kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Fokus pada pengembangan software dan pemrograman.'],
            ['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer dan Jaringan', 'deskripsi' => 'Fokus pada jaringan komputer dan infrastruktur IT.'],
            ['kode_jurusan' => 'DKV', 'nama_jurusan' => 'Desain Komunikasi Visual', 'deskripsi' => 'Fokus pada desain grafis dan komunikasi visual.'],
        ]);
    }
}
