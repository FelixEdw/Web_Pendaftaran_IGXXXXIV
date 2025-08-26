<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityControl extends Model
{
    use HasFactory;

    protected $table = 'tqualitycontrol';

    protected $fillable = [
        'idTeam',
        'tipe_mesin',
        'level_qc',  
        'persentase_defect',
    ];
    public function team()
    {
        return $this->belongsTo(Team::class, 'idTeam');
    }
}
