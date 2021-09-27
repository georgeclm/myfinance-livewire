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
            'Stock' => auth()->user()->total_stocks->sum('total'),

            'P2P' => auth()->user()->total_p2ps(),
            'Mutual Funds (Reksadana)' => auth()->user()->total_mutual_funds->sum('total'),
            'Deposito' => auth()->user()->total_depositos()
        ][$this->nama] ?? 0;
    }

    public function route()
    {
        return [
            'Stock' => 'stock',
            'P2P' => 'p2p',
            'Mutual Funds (Reksadana)' => 'mutualfund',
            'Deposito' => 'deposito'
        ][$this->nama] ?? 'stock';
    }
}
