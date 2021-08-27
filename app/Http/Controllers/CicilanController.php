<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCicilanRequest;
use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Cicilan;
use App\Models\Jenisuang;
use App\Models\NotifCicilan;
use App\Models\Rekening;
use App\Models\Transaction;
use App\Models\Utang;
use App\Models\Utangteman;
use Illuminate\Http\Request;

class CicilanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisuangs = $jenisuangsSelect = Jenisuang::with('user_transactions')->get();
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
        $categories = Category::where('user_id', null)->orWhere('user_id', auth()->id())->whereNotIn('nama', ['Adjustment', 'Investment'])->get();
        $categorymasuks = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->whereNotIn('nama', ['Adjustment', 'Sell Investment'])->get();
        return view('cicilan.index', compact('jenisuangs', 'jenisuangsSelect', 'categorymasuks', 'categories'));
    }

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
                    'notification' => 'Cicilan ' . $cicilan->nama . ' jalan dengan jumlah Rp. ' . number_format($cicilan->jumlah, 0, ',', '.'),
                    'check' => 0
                ]);
            }
        }
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
    public function store(CreateCicilanRequest $request)
    {
        // dd($request->validated());
        function relax()
        {;
        }
        $rekening1 = Rekening::findOrFail(request()->rekening_id);
        if (request()->jenisuang_id == 1) {
            relax();
        } else if (request()->jenisuang_id == 2) {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return redirect()->back()->with('error', 'Jumlah melebihi saldo');
            }
        } else if (request()->jenisuang_id == 4) {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return redirect()->back()->with('error', 'Jumlah melebihi saldo');
            }
            $utang = Utang::findOrFail(request()->utang_id);
            if ($utang->jumlah < request()->jumlah * request()->bulan) {
                return redirect()->back()->with('error', 'Bayar melebihi Utang');
            }
        } else if (request()->jenisuang_id == 5) {
            $utang = Utangteman::findOrFail(request()->utangteman_id);
            if ($utang->jumlah < request()->jumlah * request()->bulan) {
                return redirect()->back()->with('error', 'Bayar melebihi Utang');
            }
        } else {
            if ($rekening1->saldo_sekarang < request()->jumlah) {
                return back()->with('error', 'Jumlah melebihi saldo');
            }
            $rekening2 = Rekening::findOrFail(request()->rekening_id2);
            if ($rekening1 == $rekening2) {
                return back()->with('error', 'Tidak Bisa Transfer ke Rekening yang sama');
            }
        }

        Cicilan::create($request->validated());
        return redirect()->back()->with('success', 'Pengulangan Transaksi Telah Terbuat');
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
