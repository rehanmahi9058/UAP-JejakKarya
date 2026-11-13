<?php

namespace App\Http\Controllers;

use App\Models\ProfilMentor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $mentor = ProfilMentor::with(['user', 'bidangKarier'])->latest()->get();

        $akun = User::orderBy('peran')->orderBy('name')->get();

        $sesi = DB::table('sesi_mentoring as s')
            ->join('slot_mentoring as sl', 'sl.id', '=', 's.slot_mentoring_id')
            ->join('profil_mentor as pm', 'pm.id', '=', 'sl.profil_mentor_id')
            ->join('users as mentor', 'mentor.id', '=', 'pm.user_id')
            ->join('users as pengguna', 'pengguna.id', '=', 's.user_id')
            ->select('s.status', 'sl.tanggal', 'sl.jam_mulai', 'mentor.name as mentor', 'pengguna.name as pengguna')
            ->orderByDesc('sl.tanggal')->limit(20)->get();

        return view('admin.index', compact('mentor', 'akun', 'sesi'));
    }

    public function verifikasi($id)
    {
        ProfilMentor::findOrFail($id)->update([
            'status_verifikasi' => 'terverifikasi',
            'diverifikasi_pada' => now(),
        ]);

        return back()->with('sukses', 'Mentor berhasil diverifikasi.');
    }

    public function cabutVerifikasi($id)
    {
        ProfilMentor::findOrFail($id)->update([
            'status_verifikasi' => 'menunggu',
            'diverifikasi_pada' => null,
        ]);

        return back()->with('sukses', 'Verifikasi mentor dicabut.');
    }

    public function toggleAkun(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'Akun sendiri tidak dapat dinonaktifkan.');

        $user->forceFill(['aktif' => ! $user->aktif])->save();

        return back()->with('sukses', $user->aktif ? 'Akun diaktifkan.' : 'Akun dinonaktifkan.');
    }
}