{{-- SlotMentoringController@index  |  variabel: $daftar (koleksi SlotMentoring milik mentor, tanggal terbaru dulu) --}}
@extends('layouts.dasbor')
@section('judul', 'Kelola Jadwal & Slot Mentoring')
@section('isi')
@php
    $profil = \App\Models\ProfilMentor::where('user_id', auth()->id())->first();
    $n = fn ($s) => $daftar->where('status', $s)->count();
    $bulan = now()->startOfMonth();
    $perTanggal = $daftar->filter(fn ($s) => \Carbon\Carbon::parse($s->tanggal)->isSameMonth($bulan))
        ->groupBy(fn ($s) => \Carbon\Carbon::parse($s->tanggal)->day);
    $awal = $bulan->dayOfWeek; // 0 = Minggu
    $nama = auth()->user()->name;
    $kelasStatus = ['tersedia' => 'ok', 'dipesan' => '', 'ditutup' => 'gr'];
@endphp
<div class="head">
    <div><h1>Kelola Jadwal &amp; Slot Mentoring</h1><p>Atur ketersediaan slot konsultasi 1-on-1. Slot yang sudah dipesan tidak bisa diubah atau dihapus.</p></div>
    <a class="btn" href="{{ route('mentor.slot.create') }}">+ Tambah Slot Baru</a>
</div>

<div class="card" style="display:flex;gap:16px;align-items:center;margin-bottom:22px">
    <span class="av" style="width:64px;height:64px;font-size:22px;background:var(--p);color:#fff;border-radius:18px">{{ strtoupper(mb_substr($nama, 0, 2)) }}</span>
    <div>
        <h2 style="font-size:20px">{{ $nama }}
            @if ($profil && $profil->status_verifikasi === 'terverifikasi')<span class="chip ok">✓ Terverifikasi</span>@else<span class="chip wr">Menunggu verifikasi</span>@endif</h2>
        <p style="color:var(--mu)">Mentor JejakKarier</p>
    </div>
</div>

<div class="stats">
    <div class="card stat"><small>Total slot</small><strong>{{ $daftar->count() }}</strong><span>sesi terdata</span></div>
    <div class="card stat"><small style="color:var(--ok)">Slot tersedia</small><strong>{{ $n('tersedia') }}</strong><span>dapat dipesan mentee</span></div>
    <div class="card stat"><small style="color:var(--p)">Slot dipesan</small><strong style="color:var(--p)">{{ $n('dipesan') }}</strong><span>sesi terjadwal</span></div>
    <div class="card stat"><small>Slot ditutup</small><strong>{{ $n('ditutup') }}</strong><span>nonaktif</span></div>
</div>

<div class="card" style="margin-bottom:22px">
    <div class="bar"><div><h2 style="font-size:17px">Kalender Slot Bulan Ini</h2><p style="color:var(--mu)">{{ $bulan->translatedFormat('F Y') }}</p></div>
        <div class="legend"><span><i style="background:var(--ok)"></i>Tersedia</span><span><i style="background:var(--p)"></i>Dipesan</span><span><i style="background:var(--mu)"></i>Ditutup</span></div></div>
    <div class="cal">
        @foreach (['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $h)<div class="dh">{{ $h }}</div>@endforeach
        @for ($i = 0; $i < $awal; $i++)<div></div>@endfor
        @for ($d = 1; $d <= $bulan->daysInMonth; $d++)
            @php $isi = $perTanggal->get($d); $st = $isi ? ($isi->contains('status', 'dipesan') ? 'dipesan' : ($isi->contains('status', 'tersedia') ? 'tersedia' : 'ditutup')) : ''; @endphp
            <div class="d {{ $st }}">{{ $d }}@if ($isi)<small>{{ $isi->count() }} {{ ucfirst($st) }}</small>@endif</div>
        @endfor
    </div>
</div>

<div class="bar">
    <div class="tabs" id="tab">
        <button type="button" class="on" data-f="semua">Semua ({{ $daftar->count() }})</button>
        <button type="button" data-f="tersedia">Tersedia ({{ $n('tersedia') }})</button>
        <button type="button" data-f="dipesan">Dipesan ({{ $n('dipesan') }})</button>
        <button type="button" data-f="ditutup">Ditutup ({{ $n('ditutup') }})</button>
    </div>
    <input type="search" id="cari" placeholder="Cari tanggal…">
</div>

<div class="card" style="padding:0;overflow-x:auto">
<table id="tabel">
    <thead><tr><th>ID &amp; Tanggal</th><th>Jam sesi</th><th>Status</th><th>Tautan pertemuan</th><th></th></tr></thead>
    <tbody>
    @forelse ($daftar as $s)
        @php $tgl = \Carbon\Carbon::parse($s->tanggal); @endphp
        <tr class="item" data-status="{{ $s->status }}" data-teks="{{ strtolower($tgl->translatedFormat('j F Y l')) }}">
            <td><span class="mono" style="color:var(--p);font-weight:700">#SLT-{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}</span><strong style="display:block">{{ $tgl->translatedFormat('j M Y') }}</strong><small>{{ $tgl->translatedFormat('l') }}</small></td>
            <td>{{ substr($s->jam_mulai, 0, 5) }} – {{ substr($s->jam_selesai, 0, 5) }} WIB</td>
            <td><span class="chip {{ $kelasStatus[$s->status] ?? 'gr' }}">● {{ ucfirst($s->status) }}</span></td>
            <td><a class="mono" href="{{ $s->tautan_pertemuan }}" target="_blank" rel="noopener noreferrer">{{ \Illuminate\Support\Str::limit(preg_replace('#^https?://#', '', $s->tautan_pertemuan), 34) }}</a></td>
            <td style="white-space:nowrap;text-align:right">
                @if ($s->status === 'dipesan')
                    <a class="btn soft sm" href="{{ route('sesi.index') }}">Lihat sesi</a>
                @else
                    <a class="btn soft sm" href="{{ route('mentor.slot.edit', $s) }}">Ubah</a>
                    <form method="POST" action="{{ route('mentor.slot.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Hapus slot ini?')">@csrf @method('DELETE')<button class="btn bad sm">Hapus</button></form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="empty">Belum ada slot. Klik “Tambah Slot Baru”.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@endsection

@push('skrip')
<script>
(function(){
  var f='semua', q='';
  function tampil(){document.querySelectorAll('#tabel .item').forEach(function(el){
    el.style.display=((f==='semua'||el.dataset.status===f)&&el.dataset.teks.indexOf(q)>-1)?'':'none';});}
  document.querySelectorAll('#tab button').forEach(function(b){b.onclick=function(){
    document.querySelectorAll('#tab button').forEach(function(x){x.classList.remove('on')});b.classList.add('on');f=b.dataset.f;tampil();};});
  document.getElementById('cari').oninput=function(e){q=e.target.value.toLowerCase();tampil();};
})();
</script>
@endpush