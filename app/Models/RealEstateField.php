<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealEstateField extends Model
{
    protected $fillable = [
        'mouza_id',
        'field_number',
        'intiqal_no',
        'area_quantity',
        'area_unit',
        'amount',
        'status',
        'latitude',
        'longitude',
        'seller_name',
        'seller_cnic',
        'seller_phone',
        'seller_address',
        'seller_father_name',
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

    public function mouza()
    {
        return $this->belongsTo(Mouza::class, 'mouza_id');
    }

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
    public function kiwat()
    {
        return $this->belongsTo(Kiwat::class);
    }
    public function plots()
    {
        return $this->hasMany(Plot::class, 'khasra_id');
    }
}
