<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@jejakkarya.test']);
        $admin->name = 'Admin JejakKarya';
        $admin->password = Hash::make('admin12345');
        $admin->peran = 'admin';
        $admin->aktif = true;
        $admin->save();
    }
}
