<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionRally1 extends Model
{
    protected $table = 'production_rally1';
    public $timestamps = false;

    protected $fillable = [
        'team_id',
        'total_komponen_diperoleh',
        'total_komponen_terpakai',
        'output_aktual',
        'revenue',
        'production_efficiency',
        'time_productivity',
        'performance',
        'poin_total'
    ];


    private const OUTPUT_TARGET = 120;


    public function hitungPoinDanEfisiensi()
    {
        // Production Efficiency
        $this->production_efficiency = $this->total_komponen_diperoleh > 0
            ? ($this->total_komponen_terpakai / $this->total_komponen_diperoleh) * 100
            : 0;

        // Time Productivity (target = 120)
        $this->time_productivity = self::OUTPUT_TARGET > 0
            ? ($this->output_aktual / self::OUTPUT_TARGET) * 100
            : 0;

        // Performance 
        $this->performance = (0.6 * $this->production_efficiency) + (0.4 * $this->time_productivity);

        // Total poin akhir
        $poin_revenue = ($this->revenue / 5);
        $this->poin_total = ($poin_revenue * 0.7) + ($this->performance * 0.3);

        // Simpan perubahan
        $this->save();
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
