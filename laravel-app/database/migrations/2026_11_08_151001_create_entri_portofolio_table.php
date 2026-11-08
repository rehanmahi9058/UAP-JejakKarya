<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entri_portofolio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('judul_portofolio', 150);
            $table->enum('jenis', ['proyek', 'organisasi','magang','sertifikat','pekerjaan'])->default(null);
            $table->text('deskripsi');
            $table->string('tautan_proyek', 255)->nullable();
            $table->string('gambar')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['draf', 'terbit'])->default('draf');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entri_portofolio');
    }
};