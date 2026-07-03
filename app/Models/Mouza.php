<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mouza extends Model
{
    protected $fillable = [
        'name',
        'district',
        'tehsil',
        'latitude',
        'longitude',
        'description',
        'intiqal_number',
        'intiqal_date',
        'total_area',
        'total_area_unit',
        'created_by',
    ];

    public function fields()
    {
        return $this->hasMany(RealEstateField::class, 'mouza_id');
    }

    public function availableFields()
    {
        return $this->hasMany(RealEstateField::class, 'mouza_id')->where('status', 'available');
    }

    public function soldFields()
    {
        return $this->hasMany(RealEstateField::class, 'mouza_id')->where('status', 'sold');
    }
}
