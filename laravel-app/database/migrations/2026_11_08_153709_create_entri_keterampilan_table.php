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
        Schema::create('entri_keterampilan', function (Blueprint $table) {
            $table->foreignId('entri_portofolio_id')
              ->constrained('entri_portofolio')
              ->cascadeOnDelete();
            
            $table->foreignId('keterampilan_id')
              ->constrained('keterampilan')
              ->cascadeOnDelete();
            
            $table->primary(['entri_portofolio_id', 'keterampilan_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entri_keterampilan');
    }
};
