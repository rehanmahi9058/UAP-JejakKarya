<x-pengguna-layout judul="Katalog Portofolio">
    <h1 class="text-2xl font-bold">Katalog Portofolio</h1>
    <p class="mt-1 text-sm text-slate-500">Lihat portofolio yang dibuat para mentor, lalu pesan sesi mentoring langsung dengan pemiliknya.</p>

    <form method="GET" action="{{ route('katalog.index') }}" class="mt-5 flex flex-col gap-2 sm:flex-row">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, jabatan, atau topik..."
               class="flex-1 rounded-lg border-slate-300 text-sm">
        <select name="bidang" class="rounded-lg border-slate-300 text-sm">
            <option value="">Semua bidang</option>
            @foreach ($bidangList as $b)
                <option value="{{ $b->id }}" @selected(request('bidang') == $b->id)>{{ $b->nama }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Cari</button>
    </form>

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        @forelse ($daftar as $m)
            <a href="{{ route('katalog.show', $m->id) }}"
               class="block rounded-2xl border border-slate-200 bg-white p-5 hover:border-violet-300">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-violet-100 font-semibold text-violet-700">
                        {{ strtoupper(substr($m->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-semibold">{{ $m->user->name }}</h2>
                        <p class="text-sm text-slate-500">{{ $m->jabatan }}</p>
                    </div>
                </div>

                <span class="mt-3 inline-block rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                    {{ $m->bidangKarier->nama ?? '-' }}
                </span>

                <p class="mt-3 text-sm text-slate-600">{{ $m->topik_mentoring }}</p>

                <div class="mt-3 flex flex-wrap gap-1.5">
                    @foreach ($skill->get($m->user_id, collect())->take(4) as $s)
                        <span class="rounded-md bg-slate-100 px-2 py-1 text-xs text-slate-600">{{ $s->nama_keterampilan }}</span>
                    @endforeach
                </div>

                <p class="mt-4 text-xs text-slate-400">{{ $entri->get($m->user_id, collect())->count() }} portofolio terbit</p>
            </a>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 md:col-span-2">
                Tidak ada portofolio yang cocok.
            </div>
        @endforelse
    </div>
</x-pengguna-layout>