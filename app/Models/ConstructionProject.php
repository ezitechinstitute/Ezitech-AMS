<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstructionProject extends Model
{
    protected $fillable = [
        'name',
        'district',
        'tehsil',
        'latitude',
        'longitude',
        'intiqal_number',
        'intiqal_date',
        'total_area',
        'total_area_unit',
        'description',
        'created_by',
    ];

    public function fields()
    {
        return $this->hasMany(ConstructionField::class);
    }

    public function plots()
    {
        return $this->hasMany(ConstructionPlot::class);
    }
}
