<?php

namespace App\Http\Controllers;

use App\Models\ProfilPengguna;
use Illuminate\Http\Request;

class ProfilPenggunaController extends Controller
{
    public function edit()
    {
        $profil = ProfilPengguna::firstOrNew(['user_id' => auth()->id()]);
        return view('profil.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'status_pengguna' => 'required|in:pemula,mahasiswa,freelancer,umum',
            'bidang_minat' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:80',
            'bio' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'status_pengguna.required' => 'Pilih status kamu.',
            'status_pengguna.in' => 'Status tidak valid.',
            'bio.max' => 'Bio maksimal 500 karakter.',
        ]);

        auth()->user()->update(['name' => $data['name']]);

        ProfilPengguna::updateOrCreate(
            ['user_id' => auth()->id()],
            collect($data)->except('name')->all()
        );

        return redirect()->route('profil.edit')->with('sukses', 'Profil berhasil diperbarui.');
    }
}