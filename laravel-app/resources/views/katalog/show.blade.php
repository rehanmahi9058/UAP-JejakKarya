<x-pengguna-layout judul="Detail Mentor">
    <a href="{{ route('katalog.index') }}" class="text-sm text-slate-500">← Kembali ke katalog</a>

    <div class="mt-3 rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-violet-100 text-xl font-semibold text-violet-700">
                    {{ strtoupper(substr($mentor->user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-xl font-bold">{{ $mentor->user->name }}</h1>
                    <p class="text-sm text-slate-500">{{ $mentor->jabatan }} · {{ $mentor->bidangKarier->nama ?? '-' }}</p>
                    <p class="text-xs text-slate-400">{{ $mentor->tahun_pengalaman }} tahun pengalaman</p>
                </div>
            </div>
            <a href="#" class="rounded-lg bg-violet-600 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-violet-700">
                Pesan sesi mentoring
            </a>
        </div>

        <p class="mt-4 text-sm text-slate-600">Topik mentoring: {{ $mentor->topik_mentoring }}</p>

        <div class="mt-3 flex flex-wrap gap-1.5">
            @foreach ($skill as $s)
                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs text-slate-600">{{ $s->nama_keterampilan }} · {{ $s->level }}</span>
            @endforeach
        </div>
    </div>

    <h2 class="mt-6 font-semibold">Portofolio</h2>
    <div class="mt-3 grid gap-4 md:grid-cols-2">
        @foreach ($entri as $e)
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-600">{{ ucfirst($e->jenis) }}</span>
                <h3 class="mt-3 font-semibold">{{ $e->judul_portofolio }}</h3>
                <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($e->tanggal_mulai)->format('M Y') }}</p>
                <p class="mt-2 text-sm text-slate-600">{{ $e->deskripsi }}</p>
                @if ($e->tautan_proyek)
                    <a href="{{ $e->tautan_proyek }}" target="_blank" class="mt-3 inline-block text-sm font-semibold text-emerald-800">Lihat proyek →</a>
                @endif
            </div>
        @endforeach
    </div>
</x-pengguna-layout>