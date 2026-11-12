<?php

namespace App\Http\Controllers;

use App\Models\ProfilMentor;
use App\Models\SesiMentoring;
use App\Models\SlotMentoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SesiMentoringController extends Controller
{
    public function index()
    {
        $query = SesiMentoring::with(['slotMentoring.profilMentor.user', 'user'])->latest();
        $jadwal = collect();

        if (auth()->user()->peran === 'mentor') {
            // Mentor: sesi yang masuk ke slotnya + daftar tanggal mentoring mendatang
            $profil = ProfilMentor::untukUser(auth()->id());
            $query->whereHas('slotMentoring', fn ($q) => $q->where('profil_mentor_id', $profil->id));

            $jadwal = $profil->slotMentoring()->with('sesiMentoring.user')
                ->whereDate('tanggal', '>=', today())
                ->orderBy('tanggal')->orderBy('jam_mulai')->get()
                ->groupBy(fn ($s) => $s->tanggal->format('Y-m-d'));
        } else {
            // Pengguna: sesi yang ia pesan
            $query->where('user_id', auth()->id());
        }

        $daftar = $query->get();
        return view('sesi.index', compact('daftar', 'jadwal'));
    }

    public function store(Request $request, SlotMentoring $slot)
    {
        $data = $request->validate([
            'tujuan_sesi' => 'required|string|max:1000',
            'catatan' => 'nullable|string|max:1000',
        ]);

        abort_if(auth()->user()->peran === 'mentor', 403, 'Mentor tidak dapat memesan sesi mentoring.');
        abort_if($slot->profilMentor->user_id == auth()->id(), 403, 'Tidak bisa memesan slot sendiri.');

        $sesi = DB::transaction(function () use ($slot, $data) {
            $kunci = SlotMentoring::lockForUpdate()->findOrFail($slot->id);
            abort_unless(
                $kunci->status === 'tersedia' && $kunci->tanggal->gte(today()),
                409, 'Slot sudah tidak tersedia.'
            );
            $kunci->update(['status' => 'dipesan']);

            return SesiMentoring::create($data + [
                'slot_mentoring_id' => $kunci->id,
                'user_id' => auth()->id(),
            ]);
        });

        return redirect()->route('sesi.show', $sesi)->with('sukses', 'Sesi mentoring berhasil diajukan.');
    }

    public function show(SesiMentoring $sesi)
    {
        abort_unless($this->pemilik($sesi) || $this->mentorSesi($sesi), 403);
        $sesi->load(['slotMentoring.profilMentor.user', 'user']);

        return view('sesi.show', compact('sesi'));
    }

    public function batal(SesiMentoring $sesi)
    {
        abort_unless($this->pemilik($sesi) || $this->mentorSesi($sesi), 403);
        abort_unless(in_array($sesi->status, ['diajukan', 'dikonfirmasi']), 422, 'Sesi tidak bisa dibatalkan.');

        DB::transaction(function () use ($sesi) {
            $sesi->update(['status' => 'dibatalkan']);
            $sesi->slotMentoring->update(['status' => 'tersedia']);
        });

        return back()->with('sukses', 'Sesi dibatalkan.');
    }

    public function konfirmasi(SesiMentoring $sesi)
    {
        abort_unless($this->mentorSesi($sesi), 403);
        abort_unless($sesi->status === 'diajukan', 422, 'Sesi bukan berstatus diajukan.');
        $sesi->update(['status' => 'dikonfirmasi']);

        return back()->with('sukses', 'Sesi dikonfirmasi.');
    }

    public function selesai(SesiMentoring $sesi)
    {
        abort_unless($this->mentorSesi($sesi), 403);
        abort_unless($sesi->status === 'dikonfirmasi', 422, 'Sesi belum dikonfirmasi.');
        $sesi->update(['status' => 'selesai']);

        return back()->with('sukses', 'Sesi ditandai selesai.');
    }

    private function pemilik(SesiMentoring $sesi)
    {
        return $sesi->user_id == auth()->id();
    }

    private function mentorSesi(SesiMentoring $sesi)
    {
        return $sesi->slotMentoring->profilMentor->user_id == auth()->id();
    }
}