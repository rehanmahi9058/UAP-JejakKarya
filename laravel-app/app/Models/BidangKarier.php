<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangKarier extends Model
{
    protected $table = 'bidang_karier';

      protected $fillable = [
       'nama',          // sebelumnya 'nama_bidang'
       'deskripsi',
   ];

    public function profilMentor()
    {
        return $this->hasMany(ProfilMentor::class, 'bidang_karier_id');
    }

    public function rencanaKarier()
    {
        return $this->hasMany(RencanaKarier::class, 'bidang_karier_id');
    }
}
