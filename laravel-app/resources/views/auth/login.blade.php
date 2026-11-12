<x-guest-layout>
    <h1>Masuk ke JejakKarier</h1>
    <p class="sub">Lanjutkan perjalanan kariermu atau kelola sesi mentoringmu.</p>

    @if (session('status'))<div class="flash ok">{{ session('status') }}</div>@endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="fg">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="password">Kata sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="rowx">
            <label><input type="checkbox" name="remember"> Ingat saya</label>
            @if (Route::has('password.request'))<a class="link" href="{{ route('password.request') }}">Lupa kata sandi?</a>@endif
        </div>
        <button class="btn block" type="submit">Masuk</button>
    </form>
    <p class="alt">Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar</a></p>
</x-guest-layout>