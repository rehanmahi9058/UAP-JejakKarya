{{-- PortofolioPublikController@show  |  variabel: $mentor (ProfilMentor + user), $entri (EntriPortofolio terbit + keterampilan) --}}
@extends('layouts.publik')
@section('judul', $entri->judul_portofolio)
@section('isi')
@php
    $tgl = fn ($d) => $d ? \Carbon\Carbon::parse($d) : null;
    $bisaPesan = \Illuminate\Support\Facades\Route::has('katalog.slot') && ! (auth()->check() && $mentor->user_id == auth()->id());
@endphp
<div class="pwrap narrow" style="padding-top:28px">
    <a href="{{ route('portofolio.publik.index', $mentor->id) }}" style="color:var(--mu);font-weight:600">← Semua portofolio {{ $mentor->user->name }}</a>

    <article class="card" style="margin-top:14px">
        @if ($entri->gambar)<img class="cover-lg" src="{{ asset('storage/'.$entri->gambar) }}" alt="{{ $entri->judul_portofolio }}">@endif
        <div class="eyebrow">{{ $entri->jenis }}</div>
        <h1 style="font-size:30px;font-weight:800;letter-spacing:-.02em;margin:6px 0">{{ $entri->judul_portofolio }}</h1>
        <p style="color:var(--mu);font-weight:600">{{ $tgl($entri->tanggal_mulai)?->translatedFormat('F Y') }}@if ($entri->tanggal_selesai) – {{ $tgl($entri->tanggal_selesai)->translatedFormat('F Y') }}@else – sekarang @endif</p>

        @if ($entri->keterampilan->isNotEmpty())
            <div class="tags" style="margin:14px 0">@foreach ($entri->keterampilan as $k)<span class="chip">{{ $k->nama_keterampilan }}</span>@endforeach</div>
        @endif

        <div class="lbl">Deskripsi</div>
        <div class="prose">{{ $entri->deskripsi }}</div>

        @if ($entri->tautan_proyek)
            <p style="margin-top:20px"><a class="btn soft" href="{{ $entri->tautan_proyek }}" target="_blank" rel="noopener noreferrer">Buka tautan proyek ↗</a></p>
        @endif
    </article>

    <div class="card" style="margin-top:20px;display:flex;gap:16px;align-items:center;justify-content:space-between;flex-wrap:wrap">
        <div style="display:flex;gap:14px;align-items:center">
            <span class="av" style="width:52px;height:52px;font-size:20px;background:var(--p);color:#fff">{{ strtoupper(mb_substr($mentor->user->name, 0, 1)) }}</span>
            <div><strong>{{ $mentor->user->name }}</strong><br><span class="chip ok">✓ Mentor terverifikasi</span></div>
        </div>
        @if ($bisaPesan)<a class="btn" href="{{ route('katalog.slot', $mentor->id) }}">Pesan sesi mentoring</a>@endif
    </div>
</div>
@endsection