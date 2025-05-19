<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    protected $fillable = [
        'pasien_id', 'jenis_vaksin', 'tanggal', 'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
