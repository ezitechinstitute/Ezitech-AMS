<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealEstateDocument extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'document_name',
        'document_path',
        'document_type',
        'created_by',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
