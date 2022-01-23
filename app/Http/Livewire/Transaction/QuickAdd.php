<?php

namespace App\Http\Livewire\Transaction;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Transaction;
use App\Models\Utang;
use App\Models\Utangteman;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuickAdd extends Component
{
    public $categories;
    public $category_masuks;
    public $form = [
        'user_id' => '',
        'jenisuang_id' => '',
        'jumlah' => '',
        'rekening_id' => '',
        'keterangan' => '',
        'category_id' => '',
        'category_masuk_id' => ''
    ];

    protected function rules()
    {
        return [
            'form.jenisuang_id' => ['required', 'in:1,2'],
            'form.jumlah' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.keterangan' => 'nullable',
            'form.category_id' => 'nullable',
            'form.category_masuk_id' => 'nullable'
        ];
    }
    public function mount()
    {
        $this->categories = Category::whereNotIn('nama', ['Adjustment', 'Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->category_masuks = CategoryMasuk::whereNotIn('nama',  ['Adjustment', 'Sell Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }
    public function submit()
    {

        if ($this->form['keterangan'] == '') {
            $this->form['keterangan'] = null;
        }
        if ($this->form['category_id'] == '') {
            $this->form['category_id'] = null;
        }
        if ($this->form['category_masuk_id'] == '') {
            $this->form['category_masuk_id'] = null;
        }
        $msg = 'Transaction have been saved';

        $this->form['user_id'] = auth()->id();

        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = convert_to_number($this->form['jumlah']);
        if ($this->form['jumlah'] == '0') {
            $this->form['jumlah'] = $frontJumlah;
            return $this->emit('error', 'Total cannot be 0');
        }
        $this->validate();
        $rekening1 = Rekening::find($this->form['rekening_id']);
        if ($this->form['jenisuang_id'] == 1) {
            $rekening1->saldo_sekarang += $this->form['jumlah'];
            $rekening1->save();
        } else {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->form['jumlah'] = $frontJumlah;
                return $this->emit('error', 'Total is more than the curent pocket balance');
            }
            if ($this->form['jumlah'] > Auth::user()->total_with_assets() / 10) {
                $msg = 'You just spent more than you can afford';
            }
            $rekening1->saldo_sekarang -= $this->form['jumlah'];
            $rekening1->save();
        }

        Transaction::create($this->form);
        $this->emit("hideCreateTransaction");
        $this->emit('success', $msg);
        $this->emit('refreshTransaction');
        $this->resetErrorBag();
        $this->form = [
            'jenisuang_id' => '',
            'jumlah' => '',
            'rekening_id' => '',
            'keterangan' => '',
            'category_id' => '',
            'category_masuk_id' => ''
        ];
        // return redirect(route('transaction'));
    }
    public function render()
    {
        return view('livewire.transaction.quick-add');
    }
}
