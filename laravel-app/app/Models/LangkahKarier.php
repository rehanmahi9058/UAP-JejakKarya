<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LangkahKarier extends Model
{
    protected $table = 'langkah_karier';

    protected $fillable = ['rencana_karier_id', 'judul', 'target_tanggal', 'selesai'];

    protected function casts(): array
    {
        return ['target_tanggal' => 'date', 'selesai' => 'boolean'];
    }

    public function rencanaKarier()
    {
        return $this->belongsTo(RencanaKarier::class, 'rencana_karier_id');
    }

    public function rencana()
{
    return $this->rencanaKarier();
}
}