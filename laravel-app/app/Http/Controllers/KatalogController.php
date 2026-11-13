<?php

namespace App\Http\Controllers;

use App\Models\BidangKarier;
use App\Support\KatalogQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    private const PER_HALAMAN = 6;

    // Mentor tidak boleh mencari mentor lain: arahkan ke jadwal mentoringnya sendiri
    private function tolakMentor()
    {
        if (auth()->check() && auth()->user()->peran === 'mentor') {
            return redirect()->route('mentor.slot.index')
                ->with('error', 'Mentor tidak dapat mencari mentor lain. Kelola jadwal mentoringmu di sini.');
        }
    }

    public function index(Request $request)
    {
        if ($tolak = $this->tolakMentor()) return $tolak;

        $query = KatalogQuery::mentorLayak();

        // Pencarian: nama mentor, jabatan, judul portofolio, keterampilan
        if ($kata = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($kata) {
                $q->where('jabatan', 'like', "%{$kata}%")
                    ->orWhere('topik_mentoring', 'like', "%{$kata}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$kata}%"))
                    ->orWhereExists(fn ($e) => $e->select(DB::raw(1))->from('entri_portofolio')
                        ->whereColumn('entri_portofolio.user_id', 'profil_mentor.user_id')
                        ->where('entri_portofolio.status', 'terbit')
                        ->where('entri_portofolio.judul_portofolio', 'like', "%{$kata}%"))
                    ->orWhereExists(fn ($e) => $e->select(DB::raw(1))->from('users_keterampilan')
                        ->join('keterampilan', 'keterampilan.id', '=', 'users_keterampilan.keterampilan_id')
                        ->whereColumn('users_keterampilan.users_id', 'profil_mentor.user_id')
                        ->where('keterampilan.nama_keterampilan', 'like', "%{$kata}%"));
            });
        }

        // Filter bidang karier
        if ($bidang = $request->query('bidang')) {
            $query->where('bidang_karier_id', $bidang);
        }

        // Filter chip keterampilan
        if ($skill = $request->query('skill')) {
            $query->whereExists(fn ($e) => $e->select(DB::raw(1))->from('users_keterampilan')
                ->whereColumn('users_keterampilan.users_id', 'profil_mentor.user_id')
                ->where('users_keterampilan.keterampilan_id', $skill));
        }

        // Urutan
        match ($request->query('urut')) {
            'nama' => $query->join('users', 'users.id', '=', 'profil_mentor.user_id')->orderBy('users.name'),
            'pengalaman' => $query->orderByDesc('tahun_pengalaman'),
            default => $query->orderByDesc('terbit_terakhir'),
        };

        $daftar = $query->paginate(self::PER_HALAMAN)->withQueryString();
        [$entri, $skills, $slot] = KatalogQuery::lengkapi($daftar->pluck('user_id'));

        // Chip keterampilan = 7 keterampilan paling banyak dimiliki mentor (dari database)
        $chipSkill = DB::table('users_keterampilan')
            ->join('keterampilan', 'keterampilan.id', '=', 'users_keterampilan.keterampilan_id')
            ->groupBy('keterampilan.id', 'keterampilan.nama_keterampilan')
            ->orderByRaw('count(*) desc')->orderBy('keterampilan.nama_keterampilan')
            ->limit(7)->select('keterampilan.id', 'keterampilan.nama_keterampilan')->get();

        $bidangList = BidangKarier::orderBy('nama')->get();

        $statistik = [
            'karya' => DB::table('entri_portofolio')->where('status', 'terbit')->count(),
            'mentor' => KatalogQuery::mentorLayak()->count(),
            'bidang' => $bidangList->count(),
        ];

        return view('katalog.index', compact('daftar', 'entri', 'skills', 'slot', 'chipSkill', 'bidangList', 'statistik'));
    }

    public function show($id)
    {
        if ($tolak = $this->tolakMentor()) return $tolak;
        $mentor = KatalogQuery::mentorLayak()->findOrFail($id);

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
