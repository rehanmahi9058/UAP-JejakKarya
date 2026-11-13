{{-- KatalogController@index: $daftar (paginate 6), $entri, $skills, $slot, $chipSkill, $bidangList, $statistik --}}
@extends('layouts.situs')
@section('judul', 'Katalog Portofolio — JejakKarier')
@section('isi')
@php
    $angka = fn ($n) => number_format($n, 0, ',', '.');
    $q = request('q'); $skillAktif = request('skill'); $urut = request('urut', 'terbaru');
    $adaFilter = $q || request('bidang') || $skillAktif || request()->filled('urut');
    // tautan chip: pertahankan filter lain, ganti skill, kembali ke halaman 1
    $chip = fn ($id) => route('katalog.index', array_filter(['q' => $q, 'bidang' => request('bidang'), 'urut' => request('urut'), 'skill' => $id]));
    // nomor halaman: 1 2 3 ... N
    $akhir = $daftar->lastPage(); $now = $daftar->currentPage();
    $nomor = collect([1, $now - 1, $now, $now + 1, $akhir])->filter(fn ($n) => $n >= 1 && $n <= $akhir)->unique()->sort()->values();
@endphp

<section class="wrap khero">
    <div>
        <h1>Portofolio Nyata <span>Mentor Terpercaya</span></h1>
        <p>Temukan portofolio berbasis bukti riil, proyek komersial, dan capaian terkurasi dari para mentor profesional di seluruh nusantara.</p>
    </div>
    <div class="mkbox"><img src="{{ asset('img/maskot-baca.png') }}" alt="Maskot JejakKarier"></div>
    <div class="stat3">
        <div><strong>{{ $angka($statistik['karya']) }}</strong><small>Karya Terbit</small></div>
        <div><strong>{{ $angka($statistik['mentor']) }}</strong><small>Mentor</small></div>
        <div><strong>{{ $angka($statistik['bidang']) }}</strong><small>Bidang</small></div>
    </div>
</section>

<div class="wrap">
    <form method="GET" action="{{ route('katalog.index') }}" class="filter">
        @if ($skillAktif)<input type="hidden" name="skill" value="{{ $skillAktif }}">@endif
        <div class="frow">
            <input class="fi" type="search" name="q" value="{{ $q }}" placeholder="🔍  Cari mentor, judul portofolio, atau keterampilan...">
            <select class="fi" name="bidang" onchange="this.form.submit()">
                <option value="">Semua Bidang Karier</option>
                @foreach ($bidangList as $b)<option value="{{ $b->id }}" @selected(request('bidang') == $b->id)>{{ $b->nama }}</option>@endforeach
            </select>
            <select class="fi" name="urut" onchange="this.form.submit()">
                <option value="terbaru" @selected($urut === 'terbaru')>Urutkan: Terbaru Terbit</option>
                <option value="pengalaman" @selected($urut === 'pengalaman')>Urutkan: Pengalaman Terbanyak</option>
                <option value="nama" @selected($urut === 'nama')>Urutkan: Nama A–Z</option>
            </select>
        </div>
        <div class="chips">
            <span>Keterampilan:</span>
            <a href="{{ $chip(null) }}" class="{{ $skillAktif ? '' : 'on' }}">Semua</a>
            @foreach ($chipSkill as $c)
                <a href="{{ $chip($c->id) }}" class="{{ $skillAktif == $c->id ? 'on' : '' }}">{{ $c->nama_keterampilan }}</a>
            @endforeach
            @if ($adaFilter)<a class="reset" href="{{ route('katalog.index') }}">↺ Reset Filter</a>@endif
        </div>
    </form>

    <div class="jud"><h2>Menampilkan Portofolio <em>{{ $daftar->count() }} Talenta Pilihan</em></h2></div>

    <div class="grid3">
        @forelse ($daftar as $m)
            @php $daftarEntri = $entri->get($m->user_id, collect()); $e = $daftarEntri->first(); $sk = $skill = $skills->get($m->user_id, collect()); @endphp
            <div class="pk m">
                <div class="mini"><span class="av" style="width:46px;height:46px">{{ strtoupper(mb_substr($m->user->name, 0, 1)) }}</span>
                    <div><div class="nm">{{ $m->user->name }}</div><div class="sub">{{ $m->jabatan }}@if($m->tahun_pengalaman) • {{ $m->tahun_pengalaman }} th @endif</div></div>
                    <span class="badge-ok" style="margin-left:auto">✔ Terverifikasi</span></div>
                <div class="bd">{{ $m->bidangKarier->nama ?? '-' }}</div>
                <h3>{{ \Illuminate\Support\Str::limit($e->judul_portofolio, 55) }}</h3>
                <div class="gbr" style="margin:0">
                    @if ($e->gambar)<img src="{{ asset('storage/'.$e->gambar) }}" alt="{{ $e->judul_portofolio }}">@else<div class="kosong">▣</div>@endif
                    <div class="cap"><small>{{ ucfirst($e->jenis) }}</small><br>{{ \Illuminate\Support\Str::limit($e->judul_portofolio, 40) }}</div>
                </div>
                <div style="font-size:11px;font-weight:700;letter-spacing:.05em;color:var(--mu)">{{ $sk->count() }} KETERAMPILAN TERUJI</div>
                <div class="tags">@foreach ($sk->take(4) as $s)<span>{{ $s->nama_keterampilan }}</span>@endforeach</div>
                <div class="stripe" style="margin-top:auto"><span><b>{{ $daftarEntri->count() }}</b> portofolio terbit</span><span><b>{{ $slot->get($m->user_id, 0) }}</b> slot tersedia</span></div>
                <div class="dua">
                    <a class="btn soft" href="{{ route('katalog.show', $m->id) }}">Ringkasan</a>
                    <a class="btn" href="{{ route('portofolio.publik.index', $m->id) }}">Portofolio ↗</a>
                </div>
            </div>
        @empty
            <div class="kosong-s">Tidak ada portofolio yang cocok dengan filtermu. <a href="{{ route('katalog.index') }}" style="color:var(--p);font-weight:700">Reset filter</a></div>
        @endforelse
    </div>

    @if ($daftar->total() > 0)
    <div class="pag">
        <span>Menampilkan <b style="color:var(--tx)">{{ $daftar->firstItem() }} - {{ $daftar->lastItem() }}</b> dari <b style="color:var(--tx)">{{ $daftar->total() }}</b> talenta berprestasi</span>
        <nav>
            @if ($daftar->onFirstPage())<span class="mati">‹ Sebelumnya</span>@else<a href="{{ $daftar->previousPageUrl() }}">‹ Sebelumnya</a>@endif
            @php $prev = null; @endphp
            @foreach ($nomor as $n)
                @if ($prev && $n - $prev > 1)<span style="border:0;background:none">…</span>@endif
                <a href="{{ $daftar->url($n) }}" class="{{ $n == $now ? 'on' : '' }}">{{ $n }}</a>
                @php $prev = $n; @endphp
            @endforeach
            @if ($daftar->hasMorePages())<a href="{{ $daftar->nextPageUrl() }}">Selanjutnya ›</a>@else<span class="mati">Selanjutnya ›</span>@endif
        </nav>
    </div>
    @endif
</div>
@endsection
