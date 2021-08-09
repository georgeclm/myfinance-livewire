<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Transaction;
use App\Models\Utang;
use Illuminate\Http\Request;

class UtangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('utang.index');
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
        // dd(request()->all());
        request()->validate([
            'nama' => 'required',
            'jumlah' => ['required', 'numeric'],
            'keterangan' => 'nullable',
            'rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'user_id' => ['required', 'in:' . auth()->id()],
            'lunas' => ['required', 'in:0']
        ]);
        $rekening = Rekening::findOrFail(request()->rekening_id);
        $rekening->saldo_sekarang += request()->jumlah;
        $rekening->save();
        // dd(request()->all());
        Utang::create($request->all());

        return redirect()->back()->with('success', 'Utang Tersimpan, Saldo Bertambah');
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
        // dd(request()->all());

        request()->validate([
            'nama' => 'required',
            'keterangan' => 'nullable',
        ]);
        Utang::findOrFail($id)->update(request()->all());

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
