<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kiwat extends Model
{
    protected $fillable = [
        'mouza_id',
        'kiwat_number',
        'description',
        'total_area',
        'total_area_unit',
        'created_by',
    ];

    public function mouza()
    {
        return $this->belongsTo(Mouza::class);
    }

    public function plots()
    {
        return $this->hasMany(Plot::class);
    }

    public function fields()
    {
        return $this->hasMany(RealEstateField::class);
    }

    public function availablePlots()
    {
        return $this->hasMany(Plot::class)->where('status', 'available');
    }

    public function soldPlots()
    {
        return $this->hasMany(Plot::class)->where('status', 'sold');
    }
}
