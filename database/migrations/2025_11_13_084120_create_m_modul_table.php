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
        Schema::create('m_modul', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->unsignedBigInteger('id_member_instruktur')->nullable(); // relasi ke users
            $table->integer('order_index')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            // 🔗 Foreign keys
            $table->foreign('id_jurusan')
                ->references('id')
                ->on('jurusan')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('id_member_instruktur')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_modul');
    }
};
