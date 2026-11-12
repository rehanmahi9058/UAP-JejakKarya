<x-guest-layout>
    <h1>Verifikasi email</h1>
    <p class="sub">Terima kasih sudah mendaftar! Klik tautan yang kami kirim ke emailmu. Belum menerima? Kami bisa mengirim ulang.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="flash ok">Tautan verifikasi baru sudah dikirim ke emailmu.</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn block" type="submit">Kirim ulang email verifikasi</button>
    </form>
    <form method="POST" action="{{ route('logout') }}" class="alt">
        @csrf
        <button type="submit" class="txt">Keluar</button>
    </form>
</x-guest-layout>