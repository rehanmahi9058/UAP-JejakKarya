{{-- SlotMentoringController@tersedia  |  variabel: $mentor (ProfilMentor + user), $daftar (slot tersedia mulai hari ini) --}}
@extends('layouts.dasbor')
@section('judul', 'Pesan Sesi dengan ' . $mentor->user->name)
@section('isi')
@php
    $milikSendiri = $mentor->user_id == auth()->id();
    $perHari = $daftar->groupBy(fn ($s) => \Carbon\Carbon::parse($s->tanggal)->format('Y-m-d'));
    $slotError = old('slot_id');
@endphp
<a class="back" href="{{ route('katalog.show', $mentor->id) }}">← Profil mentor</a>

<div class="head">
    <div class="mhead">
        <span class="av">{{ strtoupper(mb_substr($mentor->user->name, 0, 1)) }}</span>
        <div><div class="eyebrow">Pesan Sesi Mentoring</div><h1 style="font-size:26px">{{ $mentor->user->name }}</h1>
            <p>Pilih slot yang tersedia, tulis tujuan sesimu, lalu ajukan. Mentor akan mengonfirmasi pesananmu.</p></div>
    </div>
    <a class="btn soft" href="{{ route('portofolio.publik.index', $mentor->id) }}">Lihat portofolio</a>
</div>

@if ($milikSendiri)<div class="flash er">Ini slot milikmu sendiri, jadi tidak bisa dipesan.</div>@endif
@if ($errors->any())<div class="flash er">{{ $errors->first() }}</div>@endif

@forelse ($perHari as $hari => $slots)
    <h2 style="font-size:16px;margin:22px 0 10px">{{ \Carbon\Carbon::parse($hari)->translatedFormat('l, j F Y') }}</h2>
    <div style="display:grid;gap:12px">
    @foreach ($slots as $s)
        <details class="card slotcard" style="padding:16px 20px" {{ $slotError == $s->id ? 'open' : '' }}>
            <summary style="display:flex;justify-content:space-between;align-items:center;gap:12px">
                <span><strong style="font-size:17px">{{ substr($s->jam_mulai, 0, 5) }} – {{ substr($s->jam_selesai, 0, 5) }} WIB</strong>
                    <span class="chip ok" style="margin-left:8px">● Tersedia</span></span>
                @unless ($milikSendiri)<span class="btn sm">Pesan slot ini</span>@endunless
            </summary>
            @unless ($milikSendiri)
                <form method="POST" action="{{ route('sesi.store', $s) }}" style="margin-top:16px">
                    @csrf
                    <input type="hidden" name="slot_id" value="{{ $s->id }}">
                    <div class="fg">
                        <label for="tujuan-{{ $s->id }}">Tujuan sesi</label>
                        <textarea id="tujuan-{{ $s->id }}" name="tujuan_sesi" maxlength="1000" required placeholder="Apa yang ingin kamu bahas atau capai di sesi ini?">{{ $slotError == $s->id ? old('tujuan_sesi') : '' }}</textarea>
                        @if ($slotError == $s->id)@error('tujuan_sesi')<div class="err">{{ $message }}</div>@enderror @endif
                    </div>
                    <div class="fg">
                        <label for="catatan-{{ $s->id }}">Catatan tambahan (opsional)</label>
                        <textarea id="catatan-{{ $s->id }}" name="catatan" maxlength="1000" style="min-height:80px">{{ $slotError == $s->id ? old('catatan') : '' }}</textarea>
                    </div>
                    <button class="btn" type="submit">Ajukan Sesi</button>
                </form>
            @endunless
        </details>
    @endforeach
    </div>
@empty
    <div class="card empty">Belum ada slot tersedia untuk mentor ini. Coba lagi nanti atau <a class="link" href="{{ route('katalog.index') }}">cari mentor lain</a>.</div>
@endforelse
@endsection