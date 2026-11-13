<x-auth-split judul="Daftar">
    <span class="inline-block rounded-md bg-indigo-50 px-2.5 py-1 text-[11px] font-bold tracking-widest text-[#5b3df5] uppercase">Mulai perjalananmu</span>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight">Buat akun JejakKarya</h1>
    <p class="mt-2 text-sm text-slate-500">Gratis, mudah, dan hanya butuh beberapa menit.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6" x-data="{ peran: '{{ old('peran', 'pengguna') }}', lihat: false }">
        @csrf

        <input type="hidden" name="peran" :value="peran">
        <div class="grid grid-cols-2 gap-1 rounded-xl bg-slate-100 p-1 text-sm font-semibold">
            <button type="button" @click="peran='pengguna'" :class="peran==='pengguna' ? 'bg-white shadow text-slate-900' : 'text-slate-500'" class="rounded-lg py-2 transition">Pengguna</button>
            <button type="button" @click="peran='mentor'" :class="peran==='mentor' ? 'bg-white shadow text-slate-900' : 'text-slate-500'" class="rounded-lg py-2 transition">Mentor</button>
        </div>
        @error('peran') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        <p x-show="peran==='mentor'" x-cloak class="mt-2 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-700">
            Akun mentor baru akan diverifikasi administrator sebelum portofoliomu tampil di katalog.
        </p>

        <div class="mt-5">
            <label for="name" class="block text-sm font-semibold">Nama lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" placeholder="Masukkan nama lengkap"
                   class="mt-1.5 w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-[#5b3df5] focus:ring-[#5b3df5]">
            @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="email" class="block text-sm font-semibold">Alamat email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com"
                   class="mt-1.5 w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-[#5b3df5] focus:ring-[#5b3df5]">
            @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="password" class="block text-sm font-semibold">Kata sandi</label>
            <div class="relative mt-1.5">
                <input id="password" name="password" :type="lihat ? 'text' : 'password'" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                       class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm focus:border-[#5b3df5] focus:ring-[#5b3df5]">
                <button type="button" @click="lihat = !lihat" class="absolute inset-y-0 right-3 text-xs font-semibold text-slate-400 hover:text-slate-600" x-text="lihat ? 'Sembunyi' : 'Lihat'"></button>
            </div>
            @error('password') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-semibold">Konfirmasi kata sandi</label>
            <input id="password_confirmation" name="password_confirmation" :type="lihat ? 'text' : 'password'" required autocomplete="new-password" placeholder="Ulangi kata sandi"
                   class="mt-1.5 w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-[#5b3df5] focus:ring-[#5b3df5]">
        </div>

        <label class="mt-4 flex items-start gap-2 text-xs text-slate-600">
            <input type="checkbox" name="setuju" value="1" {{ old('setuju') ? 'checked' : '' }} class="mt-0.5 rounded border-slate-300 text-[#5b3df5] focus:ring-[#5b3df5]">
            <span>Saya menyetujui Syarat Penggunaan dan Kebijakan Privasi JejakKarya.</span>
        </label>
        @error('setuju') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror

        <button type="submit" class="mt-6 w-full rounded-xl bg-[#5b3df5] py-3 text-sm font-bold text-white shadow-lg shadow-indigo-300/60 transition hover:bg-[#4b2fe0]">
            Buat akun &rarr;
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-[#5b3df5] hover:underline">Masuk</a>
    </p>
</x-auth-split>
