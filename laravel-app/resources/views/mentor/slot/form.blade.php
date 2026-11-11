{{-- SlotMentoringController@create / @edit  |  variabel: $slot (SlotMentoring, kosong saat create) --}}
@extends('layouts.dasbor')
@section('judul', $slot->exists ? 'Ubah Slot' : 'Tambah Slot')
@section('isi')
@php
    $v = fn ($n) => collect(\Illuminate\Support\Facades\Route::getRoutes()->getByName($n)?->methods() ?? ['POST'])->first(fn ($m) => ! in_array($m, ['GET', 'HEAD'])) ?? 'POST';
    $edit = $slot->exists;
    $tgl = $slot->tanggal ? \Carbon\Carbon::parse($slot->tanggal)->format('Y-m-d') : '';
    $status = old('status', $slot->status ?: 'tersedia');
@endphp
<div class="head">
    <div><div class="eyebrow">● Slot Jadwal</div><h1>{{ $edit ? 'Ubah Slot' : 'Tambah Slot Baru' }}</h1>
        <p>Tentukan tanggal, jam, dan tautan pertemuan daring. Slot hanya bisa dibuat untuk hari ini atau setelahnya.</p></div>
</div>

<form class="card formcard" method="POST" action="{{ $edit ? route('mentor.slot.update', $slot) : route('mentor.slot.store') }}">
    @csrf
    @if ($edit) @method($v('mentor.slot.update')) @endif

    <div class="fg">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" required min="{{ today()->format('Y-m-d') }}" value="{{ old('tanggal', $tgl) }}">
        @error('tanggal')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="two">
        <div class="fg">
            <label for="jam_mulai">Jam mulai</label>
            <input type="time" id="jam_mulai" name="jam_mulai" required value="{{ old('jam_mulai', substr((string) $slot->jam_mulai, 0, 5)) }}">
            @error('jam_mulai')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="jam_selesai">Jam selesai</label>
            <input type="time" id="jam_selesai" name="jam_selesai" required value="{{ old('jam_selesai', substr((string) $slot->jam_selesai, 0, 5)) }}">
            @error('jam_selesai')<div class="err">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="fg">
        <label for="tautan_pertemuan">Tautan pertemuan (daring)</label>
        <input type="url" id="tautan_pertemuan" name="tautan_pertemuan" required maxlength="255" placeholder="https://meet.google.com/…" value="{{ old('tautan_pertemuan', $slot->tautan_pertemuan) }}">
        @error('tautan_pertemuan')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="fg">
        <label for="status">Status slot</label>
        <select id="status" name="status">
            <option value="tersedia" {{ $status === 'tersedia' ? 'selected' : '' }}>Tersedia (bisa dipesan mentee)</option>
            <option value="ditutup" {{ $status === 'ditutup' ? 'selected' : '' }}>Ditutup (tidak tampil di katalog)</option>
        </select>
        <div class="hint">Slot yang sudah dipesan tidak bisa diubah.</div>
        @error('status')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="formact">
        <button class="btn" type="submit">{{ $edit ? 'Simpan Perubahan' : 'Tambah Slot' }}</button>
        <a class="btn soft" href="{{ route('mentor.slot.index') }}">Batal</a>
    </div>
</form>
@endsection