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
        Schema::create('slot_mentoring', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profil_mentor_id')
                  ->constrained('profil_mentor')
                  ->cascadeOnDelete();

            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('tautan_pertemuan',255);

            $table->enum('status', ['tersedia', 'dipesan','ditutup'])->default('tersedia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_mentoring');
    }
};
