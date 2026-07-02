<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatwariExpense extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'person_name',
        'amount',
        'note',
        'created_by',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
