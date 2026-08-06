<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAkhir extends Model
{
    use HasFactory;

    protected $table = 'nilai_akhir';

    protected $fillable = [
        'proyek_kkn_id', 'nilai_lrk', 'nilai_kinerja', 'nilai_lpk', 'nilai_akhir', 'nilai_mutu',
    ];

    public function proyek()
    {
        return $this->belongsTo(ProyekKkn::class, 'proyek_kkn_id');
    }
}