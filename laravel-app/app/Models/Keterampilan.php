<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterampilan extends Model
{
    protected $table = 'keterampilan';

    protected $fillable = [
        'nama_keterampilan',
        'deskripsi',
    ];

       public function users()
   {
       return $this->belongsToMany(
           User::class,
           'users_keterampilan',
           'keterampilan_id',
           'users_id'          // sebelumnya 'user_id'
       );
   }

    public function entriPortofolio()
    {
        return $this->belongsToMany(
            EntriPortofolio::class,
            'entri_keterampilan',
            'keterampilan_id',
            'entri_portofolio_id'
        );
    }
}