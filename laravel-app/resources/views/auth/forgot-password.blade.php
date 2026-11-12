<x-guest-layout>
    <h1>Lupa kata sandi?</h1>
    <p class="sub">Masukkan email akunmu dan kami kirimkan tautan untuk membuat kata sandi baru.</p>

    @if (session('status'))<div class="flash ok">{{ session('status') }}</div>@endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="fg">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="err">{{ $message }}</div>@enderror
        </div>
        <button class="btn block" type="submit">Kirim tautan reset</button>
    </form>
    <p class="alt"><a class="link" href="{{ route('login') }}">← Kembali ke halaman masuk</a></p>
</x-guest-layout>