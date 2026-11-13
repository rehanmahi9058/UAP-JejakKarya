{{-- Layout halaman publik sesuai Figma: navbar atas + footer 3 kolom. Dipakai Beranda dan Katalog. --}}
@php
    $rt = fn ($n, $p = []) => \Illuminate\Support\Facades\Route::has($n) ? route($n, $p) : '#';
    $peran = auth()->check() ? auth()->user()->peran : null;
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'JejakKarier')</title>
    @include('partials.gaya-situs')
</head>
<body>
<header class="nav"><div class="wrap">
    <a href="{{ url('/') }}" class="brand"><i>▣</i><span>Jejak<b>Karier</b><small>CAREER &amp; MENTORING</small></span></a>
    <nav class="menu">
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'on' : '' }}">Beranda</a>
        <a href="{{ $rt('katalog.index') }}" class="{{ request()->is('katalog*') ? 'on' : '' }}">Katalog</a>
        <a href="{{ $rt('sesi.index') }}">Cari Mentor</a>
        <a href="{{ $rt('peta-karier.index') }}">Peta Karier</a>
    </nav>
    <div class="kanan">
        @auth
            <a class="btn" href="{{ $rt('dashboard') }}">Dasbor</a>
            <a class="ava" href="{{ $rt('dashboard') }}" title="{{ auth()->user()->name }}">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</a>
        @else
            <a href="{{ $rt('login') }}" style="font-weight:600;color:var(--mu)">Masuk</a>
            <a class="btn" href="{{ $rt('register') }}">Buat Portofolio</a>
            <a class="ava" href="{{ $rt('login') }}">👤</a>
        @endauth
    </div>
</div></header>
@if (session('sukses') || session('error'))
<div class="wrap">
    @if (session('sukses'))<div class="flash ok">{{ session('sukses') }}</div>@endif
    @if (session('error'))<div class="flash er">{{ session('error') }}</div>@endif
</div>
@endif
@yield('isi')
@include('partials.footer-situs')
</body>
</html>
