<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianLpk extends Model
{
    use HasFactory;

    protected $table = 'penilaian_lpk';

    protected $fillable = ['proyek_kkn_id', 'nilai'];

    public function proyek()
    {
        return $this->belongsTo(ProyekKkn::class, 'proyek_kkn_id');
    }
}