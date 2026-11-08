<x-pengguna-layout judul="Peta Karier">
    @if (session('sukses'))
        <div class="mb-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('sukses') }}</div>
    @endif

    <div class="flex items-start justify-between gap-4">
        <div>
            <a href="{{ route('peta-karier.index') }}" class="text-sm text-slate-500">← Semua peta karier</a>
            <h1 class="mt-2 text-2xl font-bold">{{ $rencana->tujuan }}</h1>
            @if ($rencana->deskripsi) <p class="mt-1 text-sm text-slate-500">{{ $rencana->deskripsi }}</p> @endif
        </div>
        <span class="shrink-0 rounded-full px-3 py-1 text-xs font-medium
            {{ $rencana->status === 'tercapai' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-600' }}">
            {{ $rencana->status === 'tercapai' ? 'Tercapai' : 'Berjalan' }}
        </span>
    </div>

    <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex justify-between text-sm">
            <span class="font-medium">Progres</span>
            <span>{{ $rencana->progres() }}%</span>
        </div>
        <div class="mt-2 h-2 rounded-full bg-slate-100">
            <div class="h-2 rounded-full bg-emerald-800" style="width: {{ $rencana->progres() }}%"></div>
        </div>
        @if ($rencana->target_selesai)
            <p class="mt-2 text-xs text-slate-500">Target selesai: {{ $rencana->target_selesai->format('d M Y') }}</p>
        @endif
    </div>

    {{-- Daftar langkah --}}
    <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-6">
        <h2 class="font-semibold">Langkah belajar</h2>

        <ul class="mt-3 divide-y divide-slate-100">
            @forelse ($rencana->langkah as $l)
                <li class="flex items-center justify-between gap-3 py-3">
                    <form method="POST" action="{{ route('peta-karier.langkah.toggle', $l) }}" class="flex items-center gap-3">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="flex h-6 w-6 items-center justify-center rounded-full border
                                       {{ $l->selesai ? 'border-emerald-700 bg-emerald-700 text-white' : 'border-slate-300' }}">
                            @if ($l->selesai) ✓ @endif
                        </button>
                        <div>
                            <p class="text-sm font-medium {{ $l->selesai ? 'text-slate-400 line-through' : '' }}">{{ $l->judul }}</p>
                            @if ($l->target_tanggal)
                                <p class="text-xs text-slate-400">Target {{ $l->target_tanggal->format('d M Y') }}</p>
                            @endif
                        </div>
                    </form>
                    <form method="POST" action="{{ route('peta-karier.langkah.destroy', $l) }}"
                          onsubmit="return confirm('Hapus langkah ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-500">Hapus</button>
                    </form>
                </li>
            @empty
                <li class="py-3 text-sm text-slate-500">Belum ada langkah. Tambahkan di bawah.</li>
            @endforelse
        </ul>

        <form method="POST" action="{{ route('peta-karier.langkah.store', $rencana) }}"
              class="mt-4 flex flex-col gap-2 sm:flex-row">
            @csrf
            <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Langkah baru..."
                   class="flex-1 rounded-lg border-slate-300 text-sm">
            <input type="date" name="target_tanggal" value="{{ old('target_tanggal') }}"
                   class="rounded-lg border-slate-300 text-sm">
            <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white">Tambah</button>
        </form>
        @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        @error('target_tanggal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mt-4 flex gap-3">
        <a href="{{ route('peta-karier.edit', $rencana) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm">Ubah</a>
        <form method="POST" action="{{ route('peta-karier.destroy', $rencana) }}"
              onsubmit="return confirm('Hapus peta karier ini beserta langkahnya?')">
            @csrf @method('DELETE')
            <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm text-red-600">Hapus</button>
        </form>
    </div>
</x-pengguna-layout>