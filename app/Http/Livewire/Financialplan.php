<?php

namespace App\Http\Livewire;

use App\Models\FinancialPlan as ModelsFinancialPlan;
use Livewire\Component;

class Financialplan extends Component
{
    public $emergency;
    public $financialplan;
    public $fund;
    public $saving;
    protected $listeners = ['refreshFinancialPlan'];
    public $name;

    public function refreshFinancialPlan()
    {
        $this->render();
    }

    public function deleteModal($primaryId)
    {
        $this->financialplan = ModelsFinancialPlan::findOrFail($primaryId);
        $this->name = $this->financialplan->nama;
        $this->emit('deleteModal');
    }

    public function delete()
    {
        $this->financialplan->delete();
        $this->emit("hideDelete");
        $this->emit('success', 'Financial Plan have been deleted');
    }
    public function editModal($primaryId)
    {
        $this->financialplan = ModelsFinancialPlan::findOrFail($primaryId);
        if ($this->financialplan->produk == 'Emergency Fund') {
            $this->emergency = $this->financialplan->toArray();
            $this->emergency['jumlah'] = 'Rp  ' . number_format($this->financialplan->perbulan, 0, ',', '.');
            $this->emit('editmodalEmergency');
        } elseif ($this->financialplan->produk == 'Fund For Stuff') {
            $this->fund = $this->financialplan->toArray();
            $this->fund['target'] = 'Rp  ' . number_format($this->financialplan->target + $this->financialplan->dana_awal, 0, ',', '.');
            $this->fund['jumlah'] = 'Rp  ' . number_format($this->financialplan->dana_awal, 0, ',', '.');
            $this->emit('editmodalFund');
        } else {
            $this->saving = $this->financialplan->toArray();
            $this->saving['jumlah'] = 'Rp  ' . number_format($this->financialplan->perbulan, 0, ',', '.');
            $this->saving['target'] = 'Rp  ' . number_format($this->financialplan->dana_awal, 0, ',', '.');

            $this->emit('editmodalSaving');
        }
    }
    public function update()
    {
        if ($this->financialplan->produk == 'Emergency Fund') {
            $frontJumlah = $this->emergency['jumlah'];
            $this->emergency['jumlah'] = str_replace('.', '', substr($this->emergency['jumlah'], 4));
            $this->validate([
                'emergency.jumlah' => ['required', 'numeric'],
                'emergency.status_pernikahan' => ['required', 'numeric', 'in:1,2,3']
            ]);
            if ($this->emergency['jumlah'] == '0') {
                $this->emergency['jumlah'] = $frontJumlah;
                return $this->emit('error', 'Fund cannot be 0');
            }

            $multiply =  [
                1 =>  6,
                2 =>  9,
            ][$this->emergency['status_pernikahan']] ??  12;

            $this->emergency['jumlah'] *= $multiply;

            $this->financialplan->update([
                'target' => $this->emergency['jumlah'],
                'status_pernikahan' => $this->emergency['status_pernikahan'],
                'perbulan' => $this->emergency['jumlah'] / $multiply
            ]);
            $this->resetErrorBag();
            $this->emit("hideeditmodalEmergency");

            $this->emit('success', 'Emergency Fund Plan have been updated');
        } elseif ($this->financialplan->produk == 'Fund For Stuff') {
            $frontTarget = $this->fund['target'];
            $this->fund['target'] = str_replace('.', '', substr($this->fund['target'], 4));
            $frontJumlah = $this->fund['jumlah'];
            $this->fund['jumlah'] = str_replace('.', '', substr($this->fund['jumlah'], 4));
            $this->validate([
                'fund.nama' => 'required',
                'fund.target' => ['required', 'numeric'],
                'fund.bulan' => ['required', 'numeric'],
                'fund.jumlah' => ['required', 'numeric']
            ]);
            // dd($this->fund);

            if ($this->fund['target'] == '0' || $this->fund['bulan'] == '0') {
                $this->fund['target'] = $frontTarget;
                $this->fund['jumlah'] = $frontJumlah;
                return $this->emit('error', 'Stuff Price or how long cannot be 0');
            }
            $target = $this->fund['target'] - $this->fund['jumlah'];
            $perbulan = $target / $this->fund['bulan'];

            $this->financialplan->update([
                'nama' => $this->fund['nama'],
                'target' => $target,
                'perbulan' => $perbulan,
                'bulan' => $this->fund['bulan'],
                'dana_awal' => $this->fund['jumlah']
            ]);
            $this->resetErrorBag();
            $this->emit("hideeditmodalFund");
            $this->emit('success', 'Fund For Stuff Plan have been updated');
        } else {
            $frontTarget = $this->saving['target'];
            $this->saving['target'] = str_replace('.', '', substr($this->saving['target'], 4));
            $frontJumlah = $this->saving['jumlah'];
            $this->saving['jumlah'] = str_replace('.', '', substr($this->saving['jumlah'], 4));
            $this->validate([
                'saving.target' => ['required', 'numeric'],
                'saving.jumlah' => ['required', 'numeric'],
                'saving.bulan' => ['required', 'numeric']
            ]);
            if ($this->saving['target'] == '0' || $this->saving['bulan'] == '0') {
                $this->saving['target'] = $frontTarget;
                $this->saving['jumlah'] = $frontJumlah;
                return $this->emit('error', 'Funds or how long cannot be 0');
            }

            $target = $this->saving['target'] + ($this->saving['jumlah'] * $this->saving['bulan']);
            $this->financialplan->update([
                'target' => $target,
                'perbulan' => $this->saving['jumlah'],
                'bulan' => $this->saving['bulan'],
                'dana_awal' => $this->saving['target']
            ]);
            $this->resetErrorBag();
            $this->emit("hideeditmodalSaving");
            $this->emit('success', 'Savings Fund Plan have been updated');
        }
    }
    public function render()
    {
        return view('livewire.financialplan');
    }
}
