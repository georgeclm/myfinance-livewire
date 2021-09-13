<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function selectSearch(Request $request)
    {
        $banks = [];

        if ($request->has('q')) {
            $search = $request->q;
            $banks = Bank::select("id", "nama")->where('code', '!=', '9999')
                ->where('nama', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($banks);
    }
}
