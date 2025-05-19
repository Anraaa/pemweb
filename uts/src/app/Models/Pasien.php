<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasiens'; // karena Laravel default-nya 'pasiens'

    protected $fillable = [
        'nik', 'nama', 'tanggal_lahir', 'jenis_kelamin',
        'alamat', 'nama_ortu', 'foto', 'petugas_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class);
    }
}
