<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Transaction;
use App\Models\Utang;
use App\Models\Utangteman;
use Illuminate\Http\Request;

class TransactionApiController extends Controller
{
    public function detail(Jenisuang $jenisuang)
    {
        if ($jenisuang->user_transactions(null, request()->daterange)->take(5)) {
            return response()->json([
                'success' => true,
                'message' => $jenisuang->nama,
                'transactions' => $jenisuang->user_transactions(null, request()->daterange)->take(5)
            ], 200);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function detailAll(Jenisuang $jenisuang)
    {
        if ($jenisuang->user_transactions(null, request()->daterange)) {
            $res = $jenisuang->user_transactions(null, request()->daterange);
            if (request()->has('search')) {
                $res = $res->where('category_id', request()->search);
            } else if (request()->has('search2')) {
                $res = $res->where('category_masuk_id', request()->search2);
            } else {
                $res =  $res;
            }
            $total = $res->sum('jumlah');
            return response()->json([
                'success' => true,
                'message' => $jenisuang->nama,
                'search' => request()->search,
                'total' => $total,
                'search2' => request()->search2,
                'transactions' => $res,
            ], 200);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function store(CreateTransactionRequest $request)
    {
        request()->request->add(['user_id' => auth()->id()]);
        $rekening1 = Rekening::findOrFail(request()->rekening_id);

        if (request()->jenisuang_id == 1) {
            $rekening1->saldo_sekarang += request()->jumlah;
            $rekening1->save();
        } else if (request()->jenisuang_id == 2) {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return response()->json(['success' => false, 'message' => 'Total more than current balance'], 500);
            }
            $rekening1->saldo_sekarang -= request()->jumlah;
            $rekening1->save();
        } else if (request()->jenisuang_id == 4) {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return response()->json(['success' => false, 'message' => 'Total more than current balance'], 500);
            }
            $utang = Utang::findOrFail(request()->utang_id);
            if ($utang->jumlah < request()->jumlah) {
                return response()->json(['success' => false, 'message' => 'Pay more than debt'], 500);
            }
            $utang->jumlah -= request()->jumlah;
            if ($utang->jumlah <= 0) {
                $utang->lunas = 1;
            }
            $utang->save();
            $rekening1->saldo_sekarang -= request()->jumlah;
            $rekening1->save();
        } else if (request()->jenisuang_id == 5) {

            $utang = Utangteman::findOrFail(request()->utangteman_id);
            if ($utang->jumlah < request()->jumlah) {
                return response()->json(['success' => false, 'message' => 'Pay more than debt'], 500);
            }
            $utang->jumlah -= request()->jumlah;
            if ($utang->jumlah <= 0) {
                $utang->lunas = 1;
            }
            $utang->save();
            $rekening1->saldo_sekarang += request()->jumlah;
            $rekening1->save();
        } else {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return response()->json(['success' => false, 'message' => 'Total more than current balance'], 500);
            }

            $rekening2 = Rekening::findOrFail(request()->rekening_id2);

            if ($rekening1 == $rekening2) {
                return response()->json(['success' => false, 'message' => 'Cant tranfer to the same pocket'], 500);
            }

            $rekening1->saldo_sekarang -= request()->jumlah;
            $rekening2->saldo_sekarang += request()->jumlah;
            $rekening1->save();
            $rekening2->save();
        }

        Transaction::create(request()->all());

        return response()->json([
            'success' => true,
            'message' => 'Transaction have been stored'
        ], 200);
    }
}
