<?php

namespace App\Http\Livewire\Rekening;

use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Detail extends Component
{

    public $rekening;
    public $jenisuangs;
    public $daterange = null;
    public $jumlah;
    public $jenisuang_id;
    public $transaction;


    public function mount(Rekening $rekening)
    {
        $this->rekening = $rekening;
        $this->jenisuangs = Jenisuang::all();
    }


    public function render()
    {
        $transactions = Transaction::with(['rekening', 'jenisuang', 'category_masuk', 'category', 'utang', 'utangteman'])->where('user_id', auth()->id());
        if ($this->daterange != null) {
            $date_range1 = explode(" / ", $this->daterange);
            $transactions = $transactions->where('created_at', '>=', $date_range1[0]);
            $transactions = $transactions->where('created_at', '<=', $date_range1[1]);
        }
        $transactions = $transactions->where('rekening_id', $this->rekening->id)->orWhere('rekening_id2', $this->rekening->id)->latest()->get();
        return view('livewire.rekening.detail', compact('transactions'));
    }
    public function revert()
    {
        $rekening1 = Rekening::find($this->transaction->rekening_id);

        if ($this->transaction->jenisuang_id == 1) {
            if ($rekening1->saldo_sekarang < $this->transaction->jumlah) {
                return $this->emit('error', 'Pocket doesnt have enough money');
            }
            $rekening1->saldo_sekarang -= $this->transaction->jumlah;
            $rekening1->save();
        } else {
            $rekening1->saldo_sekarang += $this->transaction->jumlah;
            $rekening1->save();
        }
        $this->transaction->delete();
        $this->emit('success', 'Transaction have been reverted');
        $this->emit('hideEdit');
    }
    public function refundModal($primaryId)
    {
        $this->transaction = Transaction::findOrFail($primaryId);
        // dd($transaction);
        $this->jumlah = $this->transaction->jumlah;
        $this->jenisuang_id = $this->transaction->jenisuang_id;
        $this->emit('editModal');
    }
}
