<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Data pribadi
            $table->string('nik', 50)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('ttl')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 30)->nullable();
            $table->string('ip_address', 45)->nullable(); // IPv4/IPv6 support

            // Data akademik / pekerjaan
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->string('angkatan', 20)->nullable();
            $table->string('pendidikan_terakhir', 100)->nullable();
            $table->text('pengalaman')->nullable();

            // File dan media
            $table->string('foto_profil')->nullable();
            $table->string('cv')->nullable(); // path ke file CV
            $table->string('portofolio')->nullable(); // bisa file atau link

            $table->timestamps();
            $table->softDeletes();

            // Relasi ke tabel jurusan
            $table->foreign('id_jurusan')
                ->references('id')
                ->on('jurusan')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
