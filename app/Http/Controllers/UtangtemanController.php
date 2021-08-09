<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Transaction;
use App\Models\Utangteman;
use Illuminate\Http\Request;

class UtangtemanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utangs = Utangteman::where('user_id', auth()->id())->where('lunas', 0)->get();
        return view('utangteman.index', compact('utangs'));
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
            'nama' => 'required',
            'jumlah' => ['required', 'numeric'],
            'keterangan' => 'nullable',
            'rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'user_id' => ['required', 'in:' . auth()->id()],
            'lunas' => ['required', 'in:0']
        ]);
        $rekening = Rekening::findOrFail(request()->rekening_id);
        if ($rekening->saldo_sekarang < request()->jumlah) {
            return redirect()->back()->with('error', 'Saldomu tidak cukup');
        }
        $rekening->saldo_sekarang -= request()->jumlah;
        $rekening->save();
        // dd(request()->all());
        Utangteman::create($request->all());


        return redirect()->back()->with('success', 'Utang Teman Tersimpan, Saldo Berkurang');
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
            'nama' => 'required',
            'keterangan' => 'nullable',
        ]);
        Utangteman::findOrFail($id)->update(request()->all());

        return redirect()->back()->with('success', 'Update Succesful');
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
