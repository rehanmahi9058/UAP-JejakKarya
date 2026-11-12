{{-- KatalogController@index: $daftar, $entri (per user), $skill (per user), $bidangList --}}
@extends('layouts.dasbor')
@section('judul', 'Katalog Portofolio')
@section('isi')
<div class="head">
    <div><div class="eyebrow">Cari Mentor</div><h1>Katalog Portofolio</h1>
        <p>Lihat portofolio yang dibuat para mentor, lalu pesan sesi mentoring langsung dengan pemiliknya.</p></div>
    <a class="btn soft" href="{{ route('sesi.index') }}">Sesi saya</a>
</div>

<form method="GET" action="{{ route('katalog.index') }}" class="bar">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, jabatan, atau topik..." style="flex:1">
    <select name="bidang" style="font:inherit;border:1px solid var(--bd);border-radius:999px;padding:9px 16px;background:#fff">
        <option value="">Semua bidang</option>
        @foreach ($bidangList as $b)
            <option value="{{ $b->id }}" @selected(request('bidang') == $b->id)>{{ $b->nama }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn">Cari</button>
</form>

<div class="cards">
    @forelse ($daftar as $m)
        <div class="card mc">
            <div class="mini">
                <span class="av">{{ strtoupper(mb_substr($m->user->name, 0, 1)) }}</span>
                <div><h3 style="display:block">{{ $m->user->name }}</h3><div class="meta" style="margin:0">{{ $m->jabatan }}</div></div>
            </div>
            <div><span class="chip ok">{{ $m->bidangKarier->nama ?? '-' }}</span></div>
            <p style="color:var(--mu)">{{ \Illuminate\Support\Str::limit($m->topik_mentoring, 90) }}</p>
            <div class="tags">
                @foreach ($skill->get($m->user_id, collect())->take(4) as $s)
                    <span class="chip gr">{{ $s->nama_keterampilan }}</span>
                @endforeach
            </div>
            <p class="note" style="margin:0">{{ $entri->get($m->user_id, collect())->count() }} portofolio terbit</p>
            <div style="display:flex;gap:8px;margin-top:auto;flex-wrap:wrap">
                <a class="btn soft sm" href="{{ route('katalog.show', $m->id) }}">Lihat profil</a>
                <a class="btn sm" href="{{ route('katalog.slot', $m->id) }}">Pesan sesi</a>
            </div>
        </div>
    @empty
        <div class="card empty" style="grid-column:1/-1">Tidak ada portofolio yang cocok.</div>
    @endforelse
</div>
@endsection