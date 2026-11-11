{{-- Layout halaman publik (navbar atas + footer). Dipakai portofolio publik dan katalog/slot. --}}
@php $rt = fn ($n, $p = []) => \Illuminate\Support\Facades\Route::has($n) ? route($n, $p) : '#'; @endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'JejakKarier')</title>
    @include('partials.gaya')
</head>
<body>
<header class="pnav">
    <a href="{{ url('/') }}" class="brand" style="margin:0"><i>▣</i><span>Jejak<b>Karier</b></span></a>
    <nav>
        <a href="{{ url('/') }}">Beranda</a>
        <a href="{{ $rt('katalog.index') }}" class="on">Cari Mentor</a>
        <a href="{{ $rt('peta-karier.index') }}">Peta Karier</a>
    </nav>
    <div>
        @auth
            <a class="btn" href="{{ $rt('dashboard') }}">Dasbor</a>
        @else
            <a href="{{ $rt('login') }}" style="margin-right:14px;font-weight:600">Masuk</a><a class="btn" href="{{ $rt('register') }}">Daftar</a>
        @endauth
    </div>
</header>
<div class="pwrap" style="padding-top:20px;padding-bottom:0">
    @if (session('sukses'))<div class="flash ok">{{ session('sukses') }}</div>@endif
    @if (session('error'))<div class="flash er">{{ session('error') }}</div>@endif
</div>
@yield('isi')
<footer class="pfoot"><strong>JejakKarier</strong><span>© {{ date('Y') }} JejakKarier. Mendorong pemerataan peluang karier digital.</span></footer>
@stack('skrip')
</body>
</html>