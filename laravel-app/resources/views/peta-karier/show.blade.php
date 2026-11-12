@extends('layouts.dasbor')
@section('judul', 'Peta Karier')
@section('isi')
<a class="back" href="{{ route('peta-karier.index') }}">← Semua peta karier</a>

<div class="head">
    <div><h1 style="font-size:26px">{{ $rencana->tujuan }}</h1>@if ($rencana->deskripsi)<p>{{ $rencana->deskripsi }}</p>@endif</div>
    <span class="chip {{ $rencana->status === 'tercapai' ? 'ok' : 'wr' }}">{{ $rencana->status === 'tercapai' ? 'Tercapai' : 'Berjalan' }}</span>
</div>

<div class="card" style="margin-bottom:16px">
    <div style="display:flex;justify-content:space-between;font-weight:600"><span>Progres</span><span>{{ $rencana->progres() }}%</span></div>
    <div class="prog" style="margin-top:10px"><i style="width:{{ $rencana->progres() }}%"></i></div>
    @if ($rencana->target_selesai)<p class="note" style="margin-top:10px">Target selesai: {{ $rencana->target_selesai->format('d M Y') }}</p>@endif
</div>

<div class="card" style="margin-bottom:16px">
    <h3>Langkah belajar</h3>
    <div style="margin-top:8px">
        @forelse ($rencana->langkah as $l)
            <div class="lstep">
                <form method="POST" action="{{ route('peta-karier.langkah.toggle', $l) }}" style="display:flex;align-items:center;gap:12px">
                    @csrf @method('PATCH')
                    <button type="submit" class="ck {{ $l->selesai ? 'on' : '' }}">@if ($l->selesai)✓@endif</button>
                    <div>
                        <strong class="{{ $l->selesai ? 'done' : '' }}">{{ $l->judul }}</strong>
                        @if ($l->target_tanggal)<div class="note" style="margin:0">Target {{ $l->target_tanggal->format('d M Y') }}</div>@endif
                    </div>
                </form>
                <form method="POST" action="{{ route('peta-karier.langkah.destroy', $l) }}" onsubmit="return confirm('Hapus langkah ini?')">
                    @csrf @method('DELETE')<button type="submit" class="btn bad sm">Hapus</button>
                </form>
            </div>
        @empty
            <p class="empty" style="padding:20px 0">Belum ada langkah. Tambahkan di bawah.</p>
        @endforelse
    </div>

    <form method="POST" action="{{ route('peta-karier.langkah.store', $rencana) }}" class="inline">
        @csrf
        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Langkah baru...">
        <input type="date" name="target_tanggal" value="{{ old('target_tanggal') }}">
        <button type="submit" class="btn">Tambah</button>
    </form>
    @error('judul')<div class="note er">{{ $message }}</div>@enderror
    @error('target_tanggal')<div class="note er">{{ $message }}</div>@enderror
</div>

<div class="card hero-card" style="margin-bottom:16px">
    <div class="eyebrow">Butuh arahan?</div>
    <h2>Diskusikan peta kariermu dengan mentor</h2>
    <p>Pilih mentor di bidang yang kamu tuju dan pesan sesi 1-on-1.</p>
    <a class="btn" href="{{ route('katalog.index') }}">Cari mentor</a>
</div>

<div style="display:flex;gap:10px">
    <a class="btn soft" href="{{ route('peta-karier.edit', $rencana) }}">Ubah</a>
    <form method="POST" action="{{ route('peta-karier.destroy', $rencana) }}" onsubmit="return confirm('Hapus peta karier ini beserta langkahnya?')">
        @csrf @method('DELETE')<button type="submit" class="btn bad">Hapus</button>
    </form>
</div>
@endsection