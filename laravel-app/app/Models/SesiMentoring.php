<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiMentoring extends Model
{
    protected $table = 'sesi_mentoring';

    protected $fillable = [
        'slot_mentoring_id',
        'user_id',
        'tujuan_sesi',
        'catatan',
        'status',
    ];

    public function slotMentoring()
    {
        return $this->belongsTo(SlotMentoring::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function umpanBalik()
    {
        return $this->hasMany(UmpanBalik::class);
    }
}