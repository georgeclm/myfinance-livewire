<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenis;
use App\Models\Rekening as ModelsRekening;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;

class Rekening extends Component
{


    public $jeniss;
    public $user;
    public $editJenis = 1;
    public $form;
    public $rekening;
    public $name;
    public $saldo;
    public $update_saldo;
    public $move = [
        'rekening_id' => '',
        'jumlah' => '',
    ];
    public $move_rekening_id;
    public $moveButton = 'disabled';

    protected $listeners = ['refreshPocket'];

    public function refreshPocket()
    {
        $this->mount();
    }

    public function updatedMoveJumlah()
    {
        $check_jumlah = str_replace('.', '', substr($this->move['jumlah'], 4));
        if ($check_jumlah > $this->rekening->saldo_sekarang) {
            $this->moveButton = 'disabled';
            // return $this->emit('error', 'Balance In Pocket Not Enough');
            return $this->addError('move.jumlah', 'Balance In Pocket Not Enough');
        }
        $this->resetErrorBag();
        $this->moveButton = '';
    }


    public function move()
    {
        $this->move['jumlah'] = str_replace('.', '', substr($this->move['jumlah'], 4));
        $rekening2 = ModelsRekening::findOrFail($this->move['rekening_id']);
        $rekening2->saldo_sekarang += $this->move['jumlah'];
        $rekening2->save();
        $this->rekening->saldo_sekarang -= $this->move['jumlah'];
        $this->rekening->save();
        Transaction::create([
            'user_id' => auth()->id(),
            'rekening_id' => $this->rekening->id,
            'rekening_id2' => $rekening2->id,
            'jenisuang_id' => 3,
            'jumlah' => $this->move['jumlah']
        ]);

        $this->emit('success', 'Money have been moved');
        $this->emit('refreshPocket');
        $this->emit('hidemodalFund');
    }

    public function editModal($id)
    {
        $this->rekening  = ModelsRekening::findOrFail($id);
        $this->form = $this->rekening->toArray();
        $this->form['saldo_sekarang'] = 'Rp  ' . number_format($this->rekening->saldo_sekarang, 0, ',', '.');
        $this->form['saldo_mengendap'] = 'Rp  ' . number_format($this->rekening->saldo_mengendap, 0, ',', '.');
        $this->editJenis = $this->rekening->jenis_id;
        $this->emit("editModal");
        $this->emit('run');
    }
    public function deleteModal($id)
    {
        $this->rekening  = ModelsRekening::findOrFail($id);
        $this->name = $this->rekening->nama_akun;
        $this->emit("deleteModal");
    }
    public function adjustModal($id)
    {
        $this->rekening  = ModelsRekening::findOrFail($id);
        $this->name = $this->rekening->nama_akun;
        $this->saldo = $this->rekening->saldo_sekarang;
        $this->emit("adjustModal");
        $this->emit('run');
    }

    public function refundModal($primaryId)
    {
        $this->rekening  = ModelsRekening::findOrFail($primaryId);
        $this->name = $this->rekening->nama_akun;
        $this->saldo = $this->rekening->saldo_sekarang;
        $this->move_rekening_id = $primaryId;
        $this->emit("modalFund");
        $this->emit('run');
    }

    public function delete()
    {
        $this->rekening->delete();
        $this->emit("hideDelete");
        $this->emit('refreshBalance');
        $this->emit('success', 'Pocket have been deleted');
        $this->emit('refreshPocket');
    }
    public function adjust()
    {
        $frontJumlah = $this->update_saldo;
        $this->update_saldo = str_replace('.', '', substr($this->update_saldo, 4));
        if ($this->update_saldo == $this->rekening->saldo_sekarang) {
            $this->update_saldo = $frontJumlah;
            return $this->emit('error', 'Same Amount');
        }

        $jumlah = abs($this->rekening->saldo_sekarang - $this->update_saldo);
        $jenisuang_id = 0;
        $category_id = null;
        $category_masuk_id = null;

        if ($this->update_saldo > $this->rekening->saldo_sekarang) {
            $jenisuang_id = 1;
            $category_masuk_id = CategoryMasuk::firstWhere('nama', 'Adjustment')->id;
        } else {
            $jenisuang_id = 2;
            $category_id = Category::firstWhere('nama', 'Adjustment')->id;
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => $jenisuang_id,
            'jumlah' => $jumlah,
            'rekening_id' => $this->rekening->id,
            'keterangan' => 'Adjustment',
            'category_id' => $category_id,
            'category_masuk_id' => $category_masuk_id
        ]);

        $this->rekening->update(['saldo_sekarang' => $this->update_saldo]);
        $this->emit("hideAdjust");
        $this->emit('refreshBalance');
        $this->resetErrorBag();
        $this->update_saldo = null;
        $this->emit('success', 'Balance have been updated');
        $this->emit('refreshPocket');
    }
    public function update()
    {
        if ($this->form['saldo_mengendap'] == '') {
            $this->form['saldo_mengendap'] = null;
        }
        if ($this->form['saldo_mengendap'] != null) {
            $this->form['saldo_mengendap'] = str_replace('.', '', substr($this->form['saldo_mengendap'], 4));
        }
        $this->validate([
            'form.nama_akun' => 'required',
            'form.nama_bank' => 'nullable',
            'form.saldo_mengendap' => ['nullable', 'numeric'],
            'form.keterangan' => 'nullable',
        ]);

        $this->rekening->update([
            'nama_akun' => $this->form['nama_akun'],
            'nama_bank' => $this->form['nama_bank'],
            'saldo_mengendap' => $this->form['saldo_mengendap'],
            'keterangan' => $this->form['keterangan'],
        ]);
        $this->emit("hideEdit");
        $this->emit('refreshBalance');

        $this->emit('success', 'Pocket have been updated');

        $this->resetErrorBag();
        $this->emit('refreshPocket');
    }

    public function mount()
    {
        $this->jeniss = Jenis::with('user_rekenings')->get();
    }

    public function render()
    {
        return view('livewire.rekening');
    }
}
