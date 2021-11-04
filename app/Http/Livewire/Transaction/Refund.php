<?php

namespace App\Http\Livewire\Transaction;

use App\Models\Rekening;
use Livewire\Component;

class Refund extends Component
{
    public $transaction;
    public $error;
    public function revert()
    {
        $rekening1 = Rekening::find($this->transaction->rekening_id);

        if ($this->transaction->jenisuang_id == 1) {
            if ($rekening1->saldo_sekarang < $this->transaction->jumlah) {
                $this->error = 'Pocket doesnt have enough money';
                $this->dispatchBrowserEvent('contentChanged');
                return $this->render();
            }
            $rekening1->saldo_sekarang -= $this->transaction->jumlah;
            $rekening1->save();
        } else {
            $rekening1->saldo_sekarang += $this->transaction->jumlah;
            $rekening1->save();
        }
        $this->transaction->delete();
        session()->flash('success', "Transaction have been reverted");

        return redirect(route('transaction'));
    }

    public function render()
    {
        return view('livewire.transaction.refund');
    }
}
