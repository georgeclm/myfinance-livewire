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
    public $error;

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
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        if ($this->form['jumlah'] == '0') {
            $this->form['jumlah'] = $frontJumlah;
            $this->error = 'Total cannot be 0';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }
        $this->validate();

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        if ($rekening->saldo_sekarang < request()->jumlah) {
            $this->form['jumlah'] = $frontJumlah;
            $this->error = 'Balance not enough';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }
        $rekening->saldo_sekarang -= $this->form['jumlah'];
        $rekening->save();
        Utangteman::create($this->form);

        session()->flash('success', 'Friend Debt have been stored');
        return redirect(route('utangteman'));
    }

    public function render()
    {
        return view('livewire.utangteman.create');
    }
}
