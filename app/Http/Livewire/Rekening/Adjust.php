<?php

namespace App\Http\Livewire\Rekening;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Transaction;
use Livewire\Component;

class Adjust extends Component
{

    public $rekening;
    public $saldo_sekarang;
    public $error;

    public function submit()
    {
        $frontJumlah = $this->saldo_sekarang;
        $this->saldo_sekarang = str_replace('.', '', substr($this->saldo_sekarang, 4));

        if ($this->saldo_sekarang == $this->rekening->saldo_sekarang) {
            $this->saldo_sekarang = $frontJumlah;
            $this->error = 'Same amount';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }

        $jumlah = abs($this->rekening->saldo_sekarang - $this->saldo_sekarang);
        $jenisuang_id = 0;
        $category_id = null;
        $category_masuk_id = null;

        if ($this->saldo_sekarang > $this->rekening->saldo_sekarang) {
            $jenisuang_id = 1;
            $category_masuk_id = CategoryMasuk::firstWhere('nama', 'Penyesuaian')->id;
        } else {
            $jenisuang_id = 2;
            $category_id = Category::firstWhere('nama', 'Penyesuaian')->id;
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => $jenisuang_id,
            'jumlah' => $jumlah,
            'rekening_id' => $this->rekening->id,
            'keterangan' => 'Penyesuaian',
            'category_id' => $category_id,
            'category_masuk_id' => $category_masuk_id
        ]);

        $this->rekening->update(['saldo_sekarang' => $this->saldo_sekarang]);
        session()->flash('success', 'Balance have been updated');
        return redirect(route('rekening'));
    }
    public function render()
    {
        return view('livewire.rekening.adjust');
    }
}
