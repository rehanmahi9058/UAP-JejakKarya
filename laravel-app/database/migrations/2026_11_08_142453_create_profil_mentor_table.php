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
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('bidang_karier_id')->nullable()->constrained('bidang_karier')->nullOnDelete();
    $table->string('jabatan')->nullable();
    $table->integer('tahun_pengalaman')->nullable();
    $table->text('pengalaman_kerja')->nullable();
    $table->string('topik_mentoring')->nullable();
    $table->enum('status_verifikasi', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
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
