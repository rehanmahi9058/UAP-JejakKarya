{{-- Layout halaman masuk dan daftar: kiri formulir, kanan panel ungu dengan maskot --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $judul ?? 'JejakKarya' }} - JejakKarya</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none}body{font-family:'Plus Jakarta Sans',ui-sans-serif,system-ui,sans-serif}</style>
</head>
<body class="antialiased text-slate-900 bg-white">
<div class="min-h-screen grid lg:grid-cols-2">

    {{-- Kolom kiri: formulir --}}
    <div class="flex flex-col px-6 sm:px-12 lg:px-20 py-8">
        <a href="/" class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-[#6d4cff] to-[#4b2fe0] shadow-lg shadow-indigo-300/50">
                <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 13h18"/></svg>
            </span>
            <span class="text-lg font-extrabold tracking-tight">Jejak<span class="text-[#5b3df5]">Karya</span></span>
        </a>

        <div class="flex-1 flex items-center">
            <div class="w-full max-w-sm mx-auto py-10">
                {{ $slot }}
            </div>
        </div>

        <p class="text-center text-xs text-slate-400">&copy; {{ date('Y') }} JejakKarya. Hak cipta dilindungi.</p>
    </div>

    {{-- Kolom kanan: panel ungu dan maskot --}}
    <div class="hidden lg:flex flex-col justify-between bg-gradient-to-b from-[#5b3df5] to-[#1b1050] text-white px-14 py-14">
        <div>
            <p class="text-3xl xl:text-4xl font-extrabold leading-tight">“Kita tidak harus melihat seluruh tangga. Cukup ambil langkah pertama.”</p>
            <div class="mt-8 border-t border-white/20 pt-6 text-sm text-white/80">
                Belajar dari mentor yang sudah berpengalaman, lewat portofolio nyata mereka.
            </div>
        </div>
        <img src="{{ asset('img/maskot-sapa.png') }}" alt="Maskot JejakKarya" class="mx-auto w-72 xl:w-80 drop-shadow-2xl">
        <div class="border-t border-white/20 pt-4 text-xs text-white/60">SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi</div>
    </div>
</div>
</body>
</html>
