<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotMentoring extends Model
{
    protected $table = 'slot_mentoring';

    protected $fillable = [
        'profil_mentor_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tautan_pertemuan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function profilMentor()
    {
        return $this->belongsTo(ProfilMentor::class);
    }
    public function sesiMentoring()
    {
        return $this->hasMany(SesiMentoring::class, 'slot_mentoring_id');
    }
}