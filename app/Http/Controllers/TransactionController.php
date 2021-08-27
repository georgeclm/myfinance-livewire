<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Transaction;
use App\Models\Utang;
use App\Models\Utangteman;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTransactionRequest;
use App\Models\CategoryMasuk;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisuangs = $jenisuangsSelect = Jenisuang::all();
        if (auth()->user()->utangs->isEmpty()) {
            $jenisuangsSelect = $jenisuangsSelect->reject(function ($e) {
                return $e->id  == 4;
            });
        }
        if (auth()->user()->utangtemans->isEmpty()) {
            $jenisuangsSelect = $jenisuangsSelect->reject(function ($e) {
                return $e->id  == 5;
            });
        }
        if (auth()->user()->rekenings->count() == 1) {
            $jenisuangsSelect = $jenisuangsSelect->reject(function ($e) {
                return $e->id  == 3;
            });
        }
        $categories = Category::whereNotIn('nama', ['Adjustment', 'Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $categorymasuks = CategoryMasuk::whereNotIn('nama',  ['Adjustment', 'Sell Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        return view('transaction.index', compact('jenisuangs', 'categories', 'jenisuangsSelect', 'categorymasuks'));
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
    public function store(CreateTransactionRequest $request)
    {
        $rekening1 = Rekening::findOrFail(request()->rekening_id);

        if (request()->jenisuang_id == 1) {
            $rekening1->saldo_sekarang += request()->jumlah;
            $rekening1->save();
        } else if (request()->jenisuang_id == 2) {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return redirect()->back()->with('error', 'Jumlah melebihi saldo');
            }
            $rekening1->saldo_sekarang -= request()->jumlah;
            $rekening1->save();
        } else if (request()->jenisuang_id == 4) {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return redirect()->back()->with('error', 'Jumlah melebihi saldo');
            }
            $utang = Utang::findOrFail(request()->utang_id);
            if ($utang->jumlah < request()->jumlah) {
                return redirect()->back()->with('error', 'Bayar melebihi Utang');
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
                return redirect()->back()->with('error', 'Bayar melebihi Utang');
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
                return back()->with('error', 'Jumlah melebihi saldo');
            }

            $rekening2 = Rekening::findOrFail(request()->rekening_id2);

            if ($rekening1 == $rekening2) {
                return back()->with('error', 'Tidak Bisa Transfer ke Rekening yang sama');
            }

            $rekening1->saldo_sekarang -= request()->jumlah;
            $rekening2->saldo_sekarang += request()->jumlah;
            $rekening1->save();
            $rekening2->save();
        }

        Transaction::create($request->validated());


        return back()->with('success', 'Transakasi Telah Tersimpan');
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
}
