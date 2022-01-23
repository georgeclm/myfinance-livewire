<?php

namespace App\Http\Livewire\Utangteman;

use App\Models\Rekening;
use App\Models\Utangteman;
use Livewire\Component;

class Create extends Component
{

    public $form = [
        'nama' => '',
        'jumlah' => '',
        'rekening_id' => '',
        'keterangan' => null,
        'user_id' => '',
        'lunas' => 0
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'form.nama' => 'required',
            'form.jumlah' => 'required',
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ]);
    }

    protected $validationAttributes = [
        'form.nama' => 'name',
        'form.jumlah' => 'total',
        'form.rekening_id' => 'pocket',
    ];

    public function rules()
    {
        return [
            'form.nama' => 'required',
            'form.jumlah' => ['required', 'numeric'],
            'form.keterangan' => 'nullable',
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.user_id' => ['required', 'in:' . auth()->id()],
            'form.lunas' => ['required', 'in:0']
        ];
    }


    public function submit()
    {
        $this->form['user_id'] = auth()->id();
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = convert_to_number($this->form['jumlah']);
        if ($this->form['jumlah'] == '0') {
            $this->form['jumlah'] = $frontJumlah;
            return $this->emit('error', 'Total cannot be 0');
        }
        $this->validate();

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        if ($rekening->saldo_sekarang < request()->jumlah) {
            $this->form['jumlah'] = $frontJumlah;
            return $this->emit('error', 'Total cannot be 0');
        }
        $rekening->saldo_sekarang -= $this->form['jumlah'];
        $rekening->save();
        Utangteman::create($this->form);

        $this->emit('success', 'Friend Debt have been stored');
        $this->emit("hideCreatePocket");
        $this->emit('refreshFriendDebt');
        $this->resetErrorBag();
        $this->form = [
            'nama' => '',
            'jumlah' => '',
            'rekening_id' => '',
            'keterangan' => null,
            'user_id' => '',
            'lunas' => 0
        ];
    }

    public function render()
    {
        return view('livewire.utangteman.create');
    }
}
