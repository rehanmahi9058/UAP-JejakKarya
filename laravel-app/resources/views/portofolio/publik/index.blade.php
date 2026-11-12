{{-- PortofolioPublikController@index  |  variabel: $mentor (ProfilMentor + user + bidangKarier), $entri (koleksi entri terbit) --}}
@extends('layouts.publik')
@section('judul', 'Portofolio ' . $mentor->user->name)
@section('isi')
@php
    $tgl = fn ($d) => $d ? \Carbon\Carbon::parse($d) : null;
    $bidang = $mentor->bidangKarier;
    $namaBidang = collect($bidang instanceof \Illuminate\Support\Collection ? $bidang : [$bidang])->filter()
        ->map(fn ($b) => $b->nama_bidang ?? $b->nama ?? null)->filter()->values();
    $semuaSkill = $entri->flatMap(fn ($e) => $e->keterampilan->pluck('nama_keterampilan'))->unique()->sort()->values();
    $bisaPesan = \Illuminate\Support\Facades\Route::has('katalog.slot') && ! (auth()->check() && ($mentor->user_id == auth()->id() || auth()->user()->peran === 'mentor'));
@endphp
<section class="hero">
    <div class="eyebrow">Portofolio Mentor</div>
    <div class="mhead" style="margin-top:14px">
        <span class="av">{{ strtoupper(mb_substr($mentor->user->name, 0, 1)) }}</span>
        <div>
            <h1>{{ $mentor->user->name }}</h1>
            <div class="tags" style="margin-top:8px"><span class="chip ok">✓ Terverifikasi</span>@foreach ($namaBidang as $nb)<span class="chip">{{ $nb }}</span>@endforeach</div>
        </div>
    </div>
    @if ($mentor->headline ?? $mentor->bio ?? null)<p>{{ $mentor->headline ?? $mentor->bio }}</p>@endif
    @if ($bisaPesan)<p style="margin-top:18px"><a class="btn" href="{{ route('katalog.slot', $mentor->id) }}">Pesan sesi mentoring</a></p>@endif
</section>

<div class="pwrap">
    @if ($entri->isNotEmpty())
    <div class="card" style="margin-bottom:24px">
        <div class="bar" style="margin-bottom:12px"><input type="search" id="cari" placeholder="Cari judul karya…" style="flex:1"></div>
        <div class="tags" id="skill">
            <span style="color:var(--mu);font-weight:600">Keterampilan:</span>
            <span class="chip" data-s="" style="cursor:pointer;background:var(--p);color:#fff">Semua</span>
            @foreach ($semuaSkill as $s)<span class="chip" data-s="{{ strtolower($s) }}" style="cursor:pointer">{{ $s }}</span>@endforeach
        </div>
    </div>
    @endif

    <h2 style="font-size:20px;margin-bottom:16px">Karya &amp; Pengalaman <span class="chip">{{ $entri->count() }} entri</span></h2>
    <div class="cards" id="kartu">
        @forelse ($entri as $e)
            <article class="card pc item" data-teks="{{ strtolower($e->judul_portofolio) }}" data-skill="{{ strtolower($e->keterampilan->pluck('nama_keterampilan')->implode('|')) }}">
                <div class="cat">{{ $e->jenis }}</div>
                <h3>{{ $e->judul_portofolio }}</h3>
                @if ($e->gambar)<img class="cover" src="{{ asset('storage/'.$e->gambar) }}" alt="{{ $e->judul_portofolio }}">@else<div class="cover"></div>@endif
                <p style="color:var(--tx);font-weight:600">{{ $tgl($e->tanggal_mulai)?->translatedFormat('M Y') }}@if ($e->tanggal_selesai) – {{ $tgl($e->tanggal_selesai)->translatedFormat('M Y') }}@else – sekarang @endif</p>
                <p>{{ \Illuminate\Support\Str::limit($e->deskripsi, 100) }}</p>
                <div class="tags">@foreach ($e->keterampilan as $k)<span class="chip">{{ $k->nama_keterampilan }}</span>@endforeach</div>
                <a class="btn" href="{{ route('portofolio.publik.show', [$mentor->id, $e->id]) }}">Lihat Detail ↗</a>
            </article>
        @empty
            <div class="empty card" style="grid-column:1/-1">Mentor ini belum menerbitkan portofolio.</div>
        @endforelse
    </div>
</div>
@endsection

@push('skrip')
<script>
(function(){
  var q='', s='';
  function tampil(){document.querySelectorAll('#kartu .item').forEach(function(el){
    var ok=el.dataset.teks.indexOf(q)>-1 && (!s||('|'+el.dataset.skill+'|').indexOf('|'+s+'|')>-1);el.style.display=ok?'':'none';});}
  var c=document.getElementById('cari'); if(c) c.oninput=function(e){q=e.target.value.toLowerCase();tampil();};
  document.querySelectorAll('#skill .chip').forEach(function(c){c.onclick=function(){
    document.querySelectorAll('#skill .chip').forEach(function(x){x.style.background='';x.style.color='';});
    c.style.background='var(--p)';c.style.color='#fff';s=c.dataset.s;tampil();};});
})();
</script>
@endpush