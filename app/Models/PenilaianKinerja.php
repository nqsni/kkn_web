<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKinerja extends Model
{
    use HasFactory;

    protected $table = 'penilaian_kinerja';

    protected $fillable = [
        'proyek_kkn_id', 'pelaksanaan', 'disiplin', 'kerjasama', 'penghayatan',
    ];

    public function proyek()
    {
        return $this->belongsTo(ProyekKkn::class, 'proyek_kkn_id');
    }

    // Helper: hitung nilai kinerja gabungan (skala 0-100)
    public function getNilaiKinerjaAttribute(): float
    {
        return ($this->pelaksanaan * 0.30)
            + ($this->disiplin * 0.15)
            + ($this->kerjasama * 0.15)
            + ($this->penghayatan * 0.10);
        // catatan: totalnya dibagi 0.70 kalau mau skala 0-100 penuh,
        // tergantung cara input nilai per kriteria (lihat catatan di bawah)
    }
}