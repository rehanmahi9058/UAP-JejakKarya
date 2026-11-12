<?php

namespace App\Http\Controllers;

use App\Models\EntriPortofolio;
use App\Models\ProfilMentor;
use App\Models\RencanaKarier;
use App\Models\SesiMentoring;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return auth()->user()->peran === 'mentor' ? $this->mentor() : $this->pengguna();
    }

    private function pengguna()
    {
        $id = auth()->id();
        $sesi = SesiMentoring::with('slotMentoring.profilMentor.user')->where('user_id', $id)->get();

        $berikutnya = $sesi
            ->filter(fn ($s) => in_array($s->status, ['diajukan', 'dikonfirmasi']) && $s->slotMentoring->tanggal->gte(today()))
            ->sortBy(fn ($s) => $this->urut($s))->first();

        $rencana = RencanaKarier::where('user_id', $id)->where('status', 'berjalan')->latest()->first();
        $langkah = $rencana?->langkah()->where('selesai', false)->orderBy('target_tanggal')->first();

        return view('dashboard', [
            'berikutnya' => $berikutnya,
            'rencana' => $rencana,
            'langkah' => $langkah,
            'jumlahRencana' => RencanaKarier::where('user_id', $id)->where('status', 'berjalan')->count(),
            'sesiSelesai' => $sesi->where('status', 'selesai')->count(),
        ]);
    }

    private function mentor()
    {
        $user = auth()->user();
        $profil = ProfilMentor::untukUser($user->id);
        $entri = EntriPortofolio::where('user_id', $user->id)->get();
        $slot = $profil->slotMentoring()->with('sesiMentoring.user')->get();
        $sesi = SesiMentoring::with(['slotMentoring', 'user'])
            ->whereHas('slotMentoring', fn ($q) => $q->where('profil_mentor_id', $profil->id))->get();
        $jumlahSkill = DB::table('users_keterampilan')->where('users_id', $user->id)->count();

        $menunggu = $sesi->where('status', 'diajukan')->sortBy(fn ($s) => $this->urut($s))->take(5);
        $berikutnya = $sesi->where('status', 'dikonfirmasi')
            ->filter(fn ($s) => $s->slotMentoring->tanggal->gte(today()))
            ->sortBy(fn ($s) => $this->urut($s))->first();

        // Tanggal mentoring mendatang (dikelompokkan per tanggal, maksimal 5 tanggal)
        $jadwal = $slot->filter(fn ($s) => $s->tanggal->gte(today()))
            ->sortBy(fn ($s) => $s->tanggal->format('Y-m-d').$s->jam_mulai)
            ->groupBy(fn ($s) => $s->tanggal->format('Y-m-d'))->take(5);

        $syarat = [
            'Profil mentor diverifikasi admin' => $profil && $profil->status_verifikasi === 'terverifikasi',
            'Minimal 1 entri portofolio berstatus terbit' => $entri->where('status', 'terbit')->count() >= 1,
            'Minimal 3 keterampilan di profil' => $jumlahSkill >= 3,
            'Akun aktif' => (bool) $user->aktif,
        ];

        return view('dashboard-mentor', compact('profil', 'entri', 'slot', 'sesi', 'menunggu', 'berikutnya', 'syarat', 'jadwal'));
    }

    private function urut($sesi)
    {
        return $sesi->slotMentoring->tanggal->format('Y-m-d').$sesi->slotMentoring->jam_mulai;
    }
}