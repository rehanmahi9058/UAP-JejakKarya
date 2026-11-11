{{-- SesiMentoringController@show  |  variabel: $sesi (SesiMentoring + slotMentoring.profilMentor.user + user) --}}
@extends('layouts.dasbor')
@section('judul', 'Detail Sesi Mentoring')
@section('isi')
@php
    $v = fn ($n) => collect(\Illuminate\Support\Facades\Route::getRoutes()->getByName($n)?->methods() ?? ['POST'])->first(fn ($m) => ! in_array($m, ['GET', 'HEAD'])) ?? 'POST';
    $mentor = auth()->user()->peran === 'mentor';
    $slot = $sesi->slotMentoring;
    $tgl = \Carbon\Carbon::parse($slot->tanggal);
    $kelas = ['diajukan' => 'wr', 'dikonfirmasi' => '', 'selesai' => 'ok', 'dibatalkan' => 'er'][$sesi->status] ?? 'gr';
    $lawan = $mentor ? $sesi->user : $slot->profilMentor->user;
    $tampilTautan = $mentor ? in_array($sesi->status, ['diajukan', 'dikonfirmasi']) : $sesi->status === 'dikonfirmasi';
@endphp
<a href="{{ route('sesi.index') }}" style="color:var(--mu);font-weight:600">← Kembali ke daftar sesi</a>

<div class="card" style="margin:14px 0 20px;background:linear-gradient(135deg,#fff,#f1edff)">
    <span class="chip {{ $kelas }}">{{ strtoupper($sesi->status) }}</span>
    <span class="chip gr mono">ID Sesi: #SES-{{ str_pad($sesi->id, 4, '0', STR_PAD_LEFT) }}</span>
    <span class="chip gr mono">Slot: #SLT-{{ str_pad($slot->id, 4, '0', STR_PAD_LEFT) }}</span>
    <h1 style="font-size:26px;font-weight:800;margin:12px 0 6px;letter-spacing:-.02em">Sesi mentoring 1-on-1 bersama {{ $lawan->name ?? '—' }}</h1>
    <p style="color:var(--mu)">{{ $tgl->translatedFormat('l, j F Y') }} · {{ substr($slot->jam_mulai, 0, 5) }}–{{ substr($slot->jam_selesai, 0, 5) }} WIB</p>
    @if ($tampilTautan)
        <p style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap">
            <a class="btn" href="{{ $slot->tautan_pertemuan }}" target="_blank" rel="noopener noreferrer">Gabung Pertemuan</a>
            <button type="button" class="btn soft" id="salin" data-url="{{ $slot->tautan_pertemuan }}">Salin Tautan</button>
        </p>
    @endif
</div>

<div class="grid2">
    <div class="card">
        <div style="display:flex;gap:14px;align-items:center">
            <span class="av" style="width:56px;height:56px;font-size:20px">{{ strtoupper(mb_substr($lawan->name ?? '?', 0, 1)) }}</span>
            <div><strong style="font-size:17px">{{ $lawan->name ?? '—' }}</strong><br><small style="color:var(--mu)">{{ $mentor ? 'Mentee (pemesan sesi)' : 'Mentor' }}</small></div>
        </div>
        <div class="lbl">Tujuan sesi</div>
        <div class="box">{{ $sesi->tujuan_sesi }}</div>
        @if ($sesi->catatan)
            <div class="lbl">Catatan tambahan</div>
            <div class="box">{{ $sesi->catatan }}</div>
        @endif
    </div>

    <div class="card">
        <h2 style="font-size:18px">Jadwal &amp; Tindakan</h2>
        <div class="lbl">Jadwal slot mentoring</div>
        <div class="box"><strong>{{ $tgl->translatedFormat('D, j M Y') }} · {{ substr($slot->jam_mulai, 0, 5) }}–{{ substr($slot->jam_selesai, 0, 5) }} WIB</strong></div>

        @if ($sesi->status === 'diajukan' && ! $mentor)
            <p class="note">Menunggu konfirmasi mentor. Tautan pertemuan akan muncul setelah sesi dikonfirmasi.</p>
        @elseif ($sesi->status === 'dibatalkan')
            <p class="note">Sesi ini dibatalkan. Slot sudah dibuka kembali.</p>
        @elseif ($sesi->status === 'selesai')
            <p class="note">Sesi ini sudah selesai.</p>
        @endif

        <div style="display:flex;gap:10px;margin-top:20px;flex-wrap:wrap">
            @if ($mentor && $sesi->status === 'diajukan')
                <form method="POST" action="{{ route('sesi.konfirmasi', $sesi) }}">@csrf @method($v('sesi.konfirmasi'))<button class="btn ok">Konfirmasi Sesi</button></form>
            @endif
            @if ($mentor && $sesi->status === 'dikonfirmasi')
                <form method="POST" action="{{ route('sesi.selesai', $sesi) }}" onsubmit="return confirm('Tandai sesi ini selesai?')">@csrf @method($v('sesi.selesai'))<button class="btn ok">Tandai Sesi Selesai</button></form>
            @endif
            @if (in_array($sesi->status, ['diajukan', 'dikonfirmasi']))
                <form method="POST" action="{{ route('sesi.batal', $sesi) }}" onsubmit="return confirm('Batalkan sesi ini? Slot akan kembali tersedia.')">@csrf @method($v('sesi.batal'))<button class="btn bad">Batalkan Sesi</button></form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('skrip')
<script>
var s=document.getElementById('salin');
if(s){s.onclick=function(){navigator.clipboard.writeText(s.dataset.url).then(function(){s.textContent='Tersalin ✓';setTimeout(function(){s.textContent='Salin Tautan'},1800);});};}
</script>
@endpush