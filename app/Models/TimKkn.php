<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimKkn extends Model
{
    use HasFactory;

    protected $table = 'tim_kkn';

    protected $fillable = ['proyek_kkn_id', 'mahasiswa_id'];

    public function proyek()
    {
        return $this->belongsTo(ProyekKkn::class, 'proyek_kkn_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}