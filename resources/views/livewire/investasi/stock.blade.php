@section('title', 'Stocks - My Finance')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Stock</h1>
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <a href="#" data-toggle="modal" data-target="#stock"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Stock</a>
        @endif
    </div>
    <div class="row mobile">
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Stock</div>
                            <div class="h7 mb-0 font-weight-bold text-success">Rp.
                                {{ number_format(Auth::user()->total_stocks->sum('jumlah'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-bar fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Gain Or Loss</div>
                            <div class="h7 mb-0 font-weight-bold text-warning">Rp.
                                {{ number_format(Auth::user()->total_stocks_gain_or_loss(), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-area fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->rekenings->isEmpty() &&
    auth()->user()->financialplans->isEmpty())
        @livewire('partials.no-data', ['message' => 'Create Pocket and Financial Plan First to Start'])
    @endif
    <div class="card-body small-when-0 ">
        @forelse ($stocks as $stock)
            @livewire('investasi.stock.topup',['stock' => $stock])
            @livewire('investasi.stock.change',['stock' => $stock])
            @livewire('investasi.stock.jual',['stock' => $stock])
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $stock->kode }} - Rp.
                        {{ number_format($stock->total, 0, ',', '.') }}
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item text-white" data-toggle="modal"
                                data-target="#topup-{{ $stock->id }}" href="#">Buy More</a>
                            <a class="dropdown-item text-white" data-toggle="modal"
                                data-target="#change-{{ $stock->id }}" href="#">Change Goal</a>
                            <a class="dropdown-item text-white" data-toggle="modal"
                                data-target="#jual-{{ $stock->id }}" href="#">Sell</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body text-white">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            Avg Price: Rp. {{ number_format($stock->harga_beli, 0, ',', '.') }} per-Lembar
                        </div>
                        {{ $stock->lot }} Lot
                    </div>
                </div>
            </div>
        @empty
            @livewire('partials.no-data', ['message' => 'Start Add Stock to Your Asset'])
        @endforelse
    </div>
    @livewire('investasi.stock.create-stock')
</div>
