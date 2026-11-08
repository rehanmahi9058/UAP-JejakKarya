<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilMentor extends Model
{
    protected $table = 'profil_mentor';

    protected $fillable = [
        'user_id',
        'bidang_karier_id',
        'jabatan',
        'pengalaman_kerja',
        'tahun_pengalaman',
        'topik_mentoring',
        'status_verifikasi',
        'catatan_verifikasi',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'tahun_pengalaman' => 'integer',
        'diverifikasi_pada' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidangKarier()
    {
        return $this->belongsTo(BidangKarier::class);
    }

    public function slotMentoring()
    {
        return $this->hasMany(SlotMentoring::class);
    }
}