{{-- Halaman awal JejakKarier (menggantikan halaman bawaan Laravel) --}}
@extends('layouts.publik')
@section('judul', 'JejakKarier - Portofolio Nyata, Mentor Terpercaya')
@section('isi')
<section class="hero">
    <div class="eyebrow">Career &amp; Mentoring</div>
    <h1 style="margin-top:10px">Bangun karier lewat<br><span>portofolio nyata</span> dan mentor terpercaya</h1>
    <p>Jelajahi portofolio para mentor, susun peta kariermu, lalu pesan sesi mentoring 1-on-1 langsung dengan orang yang sudah berpengalaman di bidangnya.</p>
    <p style="margin-top:22px;display:flex;gap:10px;flex-wrap:wrap">
        @auth
            <a class="btn" href="{{ route('dashboard') }}">Buka Dasbor</a>
        @else
            <a class="btn" href="{{ route('register') }}">Mulai Sekarang</a>
            <a class="btn soft" href="{{ route('login') }}">Masuk</a>
        @endauth
    </p>
</section>

<div class="pwrap">
    <div class="cards" style="margin-top:8px">
        <div class="card pc"><div class="cat">Untuk pengguna</div><h3>Katalog Portofolio</h3>
            <p>Lihat proyek, pengalaman, dan sertifikat para mentor terverifikasi sebagai inspirasi karier.</p></div>
        <div class="card pc"><div class="cat">Untuk pengguna</div><h3>Peta Karier</h3>
            <p>Tulis tujuan kariermu, pecah menjadi langkah belajar, dan pantau progresnya.</p></div>
        <div class="card pc"><div class="cat">Pengguna &amp; mentor</div><h3>Sesi Mentoring</h3>
            <p>Pengguna memesan slot yang tersedia. Mentor membuka jadwal dan mengonfirmasi sesi.</p></div>
    </div>

    <div class="card hero-card" style="margin-top:28px">
        <div class="eyebrow">Untuk mentor</div>
        <h2>Bagikan pengalamanmu</h2>
        <p>Terbitkan portofolio, buka jadwal mentoring pada tanggal yang kamu pilih, dan bimbing talenta muda menuju kariernya.</p>
        @guest<a class="btn" href="{{ route('register') }}">Daftar sekarang</a>@endguest
    </div>
</div>
@endsection