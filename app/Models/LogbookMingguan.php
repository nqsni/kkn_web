<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookMingguan extends Model
{
    use HasFactory;

    protected $table = 'logbook_mingguan';

    protected $fillable = [
        'proyek_kkn_id', 'mahasiswa_id', 'minggu_ke', 'file_logbook', 'deskripsi_kegiatan', 'nilai', 'catatan_dosen',
    ];

    public function proyek()
    {
        return $this->belongsTo(ProyekKkn::class, 'proyek_kkn_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}