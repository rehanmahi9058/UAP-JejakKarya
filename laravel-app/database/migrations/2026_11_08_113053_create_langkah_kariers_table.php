<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('langkah_karier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rencana_karier_id')->constrained('rencana_karier')->cascadeOnDelete();
            $table->string('judul');
            $table->date('target_tanggal')->nullable();
            $table->boolean('selesai')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('langkah_karier');
    }
};