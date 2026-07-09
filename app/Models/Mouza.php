<?php

namespace App\Models;

use App\Models\Kiwat;
use App\Models\RealEstateField;
use App\Models\RealEstateDocument;
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
        'area_acre',
        'area_kanal',
        'area_marla',
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

    public function documents()
    {
        return $this->morphMany(RealEstateDocument::class, 'model');
    }
    public function kiwats()
    {
        return $this->hasMany(Kiwat::class);
    }
    public function getAreaDisplayAttribute()
    {
        $parts = [];
        if ($this->area_acre > 0)  $parts[] = $this->area_acre . ' Acre';
        if ($this->area_kanal > 0) $parts[] = $this->area_kanal . ' Kanal';
        if ($this->area_marla > 0) $parts[] = $this->area_marla . ' Marla';

        return $parts ? implode(', ', $parts) : '-';
    }
}
