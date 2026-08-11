<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function proyekSebagaiMahasiswa()
    {
        return $this->hasMany(ProyekKkn::class, 'mahasiswa_id');
    }

    public function proyekSebagaiDosen()
    {
        return $this->hasMany(ProyekKkn::class, 'dosen_id');
    }

    public function timKkn()
    {
        return $this->hasMany(TimKkn::class, 'mahasiswa_id');
    }

    // Proyek aktif yang mahasiswa ini ikuti (baik sbg pengaju maupun anggota)
    public function getProyekAktifAttribute()
    {
        return $this->timKkn()
            ->whereHas('proyek', function ($q) {
                $q->whereIn('status', ['diajukan', 'lolos', 'penuh']);
            })
            ->with('proyek')
            ->first()?->proyek;
    }

    public function periodeList()
    {
        return $this->belongsToMany(PeriodeKkn::class, 'periode_user', 'user_id', 'periode_id')
            ->withPivot('role_saat_itu')
            ->withTimestamps();
    }
}