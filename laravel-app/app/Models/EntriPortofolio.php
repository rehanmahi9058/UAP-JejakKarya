<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntriPortofolio extends Model
{
    protected $table = 'entri_portofolio';

    protected $fillable = [
        'user_id',
        'judul_portofolio',
        'jenis',
        'deskripsi',
        'tautan_proyek',
        'gambar',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keterampilan()
    {
        return $this->belongsToMany(
            Keterampilan::class,
            'entri_keterampilan',
            'entri_portofolio_id',
            'keterampilan_id'
        );
    }
}