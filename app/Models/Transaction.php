<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'rekening_id', 'rekening_id2', 'utang_id', 'utangteman_id', 'category_id', 'category_masuk_id', 'jenisuang_id', 'jumlah', 'kategori', 'keterangan'];
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
        return $this->belongsTo(Rekening::class, 'rekening_id')->withDefault([
            'nama_akun' => 'Pocket Deleted'
        ]);
    }
    public function rekening_tujuan()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id2')->withDefault([
            'nama_akun' => 'Pocket Deleted'
        ]);
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
