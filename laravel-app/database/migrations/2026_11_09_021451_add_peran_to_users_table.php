<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'peran')) {
                $table->enum('peran', ['pengguna', 'mentor', 'admin'])->default('pengguna')->after('password');
            }
            if (! Schema::hasColumn('users', 'aktif')) {
                $table->boolean('aktif')->default(true)->after('peran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $kolom = array_filter(['peran', 'aktif'], fn ($k) => Schema::hasColumn('users', $k));
            if ($kolom) {
                $table->dropColumn($kolom);
            }
        });
    }
};