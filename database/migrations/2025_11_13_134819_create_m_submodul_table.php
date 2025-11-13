<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_submodul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modul_id');
            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();
            $table->integer('order_index')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            // Relasi ke tabel m_modul
            $table->foreign('modul_id')
                ->references('id')
                ->on('m_modul')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_submodul');
    }
};
