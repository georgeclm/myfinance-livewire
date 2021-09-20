<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function partial()
    {
        $user = auth()->user();
        if ($user) {
            return response()->json([
                'success' => true,
                'income' => $user->uangmasuk(),
                'spending' => $user->uangkeluar(),
                'balance' => $user->saldoperbulan(),
                'networth' =>  $user->total_with_assets(),
                'totalbalance' => $user->saldo(),
                'total_utang' => $user->totalutang(),
                'total_utang_teman' => $user->totalutangteman(),
            ]);
        }
        return response()->json([
            'success' => false,
        ]);
    }

    public function jenis()
    {
        $jeniss = Jenis::with('user_rekenings')->get();
        if ($jeniss != null) {
            return response()->json([
                'success' => true,
                'jeniss' => $jeniss
            ]);
        }
        return response()->json([
            'success' => false,
        ]);
    }
}
