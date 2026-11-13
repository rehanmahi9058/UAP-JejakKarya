@php $rt = fn ($n) => \Illuminate\Support\Facades\Route::has($n) ? route($n) : '#'; @endphp
<footer class="foot"><div class="wrap">
    <div class="g">
        <div class="about">
            <a href="{{ url('/') }}" class="brand"><i>▣</i><span>Jejak<b>Karier</b></span></a>
            <p>Ekosistem karier masa depan untuk talenta muda, pekerja lepas kreatif, dan pelajar di pasar berkembang. Bangun JejakKarier pencapaian terverifikasi.</p>
            <span class="sdg">✓ Komitmen SDG 8: Pekerjaan Layak &amp; Pertumbuhan Ekonomi</span>
        </div>
        <div><h4>Eksplorasi</h4><ul>
            <li><a href="{{ $rt('katalog.index') }}">Katalog Portofolio</a></li>
            <li><a href="{{ $rt('sesi.index') }}">Jadwal Sesi Mentor</a></li>
            <li><a href="{{ $rt('peta-karier.index') }}">Peta Jalur Profesi</a></li>
            <li><a href="#">Uji Kompetensi Terbuka</a></li></ul></div>
        <div><h4>Komunitas</h4><ul>
            <li><a href="{{ $rt('register') }}">Menjadi Mentor</a></li>
            <li><a href="#">Program Kampus Mitra</a></li>
            <li><a href="#">Grup Diskusi Talenta</a></li>
            <li><a href="#">Cerita Sukses Alumni</a></li></ul></div>
        <div><h4>Legal &amp; Bantuan</h4><ul>
            <li><a href="#">Pusat Dukungan</a></li>
            <li><a href="#">Pedoman Komunitas</a></li>
            <li><a href="#">Kebijakan Privasi</a></li>
            <li><a href="#">Syarat Layanan</a></li></ul></div>
    </div>
    <div class="cp"><span>© {{ date('Y') }} JejakKarier. Hak Cipta Dilindungi Undang-Undang.</span><span>Mendorong Pemerataan Peluang Karier Digital</span></div>
</div></footer>
