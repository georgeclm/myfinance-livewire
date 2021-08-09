<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningApiController extends Controller
{
    public function index()
    {
        return Rekening::all();
    }
    public function store()
    {
        request()->validate([
            'jenis_id' => ['required', 'in:' . Jenis::pluck('id')->implode(',')],
            'nama_akun' => 'required',
            'nama_bank' => 'nullable',
            'saldo_sekarang' => ['required', 'numeric'],
            'saldo_mengendap' => ['nullable', 'numeric'],
            'keterangan' => 'nullable',
            'user_id' => 'required'
        ]);
        // request need user_id
        $success = Rekening::create(request()->all());
        return ['success' => $success];
    }
    public function update(Rekening $rekening)
    {
        $success = $rekening->update([
            'jenis_id' => request('jenis_id'),
            'nama_akun' => request('nama_akun'),
            'nama_bank' => request('nama_bank'),
            'saldo_sekarang' => request('saldo_sekarang'),
            'saldo_mengendap' => request('saldo_mengendap'),
            'keterangan' => request('keterangan'),
        ]);
        return [
            'success' => $success
        ];
    }
    public function destroy(Rekening $rekening)
    {
        $success = $rekening->delete();
        return [
            'success' => $success
        ];
    }
    public function search($name)
    {
        return Rekening::where('nama_akun', 'like', '%' . $name . '%')->get();
    }
}
