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
        Schema::create('profil_mentor', function (Blueprint $table) {
            $table->id();

        // Relasi dengan tabel users
            $table->foreignId('user_id')
              ->unique()
              ->constrained('users')
              ->cascadeOnDelete();

        // Relasi dengan tabel bidang_karir
            $table->foreignId('bidang_karier_id')
              ->constrained('bidang_karier')
              ->cascadeOnDelete();

            $table->string('jabatan');
            $table->text('pengalaman_kerja')->nullable();
            $table->unsignedTinyInteger('tahun_pengalaman')->default(0);
            $table->text('topik_mentoring')->nullable();

            $table->string('status_verifikasi', 30)->default('menunggu');
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamp('diverifikasi_pada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_mentor');
    }
};
