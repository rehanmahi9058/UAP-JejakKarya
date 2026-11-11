{{-- Layout dasbor (sidebar) untuk halaman mentor dan sesi. Jika proyekmu sudah punya layout sendiri, ganti @extends di tiap view. --}}
@php
    $rt = fn ($n, $p = []) => \Illuminate\Support\Facades\Route::has($n) ? route($n, $p) : '#';
    $adalahMentor = auth()->user()->peran === 'mentor';
    $menu = $adalahMentor
        ? ['Ringkasan' => [$rt('dashboard'), 'dashboard'], 'Portofolio' => [$rt('mentor.portofolio.index'), 'mentor.portofolio.*'], 'Slot Jadwal' => [$rt('mentor.slot.index'), 'mentor.slot.*'], 'Mentoring' => [$rt('sesi.index'), 'sesi.*']]
        : ['Ringkasan' => [$rt('dashboard'), 'dashboard'], 'Peta karier' => [$rt('peta-karier.index'), 'peta-karier.*'], 'Cari mentor' => [$rt('katalog.index'), 'katalog.*'], 'Mentoring' => [$rt('sesi.index'), 'sesi.*']];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'JejakKarier')</title>
    @include('partials.gaya')
</head>
<body>
<div class="app">
    <aside class="side">
        <a href="{{ $rt('dashboard') }}" class="brand"><i>▣</i><span>Jejak<b>Karier</b>@if($adalahMentor)<small>MENTOR PORTAL</small>@endif</span></a>
        <h6>{{ $adalahMentor ? 'MENU MENTOR' : 'MENU PENGGUNA' }}</h6>
        <nav>
            @foreach ($menu as $label => [$url, $pola])
                <a href="{{ $url }}" class="{{ request()->routeIs($pola) ? 'on' : '' }}">{{ $label }}</a>
            @endforeach
        </nav>
        <form method="POST" action="{{ $rt('logout') }}" class="out">@csrf<button type="submit">↩ Keluar</button></form>
    </aside>
    <div class="main">
        <header class="top">
            <span>📅 {{ now()->translatedFormat('l, j F Y') }}</span>
            <div style="display:flex;gap:12px;align-items:center">
                <div class="who">{{ auth()->user()->name }}<small>{{ $adalahMentor ? 'Mentor' : 'Pengguna' }}</small></div>
                <span class="av">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
        </header>
        <main class="page">
            @if (session('sukses'))<div class="flash ok">{{ session('sukses') }}</div>@endif
            @if (session('error'))<div class="flash er">{{ session('error') }}</div>@endif
            @yield('isi')
        </main>
    </div>
</div>
@stack('skrip')
</body>
</html>