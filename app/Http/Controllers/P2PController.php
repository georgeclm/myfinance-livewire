<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\FinancialPlan;
use App\Models\P2P;
use App\Models\Rekening;
use App\Models\Transaction;
use Illuminate\Http\Request;

class P2PController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('investation.p2p.index');
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
            'user_id' => 'required',
            'nama_p2p' => 'required',
            'jumlah' => ['required', 'numeric'],
            'harga_jual' => ['required', 'numeric'],
            'rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')],
            'keterangan' => 'nullable',
            'jatuh_tempo' => 'required'
        ]);

        if (request()->jumlah > request()->harga_jual) {
            return redirect()->back()->with('error', 'Return Amount Less than First Amount');
        }

        $bunga = (request()->harga_jual * 100 / request()->jumlah) - 100;
        $rekening = Rekening::findOrFail(request()->rekening_id);

        if (request()->jumlah > $rekening->saldo_sekarang) {
            return back()->with('error', 'Balance Not Enough');
        }

        $rekening->saldo_sekarang -= request()->jumlah;
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail(request()->financial_plan_id);
        $financialplan->jumlah += request()->jumlah;
        $financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => request()->jumlah,
            'rekening_id' => request()->rekening_id,
            'keterangan' => 'Beli P2P ' . request()->nama_p2p,
            'category_id' => Category::firstWhere('nama', 'Investasi')->id,
        ]);

        P2P::create([
            'user_id' => auth()->id(),
            'nama_p2p' => request()->nama_p2p,
            'bunga' => $bunga,
            'jumlah' => request()->jumlah,
            'harga_jual' => request()->harga_jual,
            'rekening_id' => request()->rekening_id,
            'financial_plan_id' => request()->financial_plan_id,
            'keterangan' => request()->keterangan,
            'jatuh_tempo' => request()->jatuh_tempo,
            'gain_or_loss' => request()->harga_jual - request()->jumlah,
        ]);

        return redirect()->back()->with('success', 'P2P Telah Tersimpan');
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
        //
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

    public function updateTujuan(P2P $p2p)
    {
        request()->validate([
            'financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')]
        ]);

        $p2p->financialplan->jumlah -= $p2p->jumlah;
        $p2p->financialplan->save();

        $financialplan = FinancialPlan::findOrFail(request()->financial_plan_id);
        $financialplan->jumlah += $p2p->jumlah;
        $financialplan->save();

        $p2p->update(['financial_plan_id' => request()->financial_plan_id]);
        return redirect()->back()->with('success', 'P2P Goal have been changed');
    }

    public function sell(P2P $p2p)
    {
        request()->validate([
            'harga_jual' => ['required', 'numeric'],
            'rekening_jual_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')]
        ]);

        $rekening = Rekening::findOrFail(request()->rekening_jual_id);
        $rekening->saldo_sekarang += request()->harga_jual;
        $rekening->save();

        $p2p->financialplan->jumlah -= request()->jumlah;
        $p2p->financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 1,
            'jumlah' => request()->harga_jual,
            'rekening_id' => request()->rekening_jual_id,
            'keterangan' => 'Sell P2P ' . $p2p->nama_p2p,
            'category_masuk_id' => CategoryMasuk::firstWhere('nama', 'Sell Investment')->id,
        ]);
        $p2p->delete();

        return redirect()->back()->with('success', 'P2P Has Been Sold');
    }
}
