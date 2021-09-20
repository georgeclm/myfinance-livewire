<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenis;
use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Transaction;
use Illuminate\Http\Request;

class RekeningApiController extends Controller
{

    public function store()
    {
        request()->request->add(['user_id' => auth()->id()]);
        request()->validate([
            'jenis_id' => ['required', 'in:' . Jenis::pluck('id')->implode(',')],
            'nama_akun' => 'required',
            'nama_bank' => 'nullable',
            'saldo_sekarang' => ['required', 'numeric'],
            'saldo_mengendap' => ['nullable', 'numeric'],
            'keterangan' => 'nullable',
            'user_id' => 'required'
        ]);
        // request need user_id
        $success = Rekening::create(request()->all());
        if ($success != null) {
            return response()->json(['success' => true, 'message' => 'Pocket have been created'], 200);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function update(Rekening $rekening)
    {
        $success = $rekening->update([
            'nama_akun' => request('nama_akun'),
            'nama_bank' => request('nama_bank'),
            'saldo_mengendap' => request('saldo_mengendap'),
            'keterangan' => request('keterangan'),
        ]);
        if ($success) {
            return response()->json(['success' => true, 'message' => 'Pocket have been updated'], 200);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function destroy(Rekening $rekening)
    {
        $success = $rekening->delete();
        if ($success) {
            return response()->json(['success' => true, 'message' => 'Pocket have been deleted'], 200);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function adjust(Rekening $rekening)
    {
        request()->validate([
            'saldo_sekarang' => ['required', 'numeric']
        ]);
        if (request()->saldo_sekarang == $rekening->saldo_sekarang) {
            return response()->json(['success' => false, 'message' => 'Same Amount'], 500);
        }
        $jumlah = abs($rekening->saldo_sekarang - request()->saldo_sekarang);
        $jenisuang_id = 0;
        $category_id = null;
        $category_masuk_id = null;

        if (request()->saldo_sekarang > $rekening->saldo_sekarang) {
            $jenisuang_id = 1;
            $category_masuk_id = CategoryMasuk::firstWhere('nama', 'Adjustment')->id;
        } else {
            $jenisuang_id = 2;
            $category_id = Category::firstWhere('nama', 'Adjustment')->id;
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => $jenisuang_id,
            'jumlah' => $jumlah,
            'rekening_id' => $rekening->id,
            'keterangan' => 'Adjustment',
            'category_id' => $category_id,
            'category_masuk_id' => $category_masuk_id
        ]);

        if ($rekening->update(request()->all())) {
            return response()->json(['success' => true, 'message' => 'Pocket have been adjusted'], 200);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
    public function detail(Jenisuang $jenisuang, Rekening $rekening)
    {
        if ($jenisuang->user_transactions(request()->q)->where('rekening_id', $rekening->id)) {
            return response()->json([
                'success' => true,
                'jenisuang' => $jenisuang->nama,
                'q' => request()->q,
                'transactions' => $jenisuang->user_transactions(request()->q)->where('rekening_id', $rekening->id)
            ], 200);
        }
        return response()->json(['success' => false, 'message' => 'ERROR'], 500);
    }
}
