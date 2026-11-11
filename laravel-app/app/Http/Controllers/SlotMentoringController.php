<?php

namespace App\Http\Controllers;

use App\Models\ProfilMentor;
use App\Models\SlotMentoring;
use Illuminate\Http\Request;

class SlotMentoringController extends Controller
{

    public function tersedia($id)
    {
        $mentor = ProfilMentor::with('user')->where('status_verifikasi', 'terverifikasi')->findOrFail($id);
        $daftar = $mentor->slotMentoring()
            ->where('status', 'tersedia')->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')->orderBy('jam_mulai')->get();

        return view('katalog.slot', compact('mentor', 'daftar'));
    }

    public function index()
    {
        $daftar = $this->profil()->slotMentoring()
            ->orderByDesc('tanggal')->orderBy('jam_mulai')->get();
        return view('mentor.slot.index', compact('daftar'));
    }

    public function create()
    {
        $this->profil();
        return view('mentor.slot.form', ['slot' => new SlotMentoring()]);
    }

    public function store(Request $request)
    {
        $this->profil()->slotMentoring()->create($this->validasi($request));

        return redirect()->route('mentor.slot.index')->with('sukses', 'Slot jadwal ditambahkan.');
    }

    public function edit(SlotMentoring $slot)
    {
        $this->milik($slot);
        return view('mentor.slot.form', compact('slot'));
    }

    public function update(Request $request, SlotMentoring $slot)
    {
        $this->milik($slot);
        $slot->update($this->validasi($request));

        return redirect()->route('mentor.slot.index')->with('sukses', 'Slot jadwal diperbarui.');
    }

    public function destroy(SlotMentoring $slot)
    {
        $this->milik($slot);
        $slot->delete();

        return redirect()->route('mentor.slot.index')->with('sukses', 'Slot jadwal dihapus.');
    }

    private function profil()
    {
        abort_unless(auth()->user()->peran === 'mentor', 403);
        return ProfilMentor::where('user_id', auth()->id())->firstOrFail();
    }

    private function milik(SlotMentoring $slot)
    {
        abort_unless($slot->profil_mentor_id == $this->profil()->id, 403);
        abort_if($slot->status === 'dipesan', 403, 'Slot sudah dipesan, tidak bisa diubah atau dihapus.');
    }

    private function validasi(Request $request)
    {
        return $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tautan_pertemuan' => 'required|url|max:255',
            'status' => 'sometimes|in:tersedia,ditutup',
        ]);
    }
}