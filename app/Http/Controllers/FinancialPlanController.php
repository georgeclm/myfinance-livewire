<?php

namespace App\Http\Controllers;

use App\Models\FinancialPlan;
use Illuminate\Http\Request;

class FinancialPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('financialplan.index');
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
        //
    }

    public function storeDanaDarurat(Request $request)
    {
        request()->validate([
            'jumlah' => ['required', 'numeric'],
            'status' => ['required', 'numeric', 'in:1,2,3']
        ]);

        $multiply =  [
            1 =>  6,
            2 =>  9,
        ][request()->status] ??  12;

        request()->jumlah *= $multiply;
        FinancialPlan::create([
            'user_id' => auth()->id(),
            'nama' => 'Emergency Fund',
            'produk' => 'Emergency Fund',
            'target' => request()->jumlah,
            'jumlah' => 0,
            'status_pernikahan' => request()->status,
            'perbulan' => request()->jumlah / $multiply
        ]);

        return redirect()->back()->with('success', 'Financial Plan Telah Terbuat');
    }

    public function updateDanaDarurat(FinancialPlan $financialplan)
    {
        request()->validate([
            'jumlah' => ['required', 'numeric'],
            'status' => ['required', 'numeric', 'in:1,2,3']
        ]);

        $multiply =  [
            1 =>  6,
            2 =>  9,
        ][request()->status] ??  12;

        request()->jumlah *= $multiply;
        $financialplan->update([
            'target' => request()->jumlah,
            'status_pernikahan' => request()->status,
            'perbulan' => request()->jumlah / $multiply
        ]);

        return redirect()->back()->with('success', 'Financial Plan Telah Disesuaikan');
    }

    public function storeDanaMembeliBarang(Request $request)
    {
        request()->validate([
            'nama' => 'required',
            'target' => ['required', 'numeric'],
            'bulan' => ['required', 'numeric', 'between:1,99'],
            'jumlah' => ['required', 'numeric']
        ]);
        $target = request()->target - request()->jumlah;
        $perbulan = $target / request()->bulan;

        FinancialPlan::create([
            'user_id' => auth()->id(),
            'nama' => request()->nama,
            'produk' => 'Fund For Stuff',
            'target' => $target,
            'jumlah' => 0,
            'perbulan' => $perbulan,
            'bulan' => request()->bulan,
            'dana_awal' => request()->jumlah
        ]);
        return redirect()->back()->with('success', 'Financial Plan Telah Terbuat');
    }
    public function updateDanaMembeliBarang(FinancialPlan $financialplan)
    {
        request()->validate([
            'nama' => 'required',
            'target' => ['required', 'numeric'],
            'bulan' => ['required', 'numeric', 'between:1,99'],
            'jumlah' => ['required', 'numeric']
        ]);
        $target = request()->target - request()->jumlah;
        $perbulan = $target / request()->bulan;

        $financialplan->update([
            'nama' => request()->nama,
            'target' => $target,
            'perbulan' => $perbulan,
            'bulan' => request()->bulan,
            'dana_awal' => request()->jumlah
        ]);
        return redirect()->back()->with('success', 'Financial Plan Telah Diubah');
    }
    public function storeDanaMenabung(Request $request)
    {
        request()->validate([
            'target' => ['required', 'numeric'],
            'jumlah' => ['required', 'numeric'],
            'bulan' => ['required', 'numeric', 'between:1,99']
        ]);

        $target = request()->target + (request()->jumlah * request()->bulan);
        FinancialPlan::create([
            'user_id' => auth()->id(),
            'nama' => 'Menabung Rutin',
            'produk' => 'Regular Savings Fund',
            'target' => $target,
            'jumlah' => 0,
            'perbulan' => request()->jumlah,
            'bulan' => request()->bulan,
            'dana_awal' => request()->target
        ]);
        return redirect()->back()->with('success', 'Financial Plan Telah Terbuat');
    }
    public function updateDanaMenabung(FinancialPlan $financialplan)
    {
        request()->validate([
            'target' => ['required', 'numeric'],
            'jumlah' => ['required', 'numeric'],
            'bulan' => ['required', 'numeric', 'between:1,99']
        ]);

        $target = request()->target + (request()->jumlah * request()->bulan);
        $financialplan->update([
            'target' => $target,
            'perbulan' => request()->jumlah,
            'bulan' => request()->bulan,
            'dana_awal' => request()->target
        ]);
        return redirect()->back()->with('success', 'Financial Plan Telah Diubah');
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
    public function destroy(FinancialPlan $financialplan)
    {
        $financialplan->delete();
        return redirect()->back()
            ->with('success', 'Financial Plan has been deleted successfully. ');
    }
}
