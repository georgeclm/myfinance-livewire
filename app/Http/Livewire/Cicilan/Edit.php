<?php

namespace App\Http\Livewire\Cicilan;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Rekening;
use App\Models\Utang;
use App\Models\Utangteman;
use Livewire\Component;

class Edit extends Component
{
    public $jenisuangsSelect;
    public $categories;
    public $categorymasuks;
    public $error;
    public $cicilan;
    public $form;
    public function rules()
    {
        return  [
            'form.nama' => 'required',
            'form.tanggal' => ['required', 'numeric'],
            'form.bulan' => ['required', 'numeric'],
            'form.jumlah' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.rekening_id2' => ['nullable', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.keterangan' => 'nullable',
            'form.utang_id' => ['nullable', 'in:' . auth()->user()->utangs->pluck('id')->implode(',')],
            'form.utangteman_id' => ['nullable', 'in:' . auth()->user()->utangtemans->pluck('id')->implode(',')],
            'form.category_id' => 'nullable',
            'form.category_masuk_id' => 'nullable',
        ];
    }
    public function mount()
    {
        $this->form = $this->cicilan->toArray();
        $this->form['jumlah'] = 'Rp  ' . number_format($this->cicilan->jumlah, 0, ',', '.');
    }
    public function submit()
    {

        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        // dd($this->form);
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
        $this->cicilan->update($this->form);
        session()->flash('success', 'Repetition have been updated');
        return redirect(route('cicilan'));
    }
    public function render()
    {
        return view('livewire.cicilan.edit');
    }
}
