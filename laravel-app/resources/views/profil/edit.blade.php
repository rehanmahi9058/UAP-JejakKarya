{{-- ProfilPenggunaController@edit: $profil. Dipakai pengguna dan mentor (layout menyesuaikan peran). --}}
@extends('layouts.dasbor')
@section('judul', 'Profil Saya')
@section('isi')
@php $mentor = auth()->user()->peran === 'mentor'; @endphp
<div class="head">
    <div><div class="eyebrow">Akun</div><h1>Profil Saya</h1>
        <p>{{ $mentor ? 'Perbarui data dirimu. Jabatan dan keterampilan mentor tampil lewat portofolio publikmu.' : 'Lengkapi profilmu agar mentor mengenal tujuanmu.' }}</p></div>
    @if ($mentor)<a class="btn soft" href="{{ route('mentor.portofolio.index') }}">Kelola portofolio</a>@endif
</div>

<form method="POST" action="{{ route('profil.update') }}" class="card formcard">
    @csrf
    @method('PUT')

    <div class="fg">
        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
        @error('name')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="fg">
        <label for="status_pengguna">Saya adalah</label>
        <select id="status_pengguna" name="status_pengguna">
            @foreach (['pemula' => 'Pemula', 'mahasiswa' => 'Mahasiswa', 'freelancer' => 'Freelancer', 'umum' => 'Masyarakat umum'] as $nilai => $label)
                <option value="{{ $nilai }}" @selected(old('status_pengguna', $profil->status_pengguna ?? 'pemula') === $nilai)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status_pengguna')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="fg">
        <label for="bidang_minat">Bidang minat</label>
        <input type="text" id="bidang_minat" name="bidang_minat" value="{{ old('bidang_minat', $profil->bidang_minat) }}" placeholder="Contoh: UI/UX Design">
        @error('bidang_minat')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="fg">
        <label for="kota">Kota</label>
        <input type="text" id="kota" name="kota" value="{{ old('kota', $profil->kota) }}">
        @error('kota')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="fg">
        <label for="bio">Bio singkat</label>
        <textarea id="bio" name="bio" style="min-height:100px">{{ old('bio', $profil->bio) }}</textarea>
        @error('bio')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="formact"><button type="submit" class="btn">Simpan profil</button></div>
</form>
@endsection