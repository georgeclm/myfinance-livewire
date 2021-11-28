@section('title', 'Stocks - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Stock</h1>
        @if (is_null(auth()->user()->previous_stock))
            <button onclick="showModal('previous_stock')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i>
                Previous Earning?</button>
        @endif
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <button onclick="showModal('stock')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Stock</button>
        @endif
    </div>
    <div class="row px-2 ml-0">
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Stock</div>
                            <div class="h7 mb-0 font-weight-bold text-primary">Rp.
                                {{ number_format(Auth::user()->total_stocks->sum('total'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-bar fa-2x text-primary"></i>
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
        @if ($unrealized != 0)
            <div class="small-when-0 col-xl-3 col-md-6 mb-4">
                <div class="bg-gray-100 border-0 card @if ($gain) border-left-success @else border-left-danger @endif  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold @if ($gain) text-success @else text-danger @endif text-uppercase mb-1">
                                    Unrealized @if ($gain) Gain @else Loss @endif</div>
                                <div class="h7 mb-0 font-weight-bold @if ($gain) text-success @else text-danger @endif">Rp.
                                    {{ number_format($unrealized, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x @if ($gain) text-success @else text-danger @endif"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if (auth()->user()->rekenings->isEmpty() &&
    auth()->user()->financialplans->isEmpty())
        @livewire('partials.no-data', ['message' => 'Create Pocket and Financial Plan First to Start'])
    @endif
    <div class="card-body small-when-0 ">
        @forelse ($stocks as $key => $stock)
            @livewire('investasi.stock.topup',['stock' => $stock,'current' => $stockPrice[$key]])
            @livewire('investasi.stock.change',['stock' => $stock])
            @livewire('investasi.stock.jual',['stock' => $stock,'current' => $stockPrice[$key]])
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $stock->kode }} - Rp.
                        {{ number_format($stock->total, 0, ',', '.') }}
                        <span class="badge @if ($stockPrice[$key] >= $stock->harga_beli) badge-success @else badge-danger @endif">
                            @if ($stockPrice[$key] > $stock->harga_beli)
                                + @endif
                            {{ round((($stockPrice[$key] - $stock->harga_beli) / $stock->harga_beli) * 100, 2) }}
                            %
                        </span>
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <button class="dropdown-item text-white"
                                onclick="showModal('topup-{{ $stock->id }}')">Buy
                                More</button>
                            <button class="dropdown-item text-white"
                                onclick="showModal('change-{{ $stock->id }}')">Change
                                Goal</button>
                            <button class="dropdown-item text-white"
                                onclick="showModal('jual-{{ $stock->id }}')">Sell</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body text-white">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            Avg Price: Rp. {{ number_format($stock->harga_beli, 0, ',', '.') }} per-Lembar
                            <br>
                            @if ($stockPrice[$key] != 0)Current Price: Rp. {{ number_format($stockPrice[$key], 0, ',', '.') }} per-Lembar @endif

                        </div>
                        {{ $stock->lot }} Lot
                    </div>
                </div>
            </div>
        @empty
            @livewire('partials.no-data', ['message' => 'Start Add Stock to Your Asset'])
        @endforelse
    </div>
    <br><br><br><br><br><br><br>
    @livewire('investasi.stock.create-stock')
    @livewire('investasi.stock.previous')

</div>
