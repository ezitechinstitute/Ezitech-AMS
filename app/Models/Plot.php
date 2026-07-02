<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $fillable = [
        'field_number',
        'intiqal_no',
        'area_quantity',
        'area_unit',
        'amount',
        'status',
        'latitude',
        'longitude',
        'purchaser_name',
        'purchaser_cnic',
        'purchaser_phone',
        'purchaser_address',
        'purchaser_father_name',
        'agent_name',
        'agent_cnic',
        'agent_phone',
        'agent_address',
        'agent_commission',
        'patwari_total',
        'bank_account_id',
        'notes',
        'created_by',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function patwariExpenses()
    {
        return $this->morphMany(PatwariExpense::class, 'model');
    }

    public function documents()
    {
        return $this->morphMany(RealEstateDocument::class, 'model');
    }
}
