<x-pengguna-layout judul="Profil Saya">
    <h1 class="text-2xl font-bold">Profil Saya</h1>
    <p class="mt-1 text-sm text-slate-500">Lengkapi profilmu agar mentor mengenal tujuanmu.</p>

    @if (session('sukses'))
        <div class="mt-4 max-w-xl rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('sukses') }}</div>
    @endif

    <form method="POST" action="{{ route('profil.update') }}"
          class="mt-6 max-w-xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                   class="mt-1 w-full rounded-lg border-slate-300 text-sm">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Saya adalah</label>
            <select name="status_pengguna" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                @foreach (['pemula' => 'Pemula', 'mahasiswa' => 'Mahasiswa', 'freelancer' => 'Freelancer', 'umum' => 'Masyarakat umum'] as $nilai => $label)
                    <option value="{{ $nilai }}" @selected(old('status_pengguna', $profil->status_pengguna ?? 'pemula') === $nilai)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status_pengguna') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Bidang minat</label>
            <input type="text" name="bidang_minat" value="{{ old('bidang_minat', $profil->bidang_minat) }}"
                   class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="Contoh: UI/UX Design">
            @error('bidang_minat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Kota</label>
            <input type="text" name="kota" value="{{ old('kota', $profil->kota) }}"
                   class="mt-1 w-full rounded-lg border-slate-300 text-sm">
            @error('kota') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Bio singkat</label>
            <textarea name="bio" rows="4" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('bio', $profil->bio) }}</textarea>
            @error('bio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">
            Simpan profil
        </button>
    </form>
</x-pengguna-layout>