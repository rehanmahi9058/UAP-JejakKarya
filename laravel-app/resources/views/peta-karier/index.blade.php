<x-pengguna-layout judul="Peta Karier">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Peta Karier</h1>
            <p class="mt-1 text-sm text-slate-500">Rencana belajarmu menuju karier impian.</p>
        </div>
        <a href="{{ route('peta-karier.create') }}"
           class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">
            + Buat peta karier
        </a>
    </div>

    @if (session('sukses'))
        <div class="mt-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('sukses') }}</div>
    @endif

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        @forelse ($daftar as $r)
            <a href="{{ route('peta-karier.show', $r) }}"
               class="block rounded-2xl border border-slate-200 bg-white p-5 hover:border-violet-300">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="font-semibold">{{ $r->tujuan }}</h2>
                    <span class="shrink-0 rounded-full px-3 py-1 text-xs font-medium
                        {{ $r->status === 'tercapai' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-600' }}">
                        {{ $r->status === 'tercapai' ? 'Tercapai' : 'Berjalan' }}
                    </span>
                </div>
                <div class="mt-4 h-2 rounded-full bg-slate-100">
                    <div class="h-2 rounded-full bg-emerald-800" style="width: {{ $r->progres() }}%"></div>
                </div>
                <p class="mt-2 text-xs text-slate-500">
                    {{ $r->progres() }}% · {{ $r->langkah_count }} langkah
                    @if ($r->target_selesai) · Target {{ $r->target_selesai->format('d M Y') }} @endif
                </p>
            </a>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 md:col-span-2">
                Belum ada peta karier. Klik "Buat peta karier" untuk mulai.
            </div>
        @endforelse
    </div>
</x-pengguna-layout>