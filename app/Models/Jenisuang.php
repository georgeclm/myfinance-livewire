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
    public function user_transactions($daterange = null)
    {
        $return = $this->hasMany(Transaction::class)->where('user_id', auth()->id());
        if ($daterange != null) {
            $date_range1 = explode(" / ", $daterange);
            $return = $return->where('created_at', '>=', $date_range1[0]);
            $return = $return->where('created_at', '<=', $date_range1[1]);
            return $return->latest()->get();
        }
        return $return->whereMonth('created_at', now()->month)->latest()->get();
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
}
