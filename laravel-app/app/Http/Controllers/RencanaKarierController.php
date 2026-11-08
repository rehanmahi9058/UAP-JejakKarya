<?php

namespace App\Http\Controllers;

use App\Models\LangkahKarier;
use App\Models\RencanaKarier;
use Illuminate\Http\Request;

class RencanaKarierController extends Controller
{
    public function index()
    {
        $daftar = RencanaKarier::where('user_id', auth()->id())
            ->withCount('langkah')->latest()->get();
        return view('peta-karier.index', compact('daftar'));
    }

    public function create()
    {
        return view('peta-karier.form', ['rencana' => new RencanaKarier()]);
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);
        $data['user_id'] = auth()->id();
        $rencana = RencanaKarier::create($data);

        return redirect()->route('peta-karier.show', $rencana)
            ->with('sukses', 'Peta karier berhasil dibuat.');
    }

    public function show(RencanaKarier $rencana)
    {
        $this->milik($rencana);
        $rencana->load('langkah');
        return view('peta-karier.show', compact('rencana'));
    }

    public function edit(RencanaKarier $rencana)
    {
        $this->milik($rencana);
        return view('peta-karier.form', compact('rencana'));
    }

    public function update(Request $request, RencanaKarier $rencana)
    {
        $this->milik($rencana);
        $rencana->update($this->validasi($request));

        return redirect()->route('peta-karier.show', $rencana)
            ->with('sukses', 'Peta karier berhasil diperbarui.');
    }

    public function destroy(RencanaKarier $rencana)
    {
        $this->milik($rencana);
        $rencana->delete();

        return redirect()->route('peta-karier.index')
            ->with('sukses', 'Peta karier dihapus.');
    }

    // ---- Langkah belajar ----

    public function tambahLangkah(Request $request, RencanaKarier $rencana)
    {
        $this->milik($rencana);
        $data = $request->validate([
            'judul' => 'required|string|max:150',
            'target_tanggal' => 'nullable|date',
        ], [
            'judul.required' => 'Judul langkah wajib diisi.',
            'target_tanggal.date' => 'Tanggal target tidak valid.',
        ]);

        $rencana->langkah()->create($data);
        $rencana->perbaruiStatus();

        return back()->with('sukses', 'Langkah ditambahkan.');
    }

    public function toggleLangkah(LangkahKarier $langkah)
    {
        $rencana = $langkah->rencana;
        $this->milik($rencana);

        $langkah->update(['selesai' => ! $langkah->selesai]);
        $rencana->perbaruiStatus();

        return back();
    }

    public function hapusLangkah(LangkahKarier $langkah)
    {
        $rencana = $langkah->rencana;
        $this->milik($rencana);

        $langkah->delete();
        $rencana->perbaruiStatus();

        return back()->with('sukses', 'Langkah dihapus.');
    }

    // ---- Pembantu ----

    private function milik(RencanaKarier $rencana): void
    {
        abort_if($rencana->user_id !== auth()->id(), 403);
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'tujuan' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:1000',
            'target_selesai' => 'nullable|date',
        ], [
            'tujuan.required' => 'Tujuan karier wajib diisi.',
            'tujuan.max' => 'Tujuan karier maksimal 150 karakter.',
            'target_selesai.date' => 'Tanggal target tidak valid.',
        ]);
    }
}