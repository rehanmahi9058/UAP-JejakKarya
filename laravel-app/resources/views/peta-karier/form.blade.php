<x-pengguna-layout judul="Peta Karier">
    <h1 class="text-2xl font-bold">{{ $rencana->exists ? 'Ubah peta karier' : 'Buat peta karier' }}</h1>

    <form method="POST"
          action="{{ $rencana->exists ? route('peta-karier.update', $rencana) : route('peta-karier.store') }}"
          class="mt-6 max-w-xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
        @csrf
        @if ($rencana->exists) @method('PUT') @endif

        <div>
            <label class="text-sm font-medium">Tujuan karier</label>
            <input type="text" name="tujuan" value="{{ old('tujuan', $rencana->tujuan) }}"
                   class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="Contoh: Menjadi Product Designer">
            @error('tujuan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Deskripsi (opsional)</label>
            <textarea name="deskripsi" rows="3"
                      class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('deskripsi', $rencana->deskripsi) }}</textarea>
            @error('deskripsi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Target selesai (opsional)</label>
            <input type="date" name="target_selesai"
                   value="{{ old('target_selesai', optional($rencana->target_selesai)->format('Y-m-d')) }}"
                   class="mt-1 w-full rounded-lg border-slate-300 text-sm">
            @error('target_selesai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Simpan</button>
            <a href="{{ route('peta-karier.index') }}" class="rounded-lg px-4 py-2 text-sm text-slate-600">Batal</a>
        </div>
    </form>
</x-pengguna-layout>