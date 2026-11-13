<x-auth-split judul="Masuk">
    <p class="text-xs font-bold tracking-widest text-[#5b3df5] uppercase">Selamat datang kembali</p>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight">Masuk ke akunmu</h1>
    <p class="mt-2 text-sm text-slate-500">Lanjutkan membangun JejakKarya profesionalmu.</p>

    @if (session('status'))
        <div class="mt-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6" x-data="{ peran: '{{ old('peran', 'pengguna') }}', lihat: false }">
        @csrf

        {{-- Tab peran. Peran asli tetap dibaca dari database; tab dipakai untuk mencocokkan --}}
        <input type="hidden" name="peran" :value="peran">
        <div class="grid grid-cols-2 gap-1 rounded-xl bg-slate-100 p-1 text-sm font-semibold">
            <button type="button" @click="peran='pengguna'" :class="peran==='pengguna' ? 'bg-white shadow text-slate-900' : 'text-slate-500'" class="rounded-lg py-2 transition">Pengguna</button>
            <button type="button" @click="peran='mentor'" :class="peran==='mentor' ? 'bg-white shadow text-slate-900' : 'text-slate-500'" class="rounded-lg py-2 transition">Mentor</button>
        </div>

        <div class="mt-5">
            <label for="email" class="block text-sm font-semibold">Alamat email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="nama@email.com"
                   class="mt-1.5 w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-[#5b3df5] focus:ring-[#5b3df5]">
            @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-semibold">Kata sandi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#5b3df5] hover:underline">Lupa kata sandi?</a>
                @endif
            </div>
            <div class="relative mt-1.5">
                <input id="password" name="password" :type="lihat ? 'text' : 'password'" required autocomplete="current-password"
                       placeholder="Minimal 8 karakter"
                       class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm focus:border-[#5b3df5] focus:ring-[#5b3df5]">
                <button type="button" @click="lihat = !lihat" class="absolute inset-y-0 right-3 text-xs font-semibold text-slate-400 hover:text-slate-600" x-text="lihat ? 'Sembunyi' : 'Lihat'"></button>
            </div>
            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <label class="mt-4 flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#5b3df5] focus:ring-[#5b3df5]"> Ingat saya
        </label>

        <button type="submit" class="mt-6 w-full rounded-xl bg-[#5b3df5] py-3 text-sm font-bold text-white shadow-lg shadow-indigo-300/60 transition hover:bg-[#4b2fe0]">
            Masuk &rarr;
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-[#5b3df5] hover:underline">Daftar gratis</a>
    </p>
</x-auth-split>
