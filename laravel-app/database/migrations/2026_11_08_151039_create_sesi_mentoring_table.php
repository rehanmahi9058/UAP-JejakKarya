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
       Schema::create('sesi_mentoring', function (Blueprint $table) {
    $table->id();
    $table->foreignId('slot_mentoring_id')->unique()->constrained('slot_mentoring')->cascadeOnDelete();
    $table->foreignId('pengguna_id')->constrained('users')->cascadeOnDelete();
    $table->text('tujuan_sesi');
    $table->enum('status', ['diajukan', 'dikonfirmasi', 'selesai', 'dibatalkan', 'ditolak'])->default('diajukan');
    $table->text('catatan_mentor')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_mentoring');
    }
};
