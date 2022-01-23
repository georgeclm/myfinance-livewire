<?php

namespace App\Http\Livewire\Cicilan;

use App\Models\Cicilan;
use App\Models\Rekening;
use App\Models\Utang;
use App\Models\Utangteman;
use Livewire\Component;

class Create extends Component
{
    public $jenisuangsSelect;
    public $frontJumlah;
    public $categories;
    public $categorymasuks;
    public $error;
    public $jenisuangs;
    public $form =  [
        'sekarang' => 0,
        'bulan' => '',
        'jenisuang_id' => '',
        'rekening_id' => '',
        'rekening_id2' => '',
        'utang_id' => '',
        'utangteman_id' => '',
        'category_id' => '',
        'category_masuk_id' => ''
    ];
    public function rules()
    {
        return  [
            'form.user_id' => ['required', 'in:' . auth()->id()],
            'form.sekarang' => ['required', 'numeric', 'in:0'],
            'form.nama' => 'required',
            'form.tanggal' => ['required', 'numeric', 'between:1,31'],
            'form.jenisuang_id' => ['required', 'exists:jenisuangs,id'],
            'form.jumlah' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.rekening_id2' => ['nullable', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.keterangan' => 'nullable',
            'form.utang_id' => ['nullable', 'in:' . auth()->user()->utangs->pluck('id')->implode(',')],
            'form.utangteman_id' => ['nullable', 'in:' . auth()->user()->utangtemans->pluck('id')->implode(',')],
            'form.category_id' => ['nullable', 'exists:categories,id'],
            'form.category_masuk_id' => ['nullable', 'exists:categories,id'],
            'form.bulan' => ['required', 'numeric']
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
    }

    public function submit()
    {
        if ($this->form['rekening_id2'] == '') {
            $this->form['rekening_id2'] = null;
        }
        if (@$this->form['keterangan'] == '') {
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
        $this->frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = convert_to_number($this->form['jumlah']);
        if ($this->form['tanggal'] > 31 || $this->form['tanggal'] < 1) {
            $this->form['jumlah'] = $this->frontJumlah;
            return $this->emit('error', 'Date must be between 1 to 31');
        }
        if ($this->form['bulan'] == '') {
            $this->form['bulan'] = 0;
        }
        $this->validate();

        $rekening1 = Rekening::findOrFail($this->form['rekening_id']);
        if ($this->form['jenisuang_id'] == 1) {
        } else if ($this->form['jenisuang_id'] == 2) {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->form['jumlah'] = $this->frontJumlah;
                return $this->emit('error', 'Total is more than the curent pocket balance');
            }
        } else if ($this->form['jenisuang_id'] == 4) {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->form['jumlah'] = $this->frontJumlah;
                return $this->emit('error', 'Total is more than the curent pocket balance');
            }
            $utang = Utang::findOrFail($this->form['utang_id']);
            if ($utang->jumlah < $this->form['jumlah'] * $this->form['bulan']) {
                $this->form['jumlah'] = $this->frontJumlah;
                return $this->emit('error', 'Pay More than the debt');
            }
        } else if ($this->form['jenisuang_id'] == 5) {
            $utang = Utangteman::findOrFail($this->form['utangteman_id']);
            if ($utang->jumlah < $this->form['jumlah'] * $this->form['bulan']) {
                $this->form['jumlah'] = $this->frontJumlah;
                return $this->emit('error', 'Pay More than the debt');
            }
        } else {
            if ($rekening1->saldo_sekarang < $this->form['jumlah']) {
                $this->form['jumlah'] = $this->frontJumlah;
                return $this->emit('error', 'Total is more than the curent pocket balance');
            }
            $rekening2 = Rekening::findOrFail($this->form['rekening_id2']);
            if ($rekening1 == $rekening2) {
                $this->form['jumlah'] = $this->frontJumlah;
                return $this->emit('error', 'Cant Transfer to the same pocket');
            }
        }
        // dd($this->form);
        Cicilan::create($this->form);
        $this->emit('success', 'Repetition have been saved');
        $this->resetErrorBag();
        $this->emit('refreshCicilan');
        $this->emit('hideCreatePocket');
        $this->form =  [
            'sekarang' => 0,
            'bulan' => '',
            'jenisuang_id' => '',
            'rekening_id' => '',
            'rekening_id2' => '',
            'keterangan' => '',
            'utang_id' => '',
            'utangteman_id' => '',
            'category_id' => '',
            'category_masuk_id' => ''
        ];
    }
    public function render()
    {
        // dd($this->error);
        return view('livewire.cicilan.create');
    }
}
