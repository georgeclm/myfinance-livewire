<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;
    public function rekenings()
    {
        return $this->hasMany(Rekening::class);
    }
    public function user_rekenings()
    {
        return $this->hasMany(Rekening::class)->where('user_id', auth()->id());
    }
}
