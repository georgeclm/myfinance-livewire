@section('title', "{$jenisuang->nama} - My Finance")
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">{{ $jenisuang->nama }}</h1>
    </div>
    <div class="row mobile">
        <div class="small-when-0 col-xl-12 col-md-12 mb-4">
            <div class="bg-gray-100 border-0 card shadow h-100 py-2 border-bottom-warning">
                <div class="h3 fw-bold text-info card-body text-center">
                    <input wire:model="daterange" class="form-control" type="text" readonly
                        onchange="this.dispatchEvent(new InputEvent('input'))" style="text-align:center;"
                        name="daterange" />
                </div>
            </div>
        </div>
        @if (auth()->user()->rekenings->isEmpty())
            @livewire('partials.newaccount')
        @endif
    </div>
    <div class="bg-dark border-0 card shadow mb-4">
        <div class="bg-gray-100 border-0 card-header py-3">
            <div class="row align-items-baseline">
                <div class="col-md-5">
                    <h6 class="font-weight-bold {{ $jenisuang->textColor() }}">{{ $jenisuang->nama }}</h6>
                </div>
                <div class="col-md-5 my-2">
                    <h6 class="font-weight-bold {{ $jenisuang->textColor() }}">Rp.
                        {{ number_format($total, 0, ',', '.') }}
                    </h6>
                </div>
                @if ($jenisuang->id == 2)
                    <div class="col-md-2">
                        {{-- <input type="hidden" wire:model="q" value="{{ request()->q }}"> --}}
                        <select wire:model="search" class="form-control form-control-user" onchange="$wire.render()">
                            <option value="0" selected>Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($jenisuang->id == 1)
                    <div class="col-md-2">
                        {{-- <input type="hidden" wire:model="q" value="{{ request()->q }}"> --}}
                        <select wire:model="search2" class="form-control form-control-user">
                            <option value="0" selected>Category</option>
                            @foreach ($category_masuks as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            @forelse ($transactions as $transaction)
                <div class="pt-3 pb-0 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold {{ $jenisuang->textColor() }}">
                        @switch($transaction->jenisuang_id)
                            @case(1)
                                {{ $transaction->category_masuk->nama }}
                            @break
                            @case(2)
                                {{ $transaction->category->nama }}
                            @break
                            @case(3)
                                Transfer
                            @break
                            @case(4)
                                Pay Debt
                                {{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                            @break
                            @default
                                Friend Pay Debt
                                {{ Str::limit($transaction->utangteman->keterangan, 15, $end = '...') ?? $transaction->utangteman->nama }}
                        @endswitch - Rp.
                        {{ number_format($transaction->jumlah, 0, ',', '.') }}
                    </h6>
                </div>
                <div class="text-white my-3 mx-0">
                    <div class="d-flex ">
                        <div class="flex-grow-1">
                            {{ Str::limit($transaction->keterangan, 15, $end = '...') ?? '-' }}
                            <br>
                            {{ $transaction->rekening->nama_akun }}
                            @if ($transaction->jenisuang_id == 3)
                                to
                                {{ $transaction->rekening_tujuan->nama_akun }}
                            @endif
                        </div>
                        <span class="mobile-small">{{ $transaction->created_at->format('l j M') }}</span>
                    </div>
                </div>
                <hr class="bg-white my-1">
                @empty
                    <div class="text-center font-weight-bold text-white-50">
                        Empty
                    </div>
                @endforelse
            </div>
        </div>
    </div>
