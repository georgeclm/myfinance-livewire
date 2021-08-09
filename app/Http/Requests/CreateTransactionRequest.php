<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Jenisuang;
use App\Models\Category;
use App\Models\CategoryMasuk;

class CreateTransactionRequest extends FormRequest
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
            'jenisuang_id' => ['required', 'in:' . JenisUang::pluck('id')->implode(',')],
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
