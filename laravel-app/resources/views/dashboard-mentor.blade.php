{{-- Dashboard MENTOR. DashboardController@mentor: $profil, $entri, $slot, $sesi, $menunggu, $berikutnya, $syarat, $jadwal --}}
@extends('layouts.dasbor')
@section('judul', 'Ringkasan Mentor')
@section('isi')
@php
    $layak = collect($syarat)->every(fn ($v) => $v);
    $kelasSlot = ['tersedia' => 'ok', 'dipesan' => '', 'ditutup' => 'gr'];
@endphp
<div class="head">
    <div><div class="eyebrow">Ringkasan Mentor</div><h1>Halo, {{ auth()->user()->name }}!</h1>
        <p>{{ $profil->jabatan }}. Kelola portofolio, jadwal, dan sesi mentoringmu dari sini.</p></div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn soft" href="{{ route('mentor.portofolio.create') }}">+ Tambah Entri</a>
        <a class="btn" href="{{ route('mentor.slot.create') }}">+ Tambah Mentoring</a>
    </div>
</div>

<div class="stats">
    <a class="card stat" href="{{ route('mentor.portofolio.index') }}"><small>Portofolio</small><strong>{{ $entri->count() }}</strong><span>{{ $entri->where('status', 'terbit')->count() }} terbit</span></a>
    <a class="card stat" href="{{ route('mentor.slot.index') }}"><small>Slot tersedia</small><strong>{{ $slot->where('status', 'tersedia')->count() }}</strong><span>{{ $slot->where('status', 'dipesan')->count() }} dipesan</span></a>
    <a class="card stat" href="{{ route('sesi.index') }}"><small>Menunggu konfirmasi</small><strong>{{ $sesi->where('status', 'diajukan')->count() }}</strong></a>
    <a class="card stat" href="{{ route('sesi.index') }}"><small>Sesi selesai</small><strong>{{ $sesi->where('status', 'selesai')->count() }}</strong></a>
</div>

<div class="card" style="margin-bottom:16px">
    <div class="bar" style="margin-bottom:6px">
        <div><h3>Jadwal mentoring mendatang</h3><p style="color:var(--mu)">Tanggal-tanggal kamu membuka sesi mentoring.</p></div>
        <a class="btn" href="{{ route('mentor.slot.create') }}">+ Tambah Mentoring</a>
    </div>
    @forelse ($jadwal as $hari => $slots)
        @php $tgl = \Carbon\Carbon::parse($hari); @endphp
        <div class="row" style="align-items:flex-start">
            <div style="width:170px;flex:none">
                <strong>{{ $tgl->translatedFormat('D, j M Y') }}</strong>
                @if ($tgl->isToday())<span class="chip wr" style="margin-left:6px">Hari ini</span>@elseif ($tgl->isTomorrow())<span class="chip" style="margin-left:6px">Besok</span>@endif
            </div>
            <div class="tags" style="flex:1">
                @foreach ($slots as $s)
                    @php $aktif = $s->sesiMentoring->firstWhere(fn ($x) => $x->status !== 'dibatalkan'); @endphp
                    <span class="chip {{ $kelasSlot[$s->status] ?? 'gr' }}">{{ substr($s->jam_mulai, 0, 5) }}–{{ substr($s->jam_selesai, 0, 5) }} · {{ $s->status === 'dipesan' && $aktif ? $aktif->user->name : ucfirst($s->status) }}</span>
                @endforeach
            </div>
        </div>
    @empty
        <p class="empty" style="padding:28px 0">Belum ada jadwal mentoring. Klik “+ Tambah Mentoring” untuk membuka sesi pada tanggal tertentu.</p>
    @endforelse
    <p style="margin-top:12px"><a class="link" href="{{ route('sesi.index') }}">Lihat semua jadwal &amp; sesi →</a></p>
</div>

<div class="grid2">
    <div class="card">
        <h3>Perlu tindakan</h3>
        @forelse ($menunggu as $s)
            @php $sl = $s->slotMentoring; @endphp
            <div class="row" style="padding:14px 0">
                <span class="av">{{ strtoupper(mb_substr($s->user->name ?? '?', 0, 1)) }}</span>
                <div class="info">
                    <strong>{{ $s->user->name ?? '—' }}</strong>
                    <div class="meta">{{ \Illuminate\Support\Str::limit($s->tujuan_sesi, 45) }} · {{ $sl->tanggal->translatedFormat('D, j M') }} {{ substr($sl->jam_mulai, 0, 5) }}</div>
                </div>
                <div class="acts">
                    <form method="POST" action="{{ route('sesi.konfirmasi', $s) }}">@csrf @method('PATCH')<button class="btn ok sm">Setuju</button></form>
                    <a class="btn soft sm" href="{{ route('sesi.show', $s) }}">Detail</a>
                </div>
            </div>
        @empty
            <p class="empty" style="padding:28px 0">Tidak ada permintaan sesi yang menunggu.</p>
        @endforelse

        @if ($berikutnya)
            @php $sl = $berikutnya->slotMentoring; @endphp
            <div class="lbl">Sesi terkonfirmasi berikutnya</div>
            <div class="box"><strong>{{ $berikutnya->user->name ?? '—' }}</strong> · {{ $sl->tanggal->isToday() ? 'Hari ini' : $sl->tanggal->translatedFormat('D, j M Y') }}, {{ substr($sl->jam_mulai, 0, 5) }} WIB
                <br><a class="link" href="{{ route('sesi.show', $berikutnya) }}">Buka detail sesi →</a></div>
        @endif
    </div>

    <div class="card">
        <h3>Status tampil di katalog</h3>
        <p style="color:var(--mu);margin:4px 0 10px">{{ $layak ? 'Profilmu sudah tampil di katalog pengguna.' : 'Lengkapi syarat berikut agar profilmu tampil di katalog.' }}</p>
        <ul class="cl">
            @foreach ($syarat as $teks => $ok)
                <li><span class="ic {{ $ok ? 'y' : '' }}">{{ $ok ? '✓' : '–' }}</span>{{ $teks }}</li>
            @endforeach
        </ul>
        @if ($layak)
            <p style="margin-top:14px"><a class="link" href="{{ route('portofolio.publik.index', $profil->id) }}" target="_blank" rel="noopener">Lihat halaman publikku ↗</a></p>
        @elseif (! $entri->where('status', 'terbit')->count())
            <p style="margin-top:14px"><a class="link" href="{{ route('mentor.portofolio.index') }}">Terbitkan portofolio →</a></p>
        @endif
    </div>
</div>
@endsection