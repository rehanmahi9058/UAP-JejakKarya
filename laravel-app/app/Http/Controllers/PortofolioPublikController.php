<?php

namespace App\Http\Controllers;

use App\Models\EntriPortofolio;
use App\Models\ProfilMentor;

class PortofolioPublikController extends Controller
{
    public function index($mentor)
    {
        $mentor = $this->cariMentor($mentor);
        $entri = EntriPortofolio::with('keterampilan')
            ->where('user_id', $mentor->user_id)->where('status', 'terbit')
            ->orderByDesc('tanggal_mulai')->get();

        return view('portofolio.publik.index', compact('mentor', 'entri'));
    }

    public function show($mentor, $entri)
    {
        $mentor = $this->cariMentor($mentor);
        $entri = EntriPortofolio::with('keterampilan')
            ->where('user_id', $mentor->user_id)->where('status', 'terbit')
            ->findOrFail($entri);

        return view('portofolio.publik.show', compact('mentor', 'entri'));
    }

    // Hanya mentor terverifikasi dengan akun aktif yang boleh tampil di publik
    private function cariMentor($id)
    {
        return ProfilMentor::with(['user', 'bidangKarier'])
            ->where('status_verifikasi', 'terverifikasi')
            ->whereHas('user', fn ($q) => $q->where('aktif', true))
            ->findOrFail($id);
    }
}