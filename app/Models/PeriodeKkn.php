<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeKkn extends Model
{
    use HasFactory;

    protected $table = 'periode_kkn';

    protected $fillable = ['nama', 'tanggal_mulai', 'tanggal_selesai', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'periode_user', 'periode_id', 'user_id')
            ->withPivot('role_saat_itu')
            ->withTimestamps();
    }

    public function proyekKkn()
    {
        return $this->hasMany(ProyekKkn::class, 'periode_id');
    }

    public function mahasiswaList()
    {
        return $this->users()->role('mahasiswa');
    }

    public function getTotalKuotaAttribute(): int
    {
        return $this->proyekKkn()
            ->whereIn('status', ['menunggu_rilis', 'tersedia', 'penuh'])
            ->sum('kuota_tim');
    }

    public function getSelisihKuotaAttribute(): int
    {
        return $this->mahasiswaList()->count() - $this->total_kuota;
    }
}