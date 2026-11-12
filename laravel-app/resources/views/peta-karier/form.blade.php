@extends('layouts.dasbor')
@section('judul', 'Peta Karier')
@section('isi')
<a class="back" href="{{ route('peta-karier.index') }}">← Semua peta karier</a>
<div class="head"><div><h1>{{ $rencana->exists ? 'Ubah peta karier' : 'Buat peta karier' }}</h1></div></div>

<form method="POST" action="{{ $rencana->exists ? route('peta-karier.update', $rencana) : route('peta-karier.store') }}" class="card formcard">
    @csrf
    @if ($rencana->exists) @method('PUT') @endif

    <div class="fg">
        <label for="tujuan">Tujuan karier</label>
        <input type="text" id="tujuan" name="tujuan" value="{{ old('tujuan', $rencana->tujuan) }}" placeholder="Contoh: Menjadi Product Designer">
        @error('tujuan')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="fg">
        <label for="deskripsi">Deskripsi (opsional)</label>
        <textarea id="deskripsi" name="deskripsi" style="min-height:90px">{{ old('deskripsi', $rencana->deskripsi) }}</textarea>
        @error('deskripsi')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="fg">
        <label for="target_selesai">Target selesai (opsional)</label>
        <input type="date" id="target_selesai" name="target_selesai" value="{{ old('target_selesai', optional($rencana->target_selesai)->format('Y-m-d')) }}">
        @error('target_selesai')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="formact">
        <button type="submit" class="btn">Simpan</button>
        <a class="btn soft" href="{{ route('peta-karier.index') }}">Batal</a>
    </div>
</form>
@endsection