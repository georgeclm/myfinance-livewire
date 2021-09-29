<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Deposito extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'jatuh_tempo',
    ];
    protected $casts = [
        'jatuh_tempo' => 'datetime',
    ];
    public function financialplan()
    {
        return $this->belongsTo(FinancialPlan::class, 'financial_plan_id');
    }
    public function totalGainOrLoss($daterange = null)
    {
        $result = $this->where('user_id', auth()->id())->onlyTrashed();
        if ($daterange != null) {
            $date_range1 = explode(" / ", $daterange);
            $result = $result->where('deleted_at', '>=', $date_range1[0]);
            $result = $result->where('deleted_at', '<=', $date_range1[1]);
            return $result->get();
        }
        return $result->whereMonth('deleted_at', now()->month)->get();
    }
}
