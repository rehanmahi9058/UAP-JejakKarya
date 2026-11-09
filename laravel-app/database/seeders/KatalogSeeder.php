<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KatalogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach (['UI/UX Design', 'Web Development', 'Data Analyst'] as $nama) {
            DB::table('bidang_karier')->updateOrInsert(['nama' => $nama], ['created_at' => $now, 'updated_at' => $now]);
        }
        $bidang = DB::table('bidang_karier')->pluck('id', 'nama');

        foreach (['Figma', 'User Research', 'Prototyping', 'Laravel', 'PHP', 'MySQL', 'Python', 'SQL', 'Tableau'] as $s) {
            DB::table('keterampilan')->updateOrInsert(['nama_keterampilan' => $s], ['created_at' => $now, 'updated_at' => $now]);
        }
        $skill = DB::table('keterampilan')->pluck('id', 'nama_keterampilan');

        $mentors = [
            // Memenuhi syarat katalog
            ['Dian Prameswari', 'dian@contoh.test', 'Senior Product Designer', 'UI/UX Design', 'Studi kasus, portofolio desain, dan wawancara kerja', 'terverifikasi',
                ['Figma', 'User Research', 'Prototyping'],
                [['Redesain Aplikasi Finansial', 'proyek', 'terbit'], ['Sistem Desain Aplikasi Kesehatan', 'proyek', 'terbit']]],
            ['Raka Aditya', 'raka@contoh.test', 'Backend Engineer', 'Web Development', 'Laravel, REST API, dan basis data', 'terverifikasi',
                ['Laravel', 'PHP', 'MySQL'],
                [['Platform Reservasi Online', 'proyek', 'terbit']]],
            ['Sari Wulandari', 'sari@contoh.test', 'Data Analyst', 'Data Analyst', 'Analisis data dan dashboard visualisasi', 'terverifikasi',
                ['Python', 'SQL', 'Tableau'],
                [['Dashboard Penjualan Ritel', 'proyek', 'terbit']]],
            // Tidak memenuhi syarat (untuk menguji aturan bisnis)
            ['Budi Santoso', 'budi@contoh.test', 'Frontend Developer', 'Web Development', 'HTML, CSS, JavaScript', 'terverifikasi',
                ['PHP', 'MySQL'],   // keterampilan kurang dari 3
                [['Landing Page UMKM', 'proyek', 'terbit']]],
            ['Tono Wijaya', 'tono@contoh.test', 'UI Designer', 'UI/UX Design', 'Desain antarmuka', 'menunggu',   // belum terverifikasi
                ['Figma', 'Prototyping', 'User Research'],
                [['Aplikasi Kuliner', 'proyek', 'terbit']]],
            ['Lina Marlina', 'lina@contoh.test', 'Data Scientist', 'Data Analyst', 'Machine learning dasar', 'terverifikasi',
                ['Python', 'SQL', 'Tableau'],
                [['Prediksi Harga Rumah', 'proyek', 'draf']]],   // belum ada entri terbit
        ];

        foreach ($mentors as [$nama, $email, $jabatan, $bid, $topik, $status, $skills, $entri]) {
            DB::table('users')->updateOrInsert(['email' => $email], [
                'name' => $nama, 'password' => Hash::make('password'),
                'peran' => 'mentor', 'aktif' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $uid = DB::table('users')->where('email', $email)->value('id');

            DB::table('profil_mentor')->updateOrInsert(['user_id' => $uid], [
                'bidang_karier_id' => $bidang[$bid], 'jabatan' => $jabatan,
                'tahun_pengalaman' => 5, 'topik_mentoring' => $topik,
                'status_verifikasi' => $status,
                'created_at' => $now, 'updated_at' => $now,
            ]);

            DB::table('users_keterampilan')->where('users_id', $uid)->delete();
            foreach ($skills as $s) {
                DB::table('users_keterampilan')->insert([
                    'users_id' => $uid, 'keterampilan_id' => $skill[$s], 'level' => 'menengah',
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }

            DB::table('entri_portofolio')->where('user_id', $uid)->delete();
            foreach ($entri as [$judul, $jenis, $st]) {
                DB::table('entri_portofolio')->insert([
                    'user_id' => $uid, 'judul_portofolio' => $judul, 'jenis' => $jenis,
                    'deskripsi' => 'Proyek ini mengerjakan ' . strtolower($judul) . ' dari riset kebutuhan sampai hasil akhir yang siap dipakai.',
                    'tanggal_mulai' => '2025-01-15', 'tanggal_selesai' => '2025-05-30',
                    'status' => $st, 'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }
    }
}