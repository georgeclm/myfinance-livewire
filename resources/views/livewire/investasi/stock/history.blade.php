@section('title', 'History - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Stock Transaction History</h1>
    </div>
    <div class="row px-2 ml-0">
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
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="@if ($stock->gain_or_loss > 0) text-success @else text-danger @endif bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold ">{{ $stock->kode }} -
                        Rp. @if ($stock->gain_or_loss > 0) +@endif{{ number_format($stock->gain_or_loss, 0, ',', '.') }}
                    </h6>
                    @if ($stock->gain_or_loss > 0) +@endif{{ round((($stock->harga_jual - $stock->harga_beli) / $stock->harga_beli) * 100, 2) }}
                    %
                </div>
                <!-- Card Body -->
                <div class="card-body text-white">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            Buy Price: Rp. {{ number_format($stock->harga_beli, 0, ',', '.') }}
                            <br><br>
                            Sell Price: Rp. {{ number_format($stock->harga_jual, 0, ',', '.') }}
                        </div>
                        {{ $stock->created_at->format('j M Y') }}
                        <br><br>
                        {{ $stock->deleted_at->format('j M Y') }}
                    </div>
                </div>
            </div>
        @empty
            @livewire('partials.no-data', ['message' => 'No History'])
        @endforelse
    </div>
    {{-- @livewire('investasi.stock.create-stock') --}}
    {{-- @livewire('investasi.stock.previous') --}}

</div>
