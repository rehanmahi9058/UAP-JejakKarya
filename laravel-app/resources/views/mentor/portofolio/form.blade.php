{{-- PortofolioMentorController@create / @edit  |  variabel: $entri (EntriPortofolio, kosong saat create), $semuaSkill --}}
@extends('layouts.dasbor')
@section('judul', $entri->exists ? 'Ubah Entri Portofolio' : 'Tambah Entri Portofolio')
@section('isi')
@php
    $v = fn ($n) => collect(\Illuminate\Support\Facades\Route::getRoutes()->getByName($n)?->methods() ?? ['POST'])->first(fn ($m) => ! in_array($m, ['GET', 'HEAD'])) ?? 'POST';
    $edit = $entri->exists;
    $tgl = fn ($d) => $d ? \Carbon\Carbon::parse($d)->format('Y-m-d') : '';
    $dipilih = array_map('intval', (array) old('keterampilan', $edit ? $entri->keterampilan->pluck('id')->all() : []));
    $jenis = ['proyek' => 'Proyek', 'organisasi' => 'Organisasi', 'magang' => 'Magang', 'sertifikat' => 'Sertifikat', 'pekerjaan' => 'Pekerjaan'];
@endphp
<div class="head">
    <div>
        <div class="eyebrow">● Portofolio Mentor</div>
        <h1>{{ $edit ? 'Ubah Entri' : 'Tambah Entri' }}</h1>
        <p>{{ $edit ? 'Perbarui detail karyamu.' : 'Entri baru disimpan sebagai draf. Terbitkan dari daftar portofolio agar tampil di katalog.' }}</p>
    </div>
</div>

<form class="card formcard" method="POST" enctype="multipart/form-data"
      action="{{ $edit ? route('mentor.portofolio.update', $entri) : route('mentor.portofolio.store') }}">
    @csrf
    @if ($edit) @method($v('mentor.portofolio.update')) @endif

    <div class="fg">
        <label for="judul_portofolio">Judul portofolio</label>
        <input type="text" id="judul_portofolio" name="judul_portofolio" maxlength="150" required value="{{ old('judul_portofolio', $entri->judul_portofolio) }}">
        @error('judul_portofolio')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="fg">
        <label for="jenis">Jenis</label>
        <select id="jenis" name="jenis" required>
            <option value="" disabled {{ old('jenis', $entri->jenis) ? '' : 'selected' }}>Pilih jenis…</option>
            @foreach ($jenis as $nilai => $label)<option value="{{ $nilai }}" {{ old('jenis', $entri->jenis) === $nilai ? 'selected' : '' }}>{{ $label }}</option>@endforeach
        </select>
        @error('jenis')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="two">
        <div class="fg">
            <label for="tanggal_mulai">Tanggal mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" required value="{{ old('tanggal_mulai', $tgl($entri->tanggal_mulai)) }}">
            @error('tanggal_mulai')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="tanggal_selesai">Tanggal selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $tgl($entri->tanggal_selesai)) }}">
            <div class="hint">Kosongkan jika masih berjalan.</div>
            @error('tanggal_selesai')<div class="err">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="fg">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi', $entri->deskripsi) }}</textarea>
        @error('deskripsi')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="fg">
        <label for="tautan_proyek">Tautan proyek (opsional)</label>
        <input type="url" id="tautan_proyek" name="tautan_proyek" maxlength="255" placeholder="https://" value="{{ old('tautan_proyek', $entri->tautan_proyek) }}">
        @error('tautan_proyek')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="fg">
        <label for="gambar">Gambar sampul (opsional, maks. 2 MB)</label>
        @if ($entri->gambar)<img class="preview" src="{{ asset('storage/'.$entri->gambar) }}" alt="Gambar saat ini">@endif
        <input type="file" id="gambar" name="gambar" accept="image/*">
        @if ($entri->gambar)<div class="hint">Pilih file baru untuk mengganti gambar saat ini.</div>@endif
        @error('gambar')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="fg">
        <label>Keterampilan</label>
        <div class="checks">
            @forelse ($semuaSkill as $s)
                <label><input type="checkbox" name="keterampilan[]" value="{{ $s->id }}" {{ in_array($s->id, $dipilih) ? 'checked' : '' }}><span>{{ $s->nama_keterampilan }}</span></label>
            @empty
                <span class="hint">Belum ada data keterampilan.</span>
            @endforelse
        </div>
        @error('keterampilan')<div class="err">{{ $message }}</div>@enderror
        @error('keterampilan.*')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="formact">
        <button class="btn" type="submit">{{ $edit ? 'Simpan Perubahan' : 'Simpan sebagai Draf' }}</button>
        <a class="btn soft" href="{{ route('mentor.portofolio.index') }}">Batal</a>
    </div>
</form>
@endsection