<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('here');
        $stocks = Stock::where('user_id', auth()->id())->where('lot', '!=', 0)->get();
        return view('investation.stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'kode' => 'required',
            'lot' => ['required', 'numeric'],
            'harga_beli' => ['required', 'numeric'],
            'biaya_lain' => ['nullable', 'numeric'],
            'rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')],
        ]);
        $stocks = Stock::where('user_id', auth()->id())->where('kode', request()->kode)->get();
        if ($stocks->isNotEmpty()) {
            return redirect()->back()->with('error', 'Kode sudah terdaftar silahkan tambah');
        }
        $total = request()->harga_beli * request()->lot * 100;
        $rekening = Rekening::findOrFail(request()->rekening_id);

        if ($total > $rekening->saldo_sekarang) {
            return back()->with('error', 'Balance Not Enough');
        }

        $rekening->saldo_sekarang -= $total;
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail(request()->financial_plan_id);
        $financialplan->jumlah += $total;
        $financialplan->save();
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $total,
            'rekening_id' => request()->rekening_id,
            'keterangan' => 'Beli Stock ' . request()->kode,
            'category_id' => Category::firstWhere('nama', 'Investasi')->id,
        ]);
        Stock::create([
            'user_id' => auth()->id(),
            'kode' => request()->kode,
            'lot' => request()->lot,
            'harga_beli' => request()->harga_beli,
            'biaya_lain' => request()->biaya_lain,
            'rekening_id' => request()->rekening_id,
            'financial_plan_id' => request()->financial_plan_id,
            'keterangan' => request()->keterangan,
            'total' => $total
        ]);

        return redirect()->back()->with('success', 'Stock Telah Tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'lot' => ['required', 'numeric'],
            'harga_beli' => ['required', 'numeric'],
            'rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ]);
        $rekening = Rekening::findOrFail(request()->rekening_id);
        $total = request()->harga_beli * request()->lot * 100;

        if ($total > $rekening->saldo_sekarang) {
            return back()->with('error', 'Balance Not Enough');
        }

        $rekening->saldo_sekarang -= $total;
        $rekening->save();
        $stock = Stock::findOrFail($id);

        $financialplan = FinancialPlan::findOrFail($stock->financial_plan_id);
        $financialplan->jumlah += $total;
        $financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $total,
            'rekening_id' => request()->rekening_id,
            'keterangan' => 'Beli Stock ' . $stock->kode,
            'category_id' => Category::firstWhere('nama', 'Investasi')->id,
        ]);

        $total_lot = request()->lot + $stock->lot;
        $avgprice = round(((request()->harga_beli * request()->lot) + ($stock->harga_beli * $stock->lot)) / $total_lot);
        $stock->update([
            'harga_beli' => $avgprice,
            'lot' => $total_lot,
            'keterangan' => request()->keterangan,
            'total' => $total + $stock->total
        ]);
        return redirect()->back()->with('success', 'Stock Telah di beli');
    }

    public function updateTujuan(Stock $stock)
    {
        request()->validate([
            'financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')]
        ]);

        $stock->financialplan->jumlah -= $stock->total;
        $stock->financialplan->save();

        $financialplan = FinancialPlan::findOrFail(request()->financial_plan_id);
        $financialplan->jumlah += $stock->total;
        $financialplan->save();

        $stock->update(['financial_plan_id' => request()->financial_plan_id]);
        return redirect()->back()->with('success', 'Tujuan Stock Telah Dipindah');
    }


    public function jual(Stock $stock)
    {
        request()->validate([
            'lot' => ['required', 'numeric'],
            'harga_jual' => ['required', 'numeric'],
            'rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')]
        ]);

        if (request()->lot > $stock->lot) {
            return redirect()->back()->with('error', 'Jumlah Lot Melebihi Limit');
        }

        $total_jual = request()->harga_jual * request()->lot * 100;

        $rekening = Rekening::findOrFail(request()->rekening_id);
        $rekening->saldo_sekarang += $total_jual;
        $rekening->save();

        $total_beli = $stock->harga_beli * request()->lot * 100;
        $stock->financialplan->jumlah -= $total_beli;
        $stock->financialplan->save();

        $stock->harga_jual = request()->harga_jual;
        $stock->lot -= request()->lot;
        $stock->total = $stock->lot * 100 * $stock->harga_beli;
        $stock->gain_or_loss += $total_jual - $total_beli;
        $stock->save();
        if ($stock->lot == 0) {
            $stock->delete();
        }
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 1,
            'jumlah' => $total_jual,
            'rekening_id' => request()->rekening_id,
            'keterangan' => 'Jual Stock ' . $stock->kode,
            'category_masuk_id' => CategoryMasuk::firstWhere('nama', 'Jual Investasi')->id,
        ]);
        return redirect()->back()->with('success', 'Stock Telah Terjual');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
