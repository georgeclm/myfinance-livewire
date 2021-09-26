@section('title', "{$jenisuang->nama} - My Finance")
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">{{ $jenisuang->nama }}</h1>
    </div>
    <div class="row mobile">
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 card border-left-success border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Income
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#incomeModal">
                                    <i class="fas fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="h7 mb-0 @if (Auth::user()->uangmasuk($daterange)->sum('jumlah') >= 1000000000) small @endif font-weight-bold text-success">Rp.
                                {{ number_format(
    auth()->user()->uangmasuk($daterange)->sum('jumlah'),
    0,
    ',',
    '.',
) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="incomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Income</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Total {{ now()->format('F') }} Income (Sell Investment Not
                            Included)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 card border-0 border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Spending
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#spendingModal">
                                    <i class="fas fa-question-circle"></i>
                                </a>

                            </div>
                            <div
                                class="h7 mb-0 @if (Auth::user()->uangkeluar($daterange)->sum('jumlah') >= 1000000000) small @endif
                                font-weight-bold text-danger">
                                Rp.
                                {{ number_format(
    Auth::user()->uangkeluar($daterange)->sum('jumlah'),
    0,
    ',',
    '.',
) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-funnel-dollar fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="spendingModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Spending</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Total {{ now()->format('F') }} Spending
                            (Investment is not included)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 card border-left-primary border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Balance
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#balanceModal">
                                    <i class="fas fa-question-circle"></i>
                                </a>
                            </div>
                            <div
                                class="h7 mb-0 @if (Auth::user()->uangmasuk($daterange)->sum('jumlah') -
        Auth::user()->uangkeluar($daterange)->sum('jumlah') >=
    1000000000) small @endif font-weight-bold text-primary">
                                Rp.
                                {{ number_format(
    Auth::user()->uangmasuk($daterange)->sum('jumlah') -
        Auth::user()->uangkeluar($daterange)->sum('jumlah'),
    0,
    ',',
    '.',
) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="balanceModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Balance</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Income - Spending</div>
                    </div>
                </div>
            </div>
        </div>
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
                    <h6 class="font-weight-bold text-primary">{{ $jenisuang->nama }}</h6>
                </div>
                <div class="col-md-5 my-2">
                    <h6 class="font-weight-bold text-primary">Rp.
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
            <div class="table-responsive">
                <div class="wrap-table100 " id="thetable">
                    <div class="table">
                        @forelse ($transactions as $transaction)
                            <div class="row">
                                <div class="cell {{ $jenisuang->textColor() }}" data-title="Total">
                                    Rp. {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                </div>
                                @if ($jenisuang->id == 4)
                                    <div class="cell text-white" data-title="Debt Name">
                                        {{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                                    </div>
                                @endif
                                @if ($jenisuang->id == 5)
                                    <div class="cell text-white" data-title="Debt Name">
                                        {{ Str::limit($transaction->utangteman->keterangan, 15, $end = '...') ?? $transaction->utangteman->nama }}
                                    </div>
                                @endif
                                @if ($jenisuang->id == 1)
                                    <div class="cell text-white" data-title="Category">
                                        {{ $transaction->category_masuk->nama }}
                                    </div>
                                @endif
                                @if ($jenisuang->id == 2)
                                    <div class="cell text-white" data-title="Category">
                                        {{ $transaction->category->nama }}
                                    </div>
                                @endif
                                <div class="cell text-white" data-title="Pocket">
                                    {{ isset($transaction->rekening) ? $transaction->rekening->nama_akun : 'Pocket deleted' }}
                                </div>
                                @if ($jenisuang->id == 3)
                                    <div class="cell text-white" data-title="Pocket Destination">
                                        {{ isset($transaction->rekening_tujuan) ? $transaction->rekening_tujuan->nama_akun : 'Pocket deleted' }}
                                    </div>
                                @endif
                                <div class="cell text-white" data-title="Description">
                                    {{ Str::limit($transaction->keterangan, 15, $send = '...') ?? '-' }}
                                </div>
                                <div class="cell text-white" data-title="Date">
                                    {{ $transaction->created_at->format('l j F Y') }}
                                </div>
                            </div>
                        @empty
                            <div class="row">
                                <div class="cell">
                                    Records Empty
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <table class="only-big table table-bordered table-dark" width="100%" cellspacing="0" id="bigtable">
                    <thead>
                        <tr class="{{ $jenisuang->color() }} text-light">
                            <th>Total</th>
                            @if (in_array($jenisuang->id, [4, 5]))
                                <th>Debt Name</th>
                            @endif
                            @if (in_array($jenisuang->id, [1, 2]))
                                <th>Category</th>
                            @endif
                            <th>Pocket</th>
                            @if ($jenisuang->id == 3)
                                <th>Pocket Destination</th>
                            @endif
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                                @if ($jenisuang->id == 4)
                                    <td>{{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                                    </td>
                                @endif
                                @if ($jenisuang->id == 5)
                                    <td>{{ Str::limit($transaction->utangteman->keterangan, 15, $end = '...') ?? $transaction->utangteman->nama }}
                                    </td>
                                @endif
                                @if ($jenisuang->id == 1)
                                    <td>{{ $transaction->category_masuk->nama }}</td>
                                @endif
                                @if ($jenisuang->id == 2)
                                    <td>{{ $transaction->category->nama }}</td>
                                @endif
                                <td>{{ isset($transaction->rekening) ? $transaction->rekening->nama_akun : 'Pocket deleted' }}
                                </td>
                                @if ($jenisuang->id == 3)
                                    <td>{{ isset($transaction->rekening_tujuan) ? $transaction->rekening_tujuan->nama_akun : 'Pocket deleted' }}
                                    </td>
                                @endif
                                <td>{{ Str::limit($transaction->keterangan, 15, $end = '...') ?? '-' }}</td>
                                <td>{{ $transaction->created_at->format('l j F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Records Empty</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
