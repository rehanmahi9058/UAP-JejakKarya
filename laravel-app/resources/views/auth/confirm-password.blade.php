<x-guest-layout>
    <h1>Konfirmasi kata sandi</h1>
    <p class="sub">Ini area aman. Masukkan kata sandimu sebelum melanjutkan.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="fg">
            <label for="password">Kata sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')<div class="err">{{ $message }}</div>@enderror
        </div>
        <button class="btn block" type="submit">Konfirmasi</button>
    </form>
</x-guest-layout>