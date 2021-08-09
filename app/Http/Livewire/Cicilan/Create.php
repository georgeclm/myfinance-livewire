<?php

namespace App\Http\Livewire\Cicilan;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Cicilan;
use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Utang;
use App\Models\Utangteman;
use Livewire\Component;

class Create extends Component
{
    public $jenisuangsSelect;
    public $categories;
    public $categorymasuks;
    public $error;
    public $jenisuangs;
    public $form =  [
        'user_id' => '',
        'sekarang' => 0,
        'nama' => '',
        'tanggal' => '',
        'bulan' => '',
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
    public function rules()
    {
        return  [
            'form.user_id' => 'required',
            'form.sekarang' => ['required', 'numeric', 'in:0'],
            'form.nama' => 'required',
            'form.tanggal' => ['required', 'numeric'],
            'form.bulan' => ['required', 'numeric'],
            'form.jenisuang_id' => ['required', 'in:' . Jenisuang::pluck('id')->implode(',')],
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
        $this->categories = Category::whereNotIn('nama', ['Penyesuaian', 'Investasi'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->categorymasuks = CategoryMasuk::whereNotIn('nama',  ['Penyesuaian', 'Jual Investasi'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
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
        $this->form['user_id'] = auth()->id();
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        if ($this->form['tanggal'] > 31 || $this->form['tanggal'] < 1) {
            $this->form['jumlah'] = $frontJumlah;
            $this->error = 'Date must be between 1 to 31';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }
        // dd($this->form);

        $rekening1 = Rekening::findOrFail($this->form['rekening_id']);
        if ($this->form['jenisuang_id'] == 1) {
        } else if ($this->form['jenisuang_id'] == 2) {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->form['jumlah'] = $frontJumlah;
                $this->error = 'Total is more than the curent pocket balance';
                $this->dispatchBrowserEvent('contentChanged');
                return $this->render();
            }
        } else if ($this->form['jenisuang_id'] == 4) {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->form['jumlah'] = $frontJumlah;
                $this->error = 'Total is more than the curent pocket balance';
                $this->dispatchBrowserEvent('contentChanged');
                return $this->render();
            }
            $utang = Utang::findOrFail($this->form['utang_id']);
            if ($utang->jumlah < $this->form['jumlah'] * $this->form['bulan']) {
                $this->form['jumlah'] = $frontJumlah;
                $this->error = 'Pay More than the debt';
                $this->dispatchBrowserEvent('contentChanged');
                return $this->render();
            }
        } else if ($this->form['jenisuang_id'] == 5) {
            $utang = Utangteman::findOrFail($this->form['utangteman_id']);
            if ($utang->jumlah < $this->form['jumlah'] * $this->form['bulan']) {
                $this->form['jumlah'] = $frontJumlah;
                $this->error = 'Pay More than the debt';
                $this->dispatchBrowserEvent('contentChanged');
                return $this->render();
            }
        } else {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->form['jumlah'] = $frontJumlah;
                $this->dispatchBrowserEvent('contentChanged');
                $this->error = 'Total is more than the curent pocket balance';
                return $this->render();
            }
            $rekening2 = Rekening::findOrFail($this->form['rekening_id2']);
            if ($rekening1 == $rekening2) {
                $this->form['jumlah'] = $frontJumlah;
                $this->dispatchBrowserEvent('contentChanged');
                $this->error = 'Cant Transfer to the same pocket';
                return $this->render();
            }
        }
        // dd($this->form);
        Cicilan::create($this->form);
        session()->flash('success', 'Repetition have been saved');
        return redirect(route('cicilan'));
    }
    public function render()
    {
        // dd($this->error);
        return view('livewire.cicilan.create');
    }
}
