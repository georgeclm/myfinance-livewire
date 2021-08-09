<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenisuang;
use Illuminate\Foundation\Http\FormRequest;

class CreateCicilanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'sekarang' => ['required', 'numeric', 'in:0'],
            'nama' => 'required',
            'tanggal' => ['required', 'numeric', 'between:1,31'],
            'bulan' => ['required', 'numeric'],
            'jenisuang_id' => ['required', 'in:' . Jenisuang::pluck('id')->implode(',')],
            'jumlah' => ['required', 'numeric'],
            'rekening_id' => ['required', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'rekening_id2' => ['sometimes', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'keterangan' => 'nullable',
            'utang_id' => ['sometimes', 'in:' . auth()->user()->utangs->pluck('id')->implode(',')],
            'utangteman_id' => ['sometimes', 'in:' . auth()->user()->utangtemans->pluck('id')->implode(',')],
            'category_id' => ['sometimes', 'in:' . Category::pluck('id')->implode(',')],
            'category_masuk_id' => ['sometimes', 'in:' . CategoryMasuk::pluck('id')->implode(',')]
        ];
    }
}
