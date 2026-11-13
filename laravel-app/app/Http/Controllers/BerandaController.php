<?php

namespace App\Http\Controllers;

use App\Models\BidangKarier;
use App\Support\KatalogQuery;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        // Semua angka dihitung dari database (tidak ada angka karangan)
        $statistik = [
            'karya' => DB::table('entri_portofolio')->where('status', 'terbit')->count(),
            'mentor' => KatalogQuery::mentorLayak()->count(),
            'bidang' => BidangKarier::count(),
        ];

        $slotMinggu = DB::table('slot_mentoring')->where('status', 'tersedia')
            ->whereBetween('tanggal', [now()->toDateString(), now()->addDays(7)->toDateString()])->count();

        // 3 portofolio pilihan terbaru dari mentor yang memenuhi syarat katalog
        $pilihan = KatalogQuery::mentorLayak()->orderByDesc('terbit_terakhir')->limit(3)->get();
        [$entri, $skill] = KatalogQuery::lengkapi($pilihan->pluck('user_id'));

        return view('beranda', compact('statistik', 'slotMinggu', 'pilihan', 'entri', 'skill'));
    }
}
