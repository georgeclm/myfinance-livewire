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
    public function totalGainOrLossMonth($month = null)
    {
        $result = $this->where('user_id', auth()->id())->onlyTrashed();
        return $result->whereMonth('deleted_at', now()->subMonth($month)->month)->get();
    }
    public function currentPrice()
    {
        $queryString = http_build_query([
            'access_key' => '3fb12d1ba1ca20adc1d483f362ce81be'
        ]);
        $code = $this->kode;
        $ch = curl_init(sprintf('%s?%s', "http://api.marketstack.com/v1/tickers/$code.XIDX/eod/latest", $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        $apiResult = json_decode($json, true);
        if (!array_key_exists("close", $apiResult)) {
            return 0;
        }
        return $apiResult['close'];
    }
}
