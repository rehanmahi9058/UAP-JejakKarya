<?php

namespace App\Http\Controllers;

use App\Models\BidangKarier;
use App\Models\ProfilMentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    // Aturan bisnis: mentor terverifikasi, akun aktif, minimal 1 entri terbit, minimal 3 keterampilan
    private function mentorLayak()
    {
        return ProfilMentor::query()
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

    public function index(Request $request)
    {
        $query = $this->mentorLayak();

        if ($kata = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($kata) {
                $q->where('jabatan', 'like', "%{$kata}%")
                    ->orWhere('topik_mentoring', 'like', "%{$kata}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$kata}%"));
            });
        }

        if ($bidang = $request->query('bidang')) {
            $query->where('bidang_karier_id', $bidang);
        }

        $daftar = $query->latest()->get();
        $ids = $daftar->pluck('user_id');

        $entri = DB::table('entri_portofolio')
            ->where('status', 'terbit')->whereIn('user_id', $ids)->get()->groupBy('user_id');

        $skill = DB::table('users_keterampilan')
            ->join('keterampilan', 'keterampilan.id', '=', 'users_keterampilan.keterampilan_id')
            ->whereIn('users_keterampilan.users_id', $ids)
            ->select('users_keterampilan.users_id', 'keterampilan.nama_keterampilan')
            ->get()->groupBy('users_id');

        $bidangList = BidangKarier::orderBy('nama')->get();

        return view('katalog.index', compact('daftar', 'entri', 'skill', 'bidangList'));
    }

    public function show($id)
    {
        $mentor = $this->mentorLayak()->findOrFail($id);

        $entri = DB::table('entri_portofolio')
            ->where('user_id', $mentor->user_id)->where('status', 'terbit')
            ->orderByDesc('tanggal_mulai')->get();

        $skill = DB::table('users_keterampilan')
            ->join('keterampilan', 'keterampilan.id', '=', 'users_keterampilan.keterampilan_id')
            ->where('users_keterampilan.users_id', $mentor->user_id)
            ->select('keterampilan.nama_keterampilan', 'users_keterampilan.level')
            ->get();

        return view('katalog.show', compact('mentor', 'entri', 'skill'));
    }
}