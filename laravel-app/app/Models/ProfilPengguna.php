<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPengguna extends Model
{
    protected $table = 'profil_pengguna';

    protected $fillable = ['user_id', 'status_pengguna', 'bidang_minat', 'kota', 'bio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}