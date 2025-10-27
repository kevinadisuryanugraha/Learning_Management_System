<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Laratrust\Models\Role;
use Laratrust\Models\Permission;

class LaratrustSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks supaya bisa truncate dengan aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Bersihkan tabel lama
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        Role::truncate();
        Permission::truncate();
        User::truncate();

        // Aktifkan kembali FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // === ROLES ===
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Akses penuh sistem',
        ]);

        $instrukturRole = Role::create([
            'name' => 'instruktur',
            'display_name' => 'Instruktur',
            'description' => 'Pengajar',
        ]);

        $siswaRole = Role::create([
            'name' => 'siswa',
            'display_name' => 'Siswa',
            'description' => 'Peserta pembelajaran',
        ]);

        $picRole = Role::create([
            'name' => 'pic',
            'display_name' => 'PIC',
            'description' => 'Koordinator',
        ]);

        // === PERMISSIONS ===
        $permissions = [
            ['name' => 'manage-users', 'display_name' => 'Kelola Pengguna'],
            ['name' => 'create-modul', 'display_name' => 'Buat Modul'],
            ['name' => 'view-report', 'display_name' => 'Lihat Laporan'],
            ['name' => 'grade-tugas', 'display_name' => 'Nilai Tugas'],
            ['name' => 'submit-tugas', 'display_name' => 'Kirim Tugas'],
        ];

        foreach ($permissions as $perm) {
            Permission::create($perm);
        }

        // === ASSIGN PERMISSIONS KE ROLE ===
        $adminRole->permissions()->sync(Permission::pluck('id')); // admin dapat semua
        $instrukturRole->permissions()->sync(
            Permission::whereIn('name', ['create-modul', 'grade-tugas', 'view-report'])->pluck('id')
        );
        $siswaRole->permissions()->sync(
            Permission::where('name', 'submit-tugas')->pluck('id')
        );
        $picRole->permissions()->sync(
            Permission::where('name', 'view-report')->pluck('id')
        );

        // === USERS ===
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('smkn10dkijakarta'),
        ]);
        $admin->roles()->sync([$adminRole->id]);

        $instruktur = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@lms.com',
            'password' => Hash::make('12345678'),
        ]);
        $instruktur->roles()->sync([$instrukturRole->id]);

        $siswa = User::create([
            'name' => 'Kevin Adisurya',
            'email' => 'kevin@lms.com',
            'password' => Hash::make('12345678'),
        ]);
        $siswa->roles()->sync([$siswaRole->id]);

        $pic = User::create([
            'name' => 'Fahmi Rahman',
            'email' => 'fahmi@lms.com',
            'password' => Hash::make('12345678'),
        ]);
        $pic->roles()->sync([$picRole->id]);

        // === PESAN SUKSES ===
        $this->command->info('✅ LaratrustSeeder berhasil dijalankan! Semua role, permission, dan user siap digunakan.');
    }
}
