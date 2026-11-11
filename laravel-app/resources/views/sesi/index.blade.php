{{-- SesiMentoringController@index  |  variabel: $daftar (SesiMentoring + slotMentoring.profilMentor.user + user) --}}
@extends('layouts.dasbor')
@section('judul', 'Sesi Mentoring')
@section('isi')
@php
    $v = fn ($n) => collect(\Illuminate\Support\Facades\Route::getRoutes()->getByName($n)?->methods() ?? ['POST'])->first(fn ($m) => ! in_array($m, ['GET', 'HEAD'])) ?? 'POST';
    $mentor = auth()->user()->peran === 'mentor';
    $n = fn ($s) => $daftar->where('status', $s)->count();
    $kelas = ['diajukan' => 'wr', 'dikonfirmasi' => '', 'selesai' => 'ok', 'dibatalkan' => 'er'];
@endphp
<div class="head">
    <div><h1>{{ $mentor ? 'Manajemen & Riwayat Sesi' : 'Sesi Mentoring Saya' }}</h1>
        <p>{{ $mentor ? 'Kelola sesi yang masuk ke slotmu: konfirmasi, batalkan, atau tandai selesai.' : 'Pantau sesi yang kamu pesan beserta statusnya.' }}</p></div>
    @unless ($mentor)<a class="btn" href="{{ route('katalog.index') }}">+ Cari Mentor</a>@endunless
</div>

<div class="tabs" id="tab" style="margin-bottom:16px">
    <button type="button" class="on" data-f="semua">Semua ({{ $daftar->count() }})</button>
    <button type="button" data-f="dikonfirmasi">Dikonfirmasi ({{ $n('dikonfirmasi') }})</button>
    <button type="button" data-f="diajukan">Diajukan ({{ $n('diajukan') }})</button>
    <button type="button" data-f="selesai">Selesai ({{ $n('selesai') }})</button>
    <button type="button" data-f="dibatalkan">Dibatalkan ({{ $n('dibatalkan') }})</button>
</div>

<div class="card" style="padding:0;overflow-x:auto">
<table id="tabel">
    <thead><tr><th>ID &amp; Slot</th><th>{{ $mentor ? 'Mentee' : 'Mentor' }}</th><th>Tujuan sesi</th><th>Jadwal</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    @forelse ($daftar as $s)
        @php
            $slot = $s->slotMentoring;
            $tgl = \Carbon\Carbon::parse($slot->tanggal);
            $lawan = $mentor ? $s->user : $slot->profilMentor->user;
        @endphp
        <tr class="item" data-status="{{ $s->status }}">
            <td><a href="{{ route('sesi.show', $s) }}" class="mono" style="color:var(--p);font-weight:700">#SES-{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}</a><small class="mono">Slot #SLT-{{ str_pad($slot->id, 4, '0', STR_PAD_LEFT) }}</small></td>
            <td><div style="display:flex;gap:10px;align-items:center"><span class="av">{{ strtoupper(mb_substr($lawan->name ?? '?', 0, 1)) }}</span><strong>{{ $lawan->name ?? '—' }}</strong></div></td>
            <td>{{ \Illuminate\Support\Str::limit($s->tujuan_sesi, 50) }}</td>
            <td><strong>{{ $tgl->isToday() ? 'Hari ini' : $tgl->translatedFormat('D, j M Y') }}, {{ substr($slot->jam_mulai, 0, 5) }} WIB</strong><small>s/d {{ substr($slot->jam_selesai, 0, 5) }} WIB</small></td>
            <td><span class="chip {{ $kelas[$s->status] ?? 'gr' }}">{{ ucfirst($s->status) }}</span></td>
            <td style="white-space:nowrap">
                @if ($mentor && $s->status === 'diajukan')
                    <form method="POST" action="{{ route('sesi.konfirmasi', $s) }}" style="display:inline">@csrf @method($v('sesi.konfirmasi'))<button class="btn ok sm">Setuju</button></form>
                @endif
                @if (in_array($s->status, ['diajukan', 'dikonfirmasi']))
                    <form method="POST" action="{{ route('sesi.batal', $s) }}" style="display:inline" onsubmit="return confirm('Batalkan sesi ini? Slot akan kembali tersedia.')">@csrf @method($v('sesi.batal'))<button class="btn bad sm">{{ $mentor && $s->status === 'diajukan' ? 'Tolak' : 'Batalkan' }}</button></form>
                @endif
                <a class="btn soft sm" href="{{ route('sesi.show', $s) }}">Detail</a>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="empty">Belum ada sesi mentoring.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@endsection

@push('skrip')
<script>
document.querySelectorAll('#tab button').forEach(function(b){b.onclick=function(){
  document.querySelectorAll('#tab button').forEach(function(x){x.classList.remove('on')});b.classList.add('on');
  document.querySelectorAll('#tabel .item').forEach(function(el){el.style.display=(b.dataset.f==='semua'||el.dataset.status===b.dataset.f)?'':'none';});};});
</script>
@endpush