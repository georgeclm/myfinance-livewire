<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Cicilan as ModelsCicilan;
use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Utang;
use App\Models\Utangteman;
use Livewire\Component;

class Cicilan extends Component
{

    public $jenisuangs;
    public $categories;
    public $categorymasuks;
    public $cicilan;
    public $nama;
    public $form;
    public $jenisId;
    public $frontJumlah;
    protected $listeners = ['refreshCicilan'];

    public function refreshCicilan()
    {
        $this->render();
    }

    public function rules()
    {
        return  [
            'form.nama' => 'required',
            'form.tanggal' => ['required', 'numeric'],
            'form.bulan' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.rekening_id2' => ['nullable', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.keterangan' => 'nullable',
            'form.utang_id' => ['nullable', 'in:' . auth()->user()->utangs->pluck('id')->implode(',')],
            'form.utangteman_id' => ['nullable', 'in:' . auth()->user()->utangtemans->pluck('id')->implode(',')],
            'form.category_id' => 'nullable',
            'form.category_masuk_id' => 'nullable',
        ];
    }
    public function deleteModal($primaryId)
    {
        $this->cicilan = ModelsCicilan::findOrFail($primaryId);
        $this->nama = $this->cicilan->nama;
        $this->emit('deleteModal');
    }
    public function editModal($primaryId)
    {
        $this->cicilan = ModelsCicilan::findOrFail($primaryId);
        $this->form = $this->cicilan->toArray();
        $this->form['jumlah'] = 'Rp  ' . number_format($this->cicilan->jumlah, 0, ',', '.');
        $this->jenisId = $this->cicilan->jenisuang_id;
        $this->emit('editModal');
    }
    public function delete()
    {
        $this->cicilan->delete();
        $this->emit('success', 'Repetition have been deleted');
        $this->emit('hideDelete');
    }
    public function update()
    {
        if ($this->form['bulan'] == '') {
            $this->form['bulan'] = 0;
        }
        $this->frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        if ($this->form['tanggal'] > 31 || $this->form['tanggal'] < 1) {
            $this->form['jumlah'] = $this->frontJumlah;
            return $this->emit('error', 'Date must be between 1 to 31');
        }
        // dd($this->form);

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
        $this->cicilan->update($this->form);
        $this->emit('success', 'Cicilan Have Been Updated');
        $this->emit('hideEdit');
        $this->resetErrorBag();
    }
    public function mount()
    {
        $this->categories = Category::whereNotIn('nama', ['Adjustment', 'Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->categorymasuks = CategoryMasuk::whereNotIn('nama',  ['Adjustment', 'Sell Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }

    public function render()
    {
        $this->jenisuangs = Jenisuang::all();
        return view('livewire.cicilan');
    }
}
