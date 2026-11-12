{{-- KatalogController@show: $mentor (+user, bidangKarier), $entri (portofolio terbit), $skill --}}
@extends('layouts.dasbor')
@section('judul', 'Detail Mentor')
@section('isi')
<a class="back" href="{{ route('katalog.index') }}">← Kembali ke katalog</a>

<div class="card">
    <div class="head" style="margin-bottom:0;align-items:center">
        <div class="mhead">
            <span class="av">{{ strtoupper(mb_substr($mentor->user->name, 0, 1)) }}</span>
            <div>
                <h1 style="font-size:24px">{{ $mentor->user->name }}</h1>
                <p style="margin-top:2px">{{ $mentor->jabatan }} · {{ $mentor->bidangKarier->nama ?? '-' }}</p>
                <p class="note" style="margin-top:2px">{{ $mentor->tahun_pengalaman }} tahun pengalaman</p>
            </div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a class="btn soft" href="{{ route('portofolio.publik.index', $mentor->id) }}">Portofolio publik</a>
            <a class="btn" href="{{ route('katalog.slot', $mentor->id) }}">Pesan sesi mentoring</a>
        </div>
    </div>
    <p style="margin-top:18px;color:var(--mu)">Topik mentoring: {{ $mentor->topik_mentoring }}</p>
    <div class="tags" style="margin-top:12px">
        @foreach ($skill as $s)
            <span class="chip gr">{{ $s->nama_keterampilan }} · {{ $s->level }}</span>
        @endforeach
    </div>
</div>

<h2 style="font-size:18px;margin:26px 0 12px">Portofolio</h2>
<div class="grid2" style="grid-template-columns:1fr 1fr">
    @forelse ($entri as $e)
        <div class="card mc">
            <div><span class="chip wr">{{ ucfirst($e->jenis) }}</span></div>
            <h3 style="display:block">{{ $e->judul_portofolio }}</h3>
            <p class="note" style="margin:0">{{ \Carbon\Carbon::parse($e->tanggal_mulai)->translatedFormat('M Y') }}</p>
            <p style="color:var(--mu)">{{ \Illuminate\Support\Str::limit($e->deskripsi, 140) }}</p>
            <p style="margin-top:auto"><a class="link" href="{{ route('portofolio.publik.show', [$mentor->id, $e->id]) }}">Lihat detail →</a></p>
        </div>
    @empty
        <div class="card empty" style="grid-column:1/-1">Belum ada portofolio terbit.</div>
    @endforelse
</div>
@endsection