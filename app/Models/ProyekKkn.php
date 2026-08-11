<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekKkn extends Model
{
    use HasFactory;

    protected $table = 'proyek_kkn';

    protected $fillable = [
        'periode_id', 'pengaju_type', 'mahasiswa_id', 'dosen_id',
        'judul', 'deskripsi', 'lokasi', 'kuota_tim', 'status', 'catatan_validasi',
    ];

    public function periode()
    {
        return $this->belongsTo(PeriodeKkn::class, 'periode_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function timKkn()
    {
        return $this->hasMany(TimKkn::class);
    }

    public function proposal()
    {
        return $this->hasOne(ProposalKkn::class);
    }

    public function logbook()
    {
        return $this->hasMany(LogbookMingguan::class);
    }

    public function laporanAkhir()
    {
        return $this->hasOne(LaporanAkhir::class);
    }

    public function penilaianLrk()
    {
        return $this->hasOne(PenilaianLrk::class);
    }

    public function penilaianKinerja()
    {
        return $this->hasOne(PenilaianKinerja::class);
    }

    public function penilaianLpk()
    {
        return $this->hasOne(PenilaianLpk::class);
    }

    public function nilaiAkhir()
    {
        return $this->hasOne(NilaiAkhir::class);
    }

    public function getJumlahAnggotaAttribute(): int
    {
        return $this->timKkn()->count();
    }

    public function getSisaSlotAttribute(): int
    {
        return max(0, $this->kuota_tim - $this->jumlah_anggota);
    }

    public function getBisaDirebutAttribute(): bool
    {
        return $this->status === 'tersedia' && $this->sisa_slot > 0;
    }
}