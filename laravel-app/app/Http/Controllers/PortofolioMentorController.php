<?php

namespace App\Http\Controllers;

use App\Models\EntriPortofolio;
use App\Models\Keterampilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortofolioMentorController extends Controller
{
    public function index()
    {
        $this->khususMentor();
        $daftar = EntriPortofolio::where('user_id', auth()->id())->latest()->get();
        return view('mentor.portofolio.index', compact('daftar'));
    }

    public function create()
    {
        $this->khususMentor();
        return view('mentor.portofolio.form', [
            'entri' => new EntriPortofolio(),
            'semuaSkill' => Keterampilan::orderBy('nama_keterampilan')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->khususMentor();
        $this->simpan($request, new EntriPortofolio());

        return redirect()->route('mentor.portofolio.index')
            ->with('sukses', 'Entri portofolio berhasil dibuat (status draf).');
    }

    public function edit(EntriPortofolio $entri)
    {
        $this->milik($entri);
        return view('mentor.portofolio.form', [
            'entri' => $entri->load('keterampilan'),
            'semuaSkill' => Keterampilan::orderBy('nama_keterampilan')->get(),
        ]);
    }

    public function update(Request $request, EntriPortofolio $entri)
    {
        $this->milik($entri);
        $this->simpan($request, $entri);

        return redirect()->route('mentor.portofolio.index')
            ->with('sukses', 'Entri portofolio diperbarui.');
    }

    public function destroy(EntriPortofolio $entri)
    {
        $this->milik($entri);
        if ($entri->gambar) Storage::disk('public')->delete($entri->gambar);
        $entri->delete();

        return redirect()->route('mentor.portofolio.index')
            ->with('sukses', 'Entri portofolio dihapus.');
    }

    public function terbit(EntriPortofolio $entri)
    {
        $this->milik($entri);
        $entri->update(['status' => 'terbit']);

        return back()->with('sukses', 'Entri berhasil diterbitkan.');
    }

    // ---- Helper ----

    private function khususMentor()
    {
        abort_unless(auth()->user()->peran === 'mentor', 403);
    }

    private function milik(EntriPortofolio $entri)
    {
        $this->khususMentor();
        abort_unless($entri->user_id == auth()->id(), 403);
    }

    // Dipakai bersama oleh store() dan update()
    private function simpan(Request $request, EntriPortofolio $entri)
    {
        $v = $request->validate([
            'judul_portofolio' => 'required|string|max:150',
            'jenis' => 'required|in:proyek,organisasi,magang,sertifikat,pekerjaan',
            'deskripsi' => 'required|string',
            'tautan_proyek' => 'nullable|url|max:255',
            'gambar' => 'nullable|image|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterampilan' => 'nullable|array',
            'keterampilan.*' => 'exists:keterampilan,id',
        ]);

        $entri->fill(collect($v)->except(['gambar', 'keterampilan'])->all());
        $entri->user_id = auth()->id();

        if ($request->hasFile('gambar')) {
            if ($entri->gambar) Storage::disk('public')->delete($entri->gambar);
            $entri->gambar = $request->file('gambar')->store('portofolio', 'public');
        }

        $entri->save();
        $entri->keterampilan()->sync($v['keterampilan'] ?? []);
    }
}