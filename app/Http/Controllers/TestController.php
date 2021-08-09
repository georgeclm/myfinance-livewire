<?php

namespace App\Http\Controllers;

use App\Models\Utang;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $utang = Utang::find(4);
        $newUtang = $utang->replicate();
        $newUtang->id = rand();
        $newUtang->save();
    }
}
