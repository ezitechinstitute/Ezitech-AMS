<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $fillable = [
        'mouza_id',
        'kiwat_id',
        'field_number',
        'intiqal_no',
        'area_quantity',
        'area_unit',
        'area_acre',
        'area_kanal',
        'area_marla',
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

    public function mouza()
    {
        return $this->belongsTo(Mouza::class);
    }

    public function kiwat()
    {
        return $this->belongsTo(Kiwat::class);
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
    public function khasra()
    {
        return $this->belongsTo(RealEstateField::class, 'khasra_id');
    }
}
