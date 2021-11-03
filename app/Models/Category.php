<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'user_id'];
    public function userTransactionsByCategory()
    {
        return $this->hasMany(Transaction::class)->whereMonth('created_at', now()->month)->where('user_id', auth()->id())->where('jenisuang_id', 2);
    }
    public function bgColor()
    {
        return [
            '1' => 'bg-success',
            '2' => 'bg-warning',
            '3' => 'bg-info',
            '4' => 'bg-primary',
            '5' => 'bg-primary',
            '6' => 'bg-danger'
        ][$this->id] ?? 'bg-info';
    }
    public function icon()
    {
        return [
            '1' => 'fa-wheelchair',
            '2' => 'fa-receipt',
            '3' => 'fa-utensils',
            '4' => 'fa-credit-card',
            '5' => 'fa-car',
            '6' => 'fa-coffee'
        ][$this->id] ?? 'fa-random';
    }
    public function persen($prev = 0)
    {
        if (auth()->user()->uangkeluar->sum('jumlah') + $prev != 0) {
            return round($this->userTransactionsByCategory->sum('jumlah') / (auth()->user()->uangkeluar->sum('jumlah') + $prev) * 100);
        }
        return 0;
    }
}
