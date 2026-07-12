<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstructionField extends Model
{
    protected $fillable = [
        'construction_project_id',
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

    public function project()
    {
        return $this->belongsTo(ConstructionProject::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
