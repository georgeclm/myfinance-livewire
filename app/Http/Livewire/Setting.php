<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Ticker;
use Livewire\Component;

class Setting extends Component
{
    public $updatep2p = 'disabled';
    public $updatestock = 'disabled';
    public $updatedeposito = 'disabled';
    public $updatemutualfund = 'disabled';
    public $categories;
    public $category_masuks;
    public $p2pjumlah;
    public $stockjumlah;
    public $depositojumlah;
    public $reksadanajumlah;
    public $bankform = [
        'nama' => '',
        'code' => '',
    ];
    public $tickerform = [
        'nama' => '',
        'code' => '',
    ];


    public function mount()
    {
        $this->p2pjumlah = 'Rp  ' . number_format(auth()->user()->previous_p2p, 0, ',', '.');
        $this->stockjumlah = 'Rp  ' . number_format(auth()->user()->previous_stock, 0, ',', '.');
        $this->depositojumlah = 'Rp  ' . number_format(auth()->user()->previous_deposito, 0, ',', '.');
        $this->reksadanajumlah = 'Rp  ' . number_format(auth()->user()->previous_reksadana, 0, ',', '.');
        $this->categories = Category::where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->category_masuks = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }
    public function updating($name, $value)
    {
        switch ($name) {
            case 'p2pjumlah':
                $this->updatep2p = '';
                break;
            case 'stockjumlah':
                $this->updatestock = '';
                break;
            case 'depositojumlah':
                $this->updatedeposito = '';
                break;
            case 'reksadanajumlah':
                $this->updatemutualfund = '';
                break;
            default:
                break;
        }
    }

    public function submitp2p()
    {
        $this->p2pjumlah = str_replace('.', '', substr($this->p2pjumlah, 4));

        $user = auth()->user();
        $user->previous_p2p = $this->p2pjumlah;
        $user->save();

        session()->flash('success', 'Previous P2P Earning Have Been Updated');
        return redirect(route('setting'));
    }
    public function submitstock()
    {
        // dd($this->stockjumlah);
        $this->stockjumlah = str_replace('.', '', substr($this->stockjumlah, 4));

        $user = auth()->user();
        $user->previous_stock = $this->stockjumlah;
        $user->save();

        session()->flash('success', 'Previous Stock Earning Have Been Updated');
        return redirect(route('setting'));
    }
    public function submitdeposito()
    {
        $this->depositojumlah = str_replace('.', '', substr($this->depositojumlah, 4));

        $user = auth()->user();
        $user->previous_deposito = $this->depositojumlah;
        $user->save();

        session()->flash('success', 'Previous Deposito Earning Have Been Updated');
        return redirect(route('setting'));
    }
    public function submitreksadana()
    {
        $this->reksadanajumlah = str_replace('.', '', substr($this->reksadanajumlah, 4));

        $user = auth()->user();
        $user->previous_reksadana = $this->reksadanajumlah;
        $user->save();

        session()->flash('success', 'Previous Mutual Fund Earning Have Been Updated');
        return redirect(route('setting'));
    }
    public function store_bank()
    {
        $this->validate([
            'bankform.nama' => 'required|unique:banks,nama',
            'bankform.code' => 'required|numeric|unique:banks,code|min:2',
        ]);
        Bank::create([
            'nama' => strtoupper($this->bankform['nama']),
            'code' => $this->bankform['code']
        ]);
        session()->flash('success', 'New Bank have been added');
        return redirect(route('setting'));
    }
    public function store_stock()
    {
        $this->validate([
            'tickerform.nama' => 'required|unique:tickers,nama',
            'tickerform.code' => 'required|unique:tickers,code|regex:/^[a-zA-Z ]+$/|min:4',
        ]);
        Ticker::create([
            'nama' => $this->tickerform['nama'],
            'code' => strtoupper($this->tickerform['code'])
        ]);
        session()->flash('success', 'New Ticker have been added');
        return redirect(route('setting'));
    }
    public function render()
    {
        return view('livewire.setting');
    }
}
