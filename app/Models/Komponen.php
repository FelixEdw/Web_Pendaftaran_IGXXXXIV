<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Komponen extends Model
{
    use HasFactory;

    protected $table = 'komponen';

    protected $fillable = [
        'wheel', 'brake_and_pedal', 'chain_and_gear',
        'city_frame', 'folding_frame', 'mountain_frame', 'unicycle_frame',
        'team_id'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
