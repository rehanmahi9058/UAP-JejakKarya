<?php

namespace App\Support;

use App\Models\ProfilMentor;
use Illuminate\Support\Facades\DB;

/**
 * Satu-satunya tempat aturan tampil katalog (dipakai Beranda dan Katalog):
 * mentor terverifikasi + akun aktif + minimal 1 entri terbit + minimal 3 keterampilan.
 */
class KatalogQuery
{
    public static function mentorLayak()
    {
        return ProfilMentor::query()
            ->select('profil_mentor.*')
            // tanggal entri terbit paling baru -> dasar urutan "Terbaru Terbit"
            ->selectSub(
                DB::table('entri_portofolio')->selectRaw('max(created_at)')
                    ->whereColumn('entri_portofolio.user_id', 'profil_mentor.user_id')
                    ->where('entri_portofolio.status', 'terbit'),
                'terbit_terakhir'
            )
            ->with(['user', 'bidangKarier'])
            ->where('status_verifikasi', 'terverifikasi')
            ->whereHas('user', fn ($q) => $q->where('aktif', true))
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))->from('entri_portofolio')
                    ->whereColumn('entri_portofolio.user_id', 'profil_mentor.user_id')
                    ->where('entri_portofolio.status', 'terbit');
            })
            ->whereRaw('(select count(*) from users_keterampilan where users_keterampilan.users_id = profil_mentor.user_id) >= 3');
    }

    /** Entri terbit terbaru + keterampilan untuk sekumpulan user_id (2 query, bukan N+1). */
    public static function lengkapi($userIds): array
    {
        $entri = DB::table('entri_portofolio')
            ->where('status', 'terbit')->whereIn('user_id', $userIds)
            ->orderByDesc('created_at')->get()->groupBy('user_id');

        $skill = DB::table('users_keterampilan')
            ->join('keterampilan', 'keterampilan.id', '=', 'users_keterampilan.keterampilan_id')
            ->whereIn('users_keterampilan.users_id', $userIds)
            ->orderBy('keterampilan.nama_keterampilan')
            ->select('users_keterampilan.users_id', 'keterampilan.nama_keterampilan')
            ->get()->groupBy('users_id');

        $slot = DB::table('slot_mentoring')
            ->join('profil_mentor', 'profil_mentor.id', '=', 'slot_mentoring.profil_mentor_id')
            ->whereIn('profil_mentor.user_id', $userIds)
            ->where('slot_mentoring.status', 'tersedia')
            ->where('slot_mentoring.tanggal', '>=', now()->toDateString())
            ->groupBy('profil_mentor.user_id')
            ->selectRaw('profil_mentor.user_id as uid, count(*) as total')
            ->pluck('total', 'uid');

        return [$entri, $skill, $slot];
    }
}
