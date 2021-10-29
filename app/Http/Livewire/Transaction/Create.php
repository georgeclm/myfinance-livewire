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

class Create extends Component
{

    public $jenisuangsSelect;
    public $frontJumlah;
    public $categories;
    public $categorymasuks;
    public $jenisuangs;
    public $error;
    public $form = [
        'user_id' => '',
        'jenisuang_id' => '',
        'jumlah' => '',
        'rekening_id' => '',
        'rekening_id2' => '',
        'keterangan' => '',
        'utang_id' => '',
        'utangteman_id' => '',
        'category_id' => '',
        'category_masuk_id' => ''
    ];


    protected function rules()
    {
        return [
            'form.jenisuang_id' => ['required', 'in:' . JenisUang::pluck('id')->implode(',')],
            'form.jumlah' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.rekening_id2' => ['nullable', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.keterangan' => 'nullable',
            'form.utang_id' => ['nullable', 'in:' . auth()->user()->utangs->pluck('id')->implode(',')],
            'form.utangteman_id' => ['nullable', 'in:' . auth()->user()->utangtemans->pluck('id')->implode(',')],
            'form.category_id' => ['nullable', 'in:' . Category::pluck('id')->implode(',')],
            'form.category_masuk_id' => ['nullable', 'in:' . CategoryMasuk::pluck('id')->implode(',')]
        ];
    }


    public function mount()
    {
        $this->jenisuangsSelect = $this->jenisuangs;
        if (auth()->user()->utangs->isEmpty()) {
            $this->jenisuangsSelect = $this->jenisuangsSelect->reject(function ($e) {
                return $e->id  == 4;
            });
        }
        if (auth()->user()->utangtemans->isEmpty()) {
            $this->jenisuangsSelect = $this->jenisuangsSelect->reject(function ($e) {
                return $e->id  == 5;
            });
        }
        if (auth()->user()->rekenings->count() == 1) {
            $this->jenisuangsSelect = $this->jenisuangsSelect->reject(function ($e) {
                return $e->id  == 3;
            });
        }
        $this->categories = Category::whereNotIn('nama', ['Adjustment', 'Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->categorymasuks = CategoryMasuk::whereNotIn('nama',  ['Adjustment', 'Sell Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }

    public function callError($msg)
    {
        $this->form['jumlah'] = $this->frontJumlah;
        $this->error = $msg;
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function submit()
    {
        if ($this->form['rekening_id2'] == '') {
            $this->form['rekening_id2'] = null;
        }
        if ($this->form['keterangan'] == '') {
            $this->form['keterangan'] = null;
        }
        if ($this->form['utang_id'] == '') {
            $this->form['utang_id'] = null;
        }
        if ($this->form['utangteman_id'] == '') {
            $this->form['utangteman_id'] = null;
        }
        if ($this->form['category_id'] == '') {
            $this->form['category_id'] = null;
        }
        if ($this->form['category_masuk_id'] == '') {
            $this->form['category_masuk_id'] = null;
        }
        $msg = 'Transaction have been saved';
        $this->form['user_id'] = auth()->id();
        $this->frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        if ($this->form['jumlah'] == '0') {
            $this->callError('Total cannot be 0');
            return $this->render();
        }
        $this->validate();
        $rekening1 = Rekening::find($this->form['rekening_id']);
        if ($this->form['jenisuang_id'] == 1) {
            $rekening1->saldo_sekarang += $this->form['jumlah'];
            $rekening1->save();
        } else if ($this->form['jenisuang_id'] == 2) {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->callError('Total is more than the curent pocket balance');
                return $this->render();
            }
            if ($this->form['jumlah'] > Auth::user()->total_with_assets() / 10) {
                $msg = 'You just spent more than you can afford';
            }
            $rekening1->saldo_sekarang -= $this->form['jumlah'];
            $rekening1->save();
        } else if ($this->form['jenisuang_id'] == 4) {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->callError('Total is more than the curent pocket balance');
                return $this->render();
            }
            $utang = Utang::findOrFail($this->form['utang_id']);
            if ($utang->jumlah < $this->form['jumlah']) {
                $this->callError('Pay More than the debt');
                return $this->render();
            }
            $utang->jumlah -= $this->form['jumlah'];
            if ($utang->jumlah <= 0) {
                $utang->lunas = 1;
            }
            $utang->save();
            $rekening1->saldo_sekarang -= $this->form['jumlah'];
            $rekening1->save();
        } else if ($this->form['jenisuang_id'] == 5) {
            $utang = Utangteman::findOrFail($this->form['utangteman_id']);
            if ($utang->jumlah < $this->form['jumlah']) {
                $this->callError('Pay More than the debt');
                return $this->render();
            }
            $utang->jumlah -= $this->form['jumlah'];
            if ($utang->jumlah <= 0) {
                $utang->lunas = 1;
            }
            $utang->save();
            $rekening1->saldo_sekarang += $this->form['jumlah'];
            $rekening1->save();
        } else {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->callError('Total is more than the curent pocket balance');
                return $this->render();
            }
            $rekening2 = Rekening::findOrFail($this->form['rekening_id2']);
            if ($rekening1 == $rekening2) {
                $this->callError('Cant Transfer to the same pocket');
                return $this->render();
            }
            $rekening1->saldo_sekarang -= $this->form['jumlah'];
            $rekening2->saldo_sekarang += $this->form['jumlah'];
            $rekening1->save();
            $rekening2->save();
        }

        Transaction::create($this->form);
        session()->flash('success', $msg);
        return redirect(route('transaction'));
    }
    public function render()
    {
        return view('livewire.transaction.create');
    }
}
