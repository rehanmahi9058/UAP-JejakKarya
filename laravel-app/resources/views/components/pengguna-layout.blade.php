@props(['judul' => 'Ringkasan'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $judul }} - JejakKarya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
@php
    $menu = [
        ['nama' => 'Ringkasan', 'url' => route('dashboard'), 'aktif' => request()->routeIs('dashboard')],
       ['nama' => 'Katalog Portofolio', 'url' => route('katalog.index'), 'aktif' => request()->routeIs('katalog.*')],
       ['nama' => 'Peta Karier', 'url' => route('peta-karier.index'), 'aktif' => request()->routeIs('peta-karier.*')],
        ['nama' => 'Sesi Mentoring', 'url' => '#', 'aktif' => false],
        ['nama' => 'Profil Saya', 'url' => route('profil.edit'), 'aktif' => request()->routeIs('profil.*')],
    ];

    if (auth()->user()->peran === 'admin') {
    $menu[] = ['nama' => 'Kelola Mentor dan Akun', 'url' => route('admin.index'), 'aktif' => request()->routeIs('admin.*')];
}
@endphp
<div class="min-h-screen md:flex">

    {{-- Sidebar --}}
    <aside class="hidden md:flex md:w-64 shrink-0 flex-col border-r border-slate-200 bg-white">
        <div class="px-6 py-6 text-xl font-bold">
            Jejak<span class="text-violet-600">Karya</span>
        </div>
        <nav class="flex-1 px-4">
            <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu Pengguna</p>
            @foreach ($menu as $m)
                <a href="{{ $m['url'] }}"
                   class="mb-1 block rounded-lg px-3 py-2.5 text-sm font-medium
                          {{ $m['aktif'] ? 'bg-violet-50 text-violet-700' : 'text-slate-600 hover:bg-slate-50' }}">
                    {{ $m['nama'] }}
                </a>
            @endforeach
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-200 p-4">
            @csrf
            <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-slate-500 hover:bg-slate-50">
                Keluar
            </button>
        </form>
    </aside>

    <div class="flex-1">
        {{-- Header --}}
        <header class="flex items-center justify-between border-b border-slate-200 bg-white px-6 py-4">
            <span class="text-sm text-slate-500">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>
            <div class="text-right">
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400">Pengguna</p>
            </div>
        </header>

        {{-- Menu untuk layar kecil --}}
        <nav class="flex gap-2 overflow-x-auto border-b border-slate-200 bg-white px-4 py-2 md:hidden">
            @foreach ($menu as $m)
                <a href="{{ $m['url'] }}"
                   class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-medium
                          {{ $m['aktif'] ? 'bg-violet-100 text-violet-700' : 'text-slate-600' }}">
                    {{ $m['nama'] }}
                </a>
            @endforeach
        </nav>

        <main class="p-6 md:p-8">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>