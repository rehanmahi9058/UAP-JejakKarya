<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmpanBalik extends Model
{
    protected $table = 'umpan_balik';

    protected $fillable = [
        'entri_portofolio_id',
        'mentor_id',
        'isi_umpan_balik',
        'skor_relevansi',
    ];

    protected $casts = [
        'skor_relevansi' => 'integer',
    ];

    public function entriPortofolio()
    {
        return $this->belongsTo(EntriPortofolio::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}