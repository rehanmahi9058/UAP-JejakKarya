<x-guest-layout>
    <h1>Buat kata sandi baru</h1>
    <p class="sub">Pilih kata sandi baru untuk akunmu.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="fg">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="password">Kata sandi baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            @error('password')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="fg">
            <label for="password_confirmation">Ulangi kata sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')<div class="err">{{ $message }}</div>@enderror
        </div>
        <button class="btn block" type="submit">Simpan kata sandi</button>
    </form>
</x-guest-layout>