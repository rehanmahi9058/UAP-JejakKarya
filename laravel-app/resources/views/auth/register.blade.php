<x-guest-layout>
    <h1>Buat akun JejakKarier</h1>
    <p class="sub">Daftar untuk membuat peta karier dan memesan sesi mentoring.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="fg">
            <label for="name">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="password">Kata sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            @error('password')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="password_confirmation">Ulangi kata sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')<div class="err">{{ $message }}</div>@enderror
        </div>
        <button class="btn block" type="submit">Daftar</button>
    </form>
    <p class="alt">Sudah punya akun? <a class="link" href="{{ route('login') }}">Masuk</a></p>
</x-guest-layout>