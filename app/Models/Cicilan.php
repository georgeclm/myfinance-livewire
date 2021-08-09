<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function jenisuang()
    {
        return $this->belongsTo(Jenisuang::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function category_masuk()
    {
        return $this->belongsTo(CategoryMasuk::class, 'category_masuk_id');
    }
    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }
    public function rekening_tujuan()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id2');
    }
    public function utang()
    {
        return $this->belongsTo(Utang::class);
    }
    public function utangteman()
    {
        return $this->belongsTo(Utangteman::class, 'utangteman_id');
    }
}
