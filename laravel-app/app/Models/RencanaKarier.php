<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaKarier extends Model
{
    protected $table = 'rencana_karier';

    protected $fillable = ['user_id', 'tujuan', 'deskripsi', 'target_selesai', 'status'];

    protected function casts(): array
    {
        return ['target_selesai' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidangKarier()
    {
        return $this->belongsTo(BidangKarier::class, 'bidang_karier_id');
    }

    public function langkahKarier()
    {
        return $this->hasMany(LangkahKarier::class, 'rencana_karier_id');
    }

    public function progres(): int
    {
        $total = $this->langkah()->count();
        if ($total === 0) {
            return 0;
        }
        return (int) round($this->langkah()->where('selesai', true)->count() / $total * 100);
    }

    // Aturan bisnis: otomatis "tercapai" bila semua langkah selesai
    public function perbaruiStatus(): void
    {
        $total = $this->langkah()->count();
        $selesai = $this->langkah()->where('selesai', true)->count();
        $this->update(['status' => ($total > 0 && $total === $selesai) ? 'tercapai' : 'berjalan']);
    }
}