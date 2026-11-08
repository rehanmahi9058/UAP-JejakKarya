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
        Schema::create('users_keterampilan', function (Blueprint $table) {

            $table->foreignId('users_id')
              ->constrained('users')
              ->cascadeOnDelete();
            
            $table->foreignId('keterampilan_id')
              ->constrained('keterampilan')
              ->cascadeOnDelete();
            
            $table->primary(['users_id', 'keterampilan_id']);

            $table->enum('level', ['pemula', 'menengah','mahir'])->default('pemula');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_keterampilan');
    }
};
