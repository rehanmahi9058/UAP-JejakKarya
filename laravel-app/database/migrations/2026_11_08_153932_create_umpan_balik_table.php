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
        Schema::create('umpan_balik', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entri_portofolio_id')
                  ->constrained('entri_portofolio')
                  ->cascadeOnDelete();

            $table->foreignId('mentor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->text('isi_umpan_balik');

            $table->unsignedTinyInteger('skor_relevansi')
                  ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umpan_balik');
    }
};
