<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public function gettotalAttribute()
    {
        return $this->harga_beli * $this->lot * 100;
    }
    public function financialplan()
    {
        return $this->belongsTo(FinancialPlan::class, 'financial_plan_id');
    }
}
