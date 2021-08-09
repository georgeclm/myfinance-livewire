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
            'P2P' => auth()->user()->total_p2ps()
        ][$this->nama] ?? 0;
    }

    public function route()
    {
        return [
            'Stock' => 'stocks',
            'P2P' => 'p2ps'
        ][$this->nama] ?? 'stocks';
    }
}
