<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalKkn extends Model
{
    use HasFactory;

    protected $table = 'proposal_kkn';

    protected $fillable = ['proyek_kkn_id', 'file_proposal', 'status', 'catatan_dosen'];

    public function proyek()
    {
        return $this->belongsTo(ProyekKkn::class, 'proyek_kkn_id');
    }
}