@extends('layouts.dasbor')
@section('judul', 'Peta Karier')
@section('isi')
<div class="head">
    <div><div class="eyebrow">Peta Karier</div><h1>Peta Karier</h1><p>Rencana belajarmu menuju karier impian.</p></div>
    <a class="btn" href="{{ route('peta-karier.create') }}">+ Buat peta karier</a>
</div>

<div class="grid2" style="grid-template-columns:1fr 1fr">
    @forelse ($daftar as $r)
        <a href="{{ route('peta-karier.show', $r) }}" class="card mc">
            <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start">
                <h3 style="display:block">{{ $r->tujuan }}</h3>
                <span class="chip {{ $r->status === 'tercapai' ? 'ok' : 'wr' }}">{{ $r->status === 'tercapai' ? 'Tercapai' : 'Berjalan' }}</span>
            </div>
            <div class="prog"><i style="width:{{ $r->progres() }}%"></i></div>
            <p class="note" style="margin:0">{{ $r->progres() }}% · {{ $r->langkah_count }} langkah @if ($r->target_selesai) · Target {{ $r->target_selesai->format('d M Y') }} @endif</p>
        </a>
    @empty
        <div class="card empty" style="grid-column:1/-1">Belum ada peta karier. Klik "Buat peta karier" untuk mulai.</div>
    @endforelse
</div>
@endsection