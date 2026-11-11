{{-- SlotMentoringController@tersedia  |  variabel: $mentor (ProfilMentor + user), $daftar (slot tersedia mulai hari ini) --}}
@extends('layouts.publik')
@section('judul', 'Pesan Sesi dengan ' . $mentor->user->name)
@section('isi')
@php
    $rt = fn ($n, $p = []) => \Illuminate\Support\Facades\Route::has($n) ? route($n, $p) : '#';
    $milikSendiri = auth()->check() && $mentor->user_id == auth()->id();
    $perHari = $daftar->groupBy(fn ($s) => \Carbon\Carbon::parse($s->tanggal)->format('Y-m-d'));
    $slotError = old('slot_id');
@endphp
<section class="hero" style="padding-bottom:20px">
    <div class="eyebrow">Pesan Sesi Mentoring</div>
    <div class="mhead" style="margin-top:14px">
        <span class="av">{{ strtoupper(mb_substr($mentor->user->name, 0, 1)) }}</span>
        <div><h1 style="font-size:32px">{{ $mentor->user->name }}</h1>
            <p style="margin-top:6px">Pilih slot yang tersedia, tulis tujuan sesimu, lalu ajukan. Mentor akan mengonfirmasi pesananmu.</p></div>
    </div>
</section>

<div class="pwrap narrow">
    <p style="margin-bottom:18px">
        <a href="{{ $rt('katalog.show', $mentor->id) }}" style="color:var(--mu);font-weight:600">← Profil mentor</a>
        <span style="color:var(--bd)"> | </span>
        <a href="{{ $rt('portofolio.publik.index', $mentor->id) }}" style="color:var(--p);font-weight:600">Lihat portofolio</a>
    </p>

    @if ($milikSendiri)<div class="flash er">Ini slot milikmu sendiri, jadi tidak bisa dipesan.</div>@endif
    @if ($errors->any())<div class="flash er">{{ $errors->first() }}</div>@endif

    @forelse ($perHari as $hari => $slots)
        <h2 style="font-size:16px;margin:24px 0 10px">{{ \Carbon\Carbon::parse($hari)->translatedFormat('l, j F Y') }}</h2>
        <div style="display:grid;gap:12px">
        @foreach ($slots as $s)
            <details class="card slotcard" style="padding:16px 20px" {{ $slotError == $s->id ? 'open' : '' }}>
                <summary style="display:flex;justify-content:space-between;align-items:center;gap:12px">
                    <span><strong style="font-size:17px">{{ substr($s->jam_mulai, 0, 5) }} – {{ substr($s->jam_selesai, 0, 5) }} WIB</strong>
                        <span class="chip ok" style="margin-left:8px">● Tersedia</span></span>
                    @unless ($milikSendiri)<span class="btn sm">Pesan slot ini</span>@endunless
                </summary>
                @unless ($milikSendiri)
                    @auth
                        <form method="POST" action="{{ $rt('sesi.store', $s) }}" style="margin-top:16px">
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
                    @else
                        <p style="margin-top:14px;color:var(--mu)">Silakan <a href="{{ $rt('login') }}" style="color:var(--p);font-weight:700">masuk</a> untuk memesan slot ini.</p>
                    @endauth
                @endunless
            </details>
        @endforeach
        </div>
    @empty
        <div class="card empty">Belum ada slot tersedia untuk mentor ini. Coba lagi nanti.</div>
    @endforelse
</div>
@endsection