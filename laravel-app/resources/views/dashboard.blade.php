<x-pengguna-layout judul="Ringkasan">
    <h1 class="text-2xl font-bold">Selamat datang, {{ auth()->user()->name }}!</h1>
    <p class="mt-1 text-sm text-slate-500">Mari lanjutkan perkembangan kariermu hari ini.</p>

    {{-- Kartu atas --}}
    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        <div class="rounded-2xl bg-violet-500 p-6 text-white lg:col-span-2">
            <p class="text-xs font-semibold uppercase tracking-wider text-violet-200">Mulai dari sini</p>
            <h2 class="mt-2 text-xl font-bold">Lihat portofolio yang dicari perusahaan</h2>
            <p class="mt-2 text-sm text-violet-100">
                Jelajahi portofolio para mentor, lalu pesan sesi mentoring langsung dengan pemiliknya.
            </p>
            <a href="#" class="mt-5 inline-block rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-800">
                Jelajahi katalog
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-600">Dikonfirmasi</span>
            <h3 class="mt-4 font-semibold">Sesi bersama Dian</h3>
            <p class="mt-1 text-sm text-slate-500">Besok, 19.00 - 30 menit</p>
            <a href="#" class="mt-6 inline-block text-sm font-semibold text-emerald-800">Lihat detail sesi →</a>
        </div>
    </div>

    {{-- Statistik (sementara data contoh) --}}
    <div class="mt-4 grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-3xl font-bold">1</p>
            <p class="mt-1 text-sm text-slate-500">Peta karier aktif</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-3xl font-bold">60%</p>
            <p class="mt-1 text-sm text-slate-500">Progres peta karier</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-3xl font-bold">3</p>
            <p class="mt-1 text-sm text-slate-500">Sesi mentoring selesai</p>
        </div>
    </div>

    {{-- Langkah karier --}}
    <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="font-semibold">Langkah karier berikutnya</h3>
                <p class="text-sm text-slate-500">Tujuan: Menjadi Product Designer</p>
            </div>
            <a href="#" class="text-sm font-semibold text-emerald-800">Lihat peta</a>
        </div>
        <div class="mt-4 h-2 rounded-full bg-slate-100">
            <div class="h-2 rounded-full bg-emerald-800" style="width: 60%"></div>
        </div>
        <p class="mt-4 text-sm font-medium">Selesaikan studi kasus aplikasi finansial</p>
        <p class="text-xs text-slate-400">Target 28 Juni 2025</p>
    </div>
</x-pengguna-layout>