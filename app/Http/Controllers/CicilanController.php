<?php

namespace App\Http\Controllers;

use App\Models\Cicilan;
use App\Models\NotifCicilan;
use App\Models\Rekening;
use App\Models\Transaction;
use App\Models\Utang;
use App\Models\Utangteman;
use Illuminate\Http\Request;

class CicilanController extends Controller
{

    public function checkCicilanDaily()
    {
        $tanggal = now()->format('j');
        $cicilans = Cicilan::where('tanggal', $tanggal)->get();
        // dd($cicilans);
        foreach ($cicilans as $cicilan) {
            if ($cicilan->sekarang < $cicilan->bulan) {
                $cicilan->sekarang++;
                $cicilan->save();
                $rekening1 = Rekening::findOrFail($cicilan->rekening_id);

                if ($cicilan->jenisuang_id == 1) {
                    $rekening1->saldo_sekarang += $cicilan->jumlah;
                    $rekening1->save();
                } else if ($cicilan->jenisuang_id == 2) {
                    $rekening1->saldo_sekarang -= $cicilan->jumlah;
                    $rekening1->save();
                } else if ($cicilan->jenisuang_id == 4) {
                    $utang = Utang::findOrFail($cicilan->utang_id);
                    $utang->jumlah -= $cicilan->jumlah;
                    if ($utang->jumlah <= 0) {
                        $utang->lunas = 1;
                    }
                    $utang->save();
                    $rekening1->saldo_sekarang -= $cicilan->jumlah;
                    $rekening1->save();
                } else if ($cicilan->jenisuang_id == 5) {
                    $utang = Utangteman::findOrFail($cicilan->utangteman_id);
                    $utang->jumlah -= $cicilan->jumlah;
                    if ($utang->jumlah  <= 0) {
                        $utang->lunas = 1;
                    }
                    $utang->save();
                    $rekening1->saldo_sekarang += $cicilan->jumlah;
                    $rekening1->save();
                } else {
                    $rekening2 = Rekening::findOrFail($cicilan->rekening_id2);
                    $rekening1->saldo_sekarang -= $cicilan->jumlah;
                    $rekening2->saldo_sekarang += $cicilan->jumlah;
                    $rekening1->save();
                    $rekening2->save();
                }

                Transaction::create([
                    'user_id' => $cicilan->user_id,
                    'jenisuang_id' => $cicilan->jenisuang_id,
                    'jumlah' => $cicilan->jumlah,
                    'rekening_id' => $cicilan->rekening_id,
                    'rekening_id2' => $cicilan->rekening_id2,
                    'keterangan' => $cicilan->keterangan,
                    'utang_id' => $cicilan->utang_id,
                    'utangteman_id' => $cicilan->utangteman_id,
                    'category_id' => $cicilan->category_id,
                    'category_masuk_id' => $cicilan->category_masuk_id,
                ]);
                NotifCicilan::create([
                    'user_id' => $cicilan->user_id,
                    'notification' => 'Repetition ' . $cicilan->nama . ' with total Rp. ' . number_format($cicilan->jumlah, 0, ',', '.'),
                    'check' => 0
                ]);
            }
        }
    }
}
