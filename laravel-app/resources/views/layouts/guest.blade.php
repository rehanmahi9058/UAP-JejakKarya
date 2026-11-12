{{-- Layout halaman tamu (login, daftar, lupa sandi). Tanpa Vite, memakai CSS yang sama dengan seluruh aplikasi. --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JejakKarier</title>
    @include('partials.gaya')
    <style>
        .auth{min-height:100vh;display:grid;place-items:center;padding:24px;background:linear-gradient(180deg,#e9e4ff,var(--bg))}
        .auth-box{width:100%;max-width:440px}.auth .brand{justify-content:center;margin-bottom:20px}
        .auth .card{padding:30px}.auth h1{font-size:24px;font-weight:800;letter-spacing:-.02em}.auth .sub{color:var(--mu);margin:6px 0 22px}
        .auth .fg input[type=email],.auth .fg input[type=password]{width:100%;font:inherit;border:1px solid var(--bd);border-radius:12px;padding:10px 14px;background:#fff}
        .auth .btn.block{width:100%;padding:12px 18px;margin-top:6px}
        .auth .rowx{display:flex;justify-content:space-between;align-items:center;gap:12px;margin:-4px 0 14px;font-size:13px}
        .auth .rowx label{display:flex;gap:8px;align-items:center;cursor:pointer;color:var(--mu)}
        .auth .alt{text-align:center;color:var(--mu);margin-top:18px}.auth .link{color:var(--p);font-weight:700}
        .auth button.txt{all:unset;cursor:pointer;color:var(--p);font-weight:700;font-size:13px}
    </style>
</head>
<body>
<div class="auth">
    <div class="auth-box">
        <a href="{{ url('/') }}" class="brand"><i>▣</i><span>Jejak<b>Karier</b></span></a>
        <div class="card">
            {{ $slot }}
        </div>
    </div>
</div>
</body>
</html>