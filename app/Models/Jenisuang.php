<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Psr\Log\NullLogger;

class Jenisuang extends Model
{
    use HasFactory;

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->where('user_id', auth()->id());
    }
    public function cicilans()
    {
        return $this->hasMany(Cicilan::class)->where('user_id', auth()->id());
    }
    public function user_transactions($q = null, $daterange = null)
    {
        $return = $this->hasMany(Transaction::class)->where('user_id', auth()->id());
        if ($daterange != null) {
            $date_range1 = explode(" / ", $daterange);
            $return = $return->where('created_at', '>=', $date_range1[0]);
            $return = $return->where('created_at', '<=', $date_range1[1]);
        } else {
            switch ($q) {
                case '0':
                    $return =  $return->whereMonth('created_at', now()->month);
                    break;
                case '1':
                    $return =  $return->whereMonth('created_at', now()->subMonth()->month);
                    break;
                default:
                    $return = $return;
                    break;
            }
        }

        return $return->orderBy('created_at', 'desc')->get();
    }

    public function all_transactions()
    {
        return $this->hasMany(Transaction::class)->where('user_id', auth()->id())->orderBy('created_at', 'desc');
    }

    public function color()
    {
        return [
            '1' => 'bg-success',
            '2' => 'bg-danger',
            '3' => 'bg-primary',
            '4' => 'bg-warning',
            '5' => 'bg-info'
        ][$this->id] ?? 'bg-danger';
    }
    public function textColor()
    {
        return [
            '1' => 'text-success',
            '2' => 'text-danger',
            '3' => 'text-primary',
            '4' => 'text-warning',
            '5' => 'text-info'
        ][$this->id] ?? 'text-danger';
    }

    public function categoryTotal($q)
    {
        if ($q == '0') {
            return $this->all_transactions->sum('jumlah');
        }
        return $this->all_transactions->where('category_id', $q)->sum('jumlah');
    }

    public function categoryMasukTotal($q)
    {
        if ($q == '0') {
            return $this->all_transactions->sum('jumlah');
        }
        return $this->all_transactions->where('category_masuk_id', $q)->sum('jumlah');
    }
}
