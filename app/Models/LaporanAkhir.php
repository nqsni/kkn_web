<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    use HasFactory;

    protected $table = 'laporan_akhir';

    protected $fillable = ['proyek_kkn_id', 'file_laporan', 'nilai', 'catatan_dosen'];

    public function proyek()
    {
        return $this->belongsTo(ProyekKkn::class, 'proyek_kkn_id');
    }
}