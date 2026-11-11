{{-- PortofolioMentorController@index  |  variabel: $daftar (koleksi EntriPortofolio milik mentor) --}}
@extends('layouts.dasbor')
@section('judul', 'Portofolio Saya')
@section('isi')
@php
    $v = fn ($n) => collect(\Illuminate\Support\Facades\Route::getRoutes()->getByName($n)?->methods() ?? ['POST'])->first(fn ($m) => ! in_array($m, ['GET', 'HEAD'])) ?? 'POST';
    $tgl = fn ($d) => $d ? \Carbon\Carbon::parse($d) : null;
    $profil = \App\Models\ProfilMentor::where('user_id', auth()->id())->first();
    $verif = $profil && $profil->status_verifikasi === 'terverifikasi';
    $nTerbit = $daftar->where('status', 'terbit')->count();
    $nDraf = $daftar->where('status', 'draf')->count();
@endphp
<div class="head">
    <div>
        <div class="eyebrow">● Portofolio Mentor</div>
        <h1>Portofolio Saya</h1>
        <p>Kelola proyek, pengalaman, dan sertifikatmu. Hanya yang berstatus terbit tampil di katalog publik.</p>
    </div>
    <a class="btn" href="{{ route('mentor.portofolio.create') }}">+ Tambah Entri</a>
</div>

<div class="stats">
    <div class="card stat"><small>Total portofolio</small><strong>{{ $daftar->count() }}</strong></div>
    <div class="card stat"><small>Aktif terbit</small><strong style="color:var(--ok)">{{ $nTerbit }}</strong></div>
    <div class="card stat"><small>Draf disimpan</small><strong style="color:var(--p)">{{ $nDraf }}</strong></div>
    <div class="card stat"><small>Status kurasi</small>
        <p style="font-weight:600;margin-top:6px">{{ $verif ? 'Terverifikasi, entri terbit tampil di katalog' : 'Menunggu verifikasi admin' }}</p></div>
</div>

<div class="bar">
    <div class="tabs" id="tab">
        <button type="button" class="on" data-f="semua">Semua ({{ $daftar->count() }})</button>
        <button type="button" data-f="terbit">Terbit ({{ $nTerbit }})</button>
        <button type="button" data-f="draf">Draf ({{ $nDraf }})</button>
    </div>
    <input type="search" id="cari" placeholder="Cari karya atau skill…">
</div>

<div class="card" style="padding:0" id="daftar">
    @forelse ($daftar as $e)
        <div class="row item" data-status="{{ $e->status }}" data-teks="{{ strtolower($e->judul_portofolio.' '.$e->keterampilan->pluck('nama_keterampilan')->implode(' ')) }}">
            @if ($e->gambar)<img class="th" src="{{ asset('storage/'.$e->gambar) }}" alt="{{ $e->judul_portofolio }}">@else<div class="th"></div>@endif
            <div class="info">
                <h3>{{ $e->judul_portofolio }}</h3>
                <span class="chip {{ $e->status === 'terbit' ? '' : 'gr' }}">● {{ strtoupper($e->status) }}</span>
                <div class="meta"><b>{{ ucfirst($e->jenis) }}</b> ·
                    {{ $tgl($e->tanggal_mulai)?->translatedFormat('M Y') }}@if ($e->tanggal_selesai) – {{ $tgl($e->tanggal_selesai)->translatedFormat('M Y') }}@else – sekarang @endif
                    @foreach ($e->keterampilan as $k) <span class="chip">{{ $k->nama_keterampilan }}</span> @endforeach
                </div>
                <p class="meta">{{ \Illuminate\Support\Str::limit($e->deskripsi, 110) }}</p>
            </div>
            <div class="acts">
                @if ($e->status === 'terbit' && $verif)
                    <a class="btn soft sm" href="{{ route('portofolio.publik.show', [$profil->id, $e->id]) }}">Lihat</a>
                @elseif ($e->status === 'draf')
                    <form method="POST" action="{{ route('mentor.portofolio.terbit', $e) }}">@csrf @method($v('mentor.portofolio.terbit'))<button class="btn soft sm">Terbitkan</button></form>
                @endif
                <a class="btn soft sm" href="{{ route('mentor.portofolio.edit', $e) }}">Ubah</a>
                <form method="POST" action="{{ route('mentor.portofolio.destroy', $e) }}" onsubmit="return confirm('Hapus entri ini?')">@csrf @method('DELETE')<button class="btn bad sm">Hapus</button></form>
            </div>
        </div>
    @empty
        <div class="empty">Belum ada entri portofolio. <a href="{{ route('mentor.portofolio.create') }}" style="color:var(--p);font-weight:700">Tambah yang pertama</a>.</div>
    @endforelse
</div>
@unless ($verif)<p class="note er">● Mentor belum diverifikasi admin: portofolio belum tampil di katalog.</p>@endunless
@endsection

@push('skrip')
<script>
(function(){
  var f='semua', q='';
  function tampil(){document.querySelectorAll('#daftar .item').forEach(function(el){
    el.style.display=((f==='semua'||el.dataset.status===f)&&el.dataset.teks.indexOf(q)>-1)?'':'none';});}
  document.querySelectorAll('#tab button').forEach(function(b){b.onclick=function(){
    document.querySelectorAll('#tab button').forEach(function(x){x.classList.remove('on')});b.classList.add('on');f=b.dataset.f;tampil();};});
  document.getElementById('cari').oninput=function(e){q=e.target.value.toLowerCase();tampil();};
})();
</script>
@endpush