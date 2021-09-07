<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investation extends Model
{
    use HasFactory;

    public function gettotalAttribute()
    {
        return [
            'Stock' => auth()->user()->total_stocks(),

            'P2P' => auth()->user()->total_p2ps(),
            'Mutual Funds (Reksadana)' => auth()->user()->total_mutual_funds(),
            'Deposito' => auth()->user()->total_depositos()
        ][$this->nama] ?? 0;
    }

    public function route()
    {
        return [
            'Stock' => 'stocks',
            'P2P' => 'p2ps',
            'Mutual Funds (Reksadana)' => 'mutualfunds',
            'Deposito' => 'deposito'
        ][$this->nama] ?? 'stocks';
    }
}
