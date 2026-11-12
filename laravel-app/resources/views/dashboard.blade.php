{{-- Dashboard PENGGUNA. DashboardController@pengguna: $berikutnya, $rencana, $langkah, $jumlahRencana, $sesiSelesai --}}
@extends('layouts.dasbor')
@section('judul', 'Ringkasan')
@section('isi')
@php
    $berikutnya = $berikutnya ?? null;
    $rencana = $rencana ?? null;
    $langkah = $langkah ?? null;
    $jumlahRencana = $jumlahRencana ?? 0;
    $sesiSelesai = $sesiSelesai ?? 0;
@endphp

<div class="head">
    <div><div class="eyebrow">Ringkasan</div><h1>Selamat datang, {{ auth()->user()->name }}!</h1><p>Mari lanjutkan perkembangan kariermu hari ini.</p></div>
</div>

<div class="grid21">
    <div class="card hero-card">
        <div class="eyebrow">Mulai dari sini</div>
        <h2>Lihat portofolio yang dicari perusahaan</h2>
        <p>Jelajahi portofolio para mentor, lalu pesan sesi mentoring langsung dengan pemiliknya.</p>
        <a class="btn" href="{{ route('katalog.index') }}">Jelajahi katalog</a>
    </div>

    <div class="card">
        @if ($berikutnya)
            @php $slot = $berikutnya->slotMentoring; @endphp
            <span class="chip {{ $berikutnya->status === 'diajukan' ? 'wr' : '' }}">{{ ucfirst($berikutnya->status) }}</span>
            <h3 style="margin-top:14px">Sesi bersama {{ $slot->profilMentor->user->name }}</h3>
            <p style="color:var(--mu);margin-top:4px">{{ $slot->tanggal->isToday() ? 'Hari ini' : $slot->tanggal->translatedFormat('D, j M Y') }}, {{ substr($slot->jam_mulai, 0, 5) }} WIB</p>
            <p style="margin-top:20px"><a class="link" href="{{ route('sesi.show', $berikutnya) }}">Lihat detail sesi →</a></p>
        @else
            <span class="chip gr">Belum ada sesi</span>
            <h3 style="margin-top:14px">Belum ada sesi mendatang</h3>
            <p style="color:var(--mu);margin-top:4px">Pilih mentor dan pesan slot yang tersedia.</p>
            <p style="margin-top:20px"><a class="link" href="{{ route('katalog.index') }}">Cari mentor →</a></p>
        @endif
    </div>
</div>

<div class="stats s3">
    <div class="card stat"><small>Peta karier aktif</small><strong>{{ $jumlahRencana }}</strong></div>
    <div class="card stat"><small>Progres peta karier</small><strong>{{ $rencana ? $rencana->progres() : 0 }}%</strong></div>
    <div class="card stat"><small>Sesi mentoring selesai</small><strong>{{ $sesiSelesai }}</strong></div>
</div>

<div class="card">
    @if ($rencana)
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start">
            <div><h3>Langkah karier berikutnya</h3><p style="color:var(--mu)">Tujuan: {{ $rencana->tujuan }}</p></div>
            <a class="link" href="{{ route('peta-karier.show', $rencana) }}">Lihat peta</a>
        </div>
        <div class="prog" style="margin:16px 0"><i style="width:{{ $rencana->progres() }}%"></i></div>
        @if ($langkah)
            <p style="font-weight:600">{{ $langkah->judul }}</p>
            @if ($langkah->target_tanggal)<p class="note" style="margin-top:2px">Target {{ $langkah->target_tanggal->format('d M Y') }}</p>@endif
        @else
            <p style="color:var(--mu)">Semua langkah selesai atau belum ada langkah. <a class="link" href="{{ route('peta-karier.show', $rencana) }}">Tambah langkah</a></p>
        @endif
    @else
        <h3>Belum punya peta karier</h3>
        <p style="color:var(--mu);margin:4px 0 14px">Susun tujuan dan langkah belajarmu, lalu cari mentor yang sesuai.</p>
        <a class="btn" href="{{ route('peta-karier.create') }}">+ Buat peta karier</a>
    @endif
</div>
@endsection