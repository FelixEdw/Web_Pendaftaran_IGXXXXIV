<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $table = 'tproduction';

    protected $fillable = [
        'idTeam',
        'idSession',
        'unit_diproduksi',
        'unit_defect',
        'inventory',
        'unit_terjual',
        'biaya_inventory',
        'maintenance_paid',
        'uang_didapatkan',
        'poin_didapatkan',
    ];
    public function team()
    {
        return $this->belongsTo(Team::class, 'idTeam');
    }
    public function session()
    {
        return $this->belongsTo(Session::class, 'idSession');
    }
}
