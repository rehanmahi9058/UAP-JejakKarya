{{-- BerandaController@index: $statistik, $slotMinggu, $pilihan, $entri, $skill --}}
@extends('layouts.situs')
@section('judul', 'JejakKarier — Tunjukkan kemampuanmu, temukan arah karirmu')
@section('isi')
@php
    $unggulan = $pilihan->first();
    $e0 = $unggulan ? optional($entri->get($unggulan->user_id))->first() : null;
    $angka = fn ($n) => number_format($n, 0, ',', '.');
@endphp

{{-- HERO --}}
<section class="wrap hero">
    <div>
        <h1>Tunjukkan kemampuanmu, <span>temukan arah karirmu</span></h1>
        <p class="lead">Wadah rekam JejakKarier profesional untuk talenta muda, fresh graduate, freelancer kreatif, dan mahasiswa di Indonesia. Publikasikan portofolio terverifikasi, taklukkan milestone karier, dan bangun relasi langsung dengan mentor industri.</p>
        <a class="btn soft" href="{{ route('katalog.index') }}">👁 Lihat Katalog Talenta</a>
        <div class="stat3">
            <div><strong>{{ $angka($statistik['karya']) }}</strong><small>Karya Terbit</small></div>
            <div><strong>{{ $angka($statistik['mentor']) }}</strong><small>Mentor Terverifikasi</small></div>
            <div><strong>{{ $angka($statistik['bidang']) }}</strong><small>Bidang Karier</small></div>
        </div>
    </div>

    <div class="sorot">
        @if ($unggulan)
            <div class="mini">
                <span class="av">{{ strtoupper(mb_substr($unggulan->user->name, 0, 1)) }}</span>
                <div><strong>{{ $unggulan->user->name }}</strong><div class="sm" style="color:var(--mu);font-size:12px">{{ $unggulan->jabatan }}</div></div>
                <span class="badge-ok">Terverifikasi</span>
            </div>
            <div class="gbr">
                @if ($e0 && $e0->gambar)<img src="{{ asset('storage/'.$e0->gambar) }}" alt="">@else<div class="kosong">▣</div>@endif
                <div class="cap"><small>Karya Unggulan</small><br>{{ $e0->judul_portofolio ?? '' }}</div>
            </div>
            <div class="info"><span>📅 Sesi tersedia minggu ini: {{ $slotMinggu }} slot</span><span>1-on-1</span></div>
        @else
            <div style="text-align:center;padding:30px 10px">
                <img src="{{ asset('img/maskot-sapa.png') }}" alt="Maskot JejakKarier" style="width:180px">
                <p style="color:var(--mu);margin-top:10px">Portofolio mentor terverifikasi akan tampil di sini.</p>
            </div>
        @endif
    </div>
</section>

{{-- FITUR --}}
<section class="wrap seksi">
    <div class="sh">
        <div><span class="eyebrow">Fitur Revolusioner</span><h2>Dirancang Khusus untuk Akselerasi Kariermu</h2></div>
        <p>Setiap fitur terintegrasi secara holistik untuk menjembatani kesenjangan talenta dan industri di pasar digital modern.</p>
    </div>
    <div class="fitur">
        <div class="kartu">
            <div class="ik" style="background:#dcf6ec;color:#0f9d6b">📈</div>
            <h3>Peta Karier Terstruktur</h3>
            <p>Pecah impian kariermu menjadi target milestone realistis bertanggal. Dilengkapi indikator progres dinamis dan transisi otomatis ke status “Tercapai” saat semua langkah selesai.</p>
            <div class="bawah"><span>Progres = langkah selesai ÷ total langkah</span><a href="{{ Route::has('peta-karier.index') ? route('peta-karier.index') : '#' }}" style="color:var(--p)">Buka →</a></div>
        </div>
        <img class="mk" src="{{ asset('img/maskot-sapa.png') }}" alt="Maskot JejakKarier">
        <div class="kartu">
            <div class="ik" style="background:var(--p-l);color:var(--p)">🙋</div>
            <h3>1-on-1 Mentoring Terverifikasi</h3>
            <p>Pilih mentor dari bukti kerjanya, lalu pesan jadwal sesi pendampingan langsung bersama praktisi industri. Tautan pertemuan muncul setelah sesi dikonfirmasi mentor.</p>
            <div class="bawah"><span>Tersedia {{ $slotMinggu }} slot minggu ini</span><a href="{{ route('katalog.index') }}" style="color:var(--p)">Booking →</a></div>
        </div>
    </div>
</section>

{{-- PORTOFOLIO PILIHAN --}}
<section class="wrap seksi" style="padding-top:20px">
    <div class="sh" style="margin-bottom:26px">
        <div><span class="eyebrow">● Katalog Unggulan</span><h2>Portofolio Pilihan Terbaru</h2>
            <p style="margin-top:6px;max-width:none">Hanya menampilkan talenta dengan minimal 1 entri terbit terkurasi dan sekurang-kurangnya 3 keterampilan terverifikasi.</p></div>
        <a href="{{ route('katalog.index') }}" style="color:var(--p);font-weight:700">Jelajahi Semua Portofolio →</a>
    </div>
    <div class="grid3">
        @forelse ($pilihan as $m)
            @php $daftarEntri = $entri->get($m->user_id, collect()); $e = $daftarEntri->first(); @endphp
            <div class="pk">
                <div class="gbr">
                    <span class="tag">{{ $m->bidangKarier->nama ?? '-' }}</span><span class="tag r">{{ $daftarEntri->count() }} Terbit</span>
                    @if ($e->gambar)<img src="{{ asset('storage/'.$e->gambar) }}" alt="{{ $e->judul_portofolio }}">@else<div class="kosong">▣</div>@endif
                </div>
                <div class="mini"><span class="av">{{ strtoupper(mb_substr($m->user->name, 0, 1)) }}</span>
                    <div><div class="nm">{{ $m->user->name }} <span style="color:var(--p)">✔</span></div><div class="sub">{{ $m->jabatan }}</div></div></div>
                <h3>{{ \Illuminate\Support\Str::limit($e->judul_portofolio, 60) }}</h3>
                <p class="ds">{{ \Illuminate\Support\Str::limit($e->deskripsi, 110) }}</p>
                <div class="tags">@foreach ($skill->get($m->user_id, collect())->take(3) as $s)<span>{{ $s->nama_keterampilan }}</span>@endforeach</div>
                <div class="kaki"><small>Diperbarui {{ \Illuminate\Support\Carbon::parse($e->created_at)->locale('id')->diffForHumans() }}</small>
                    <a class="btn sm" href="{{ route('portofolio.publik.show', [$m->id, $e->id]) }}">Lihat Detail ›</a></div>
            </div>
        @empty
            <div class="kosong-s">Belum ada portofolio terbit dari mentor terverifikasi. Jadilah yang pertama!</div>
        @endforelse
    </div>
</section>

{{-- BANNER MENTOR --}}
<section class="wrap" style="padding:30px 28px 10px">
    <div class="banner">
        <div>
            <span class="eyebrow">Inisiatif Kolaboratif Industri</span>
            <h2>Punya Pengalaman di Industri? Jadilah Mentor Terverifikasi di JejakKarier</h2>
            <p>Bantu generasi muda dan talenta lepas Indonesia membuka peluang karier yang adil dan bermartabat. Dapatkan lencana verifikasi resmi, kelola sesi bimbingan fleksibel, dan bangun reputasi profesionalmu.</p>
            <ul><li>Bebas Atur Waktu &amp; Topik</li><li>Lencana Verifikasi Admin</li><li>Dukungan Komunitas SDG 8</li></ul>
        </div>
        <div class="aksi">
            <a class="btn putih" href="{{ Route::has('register') ? route('register') : '#' }}">Daftar Menjadi Mentor</a>
            <a href="{{ route('katalog.index') }}" style="font-weight:600">Pelajari Portofolio Mentor ↗</a>
        </div>
    </div>
</section>
@endsection
