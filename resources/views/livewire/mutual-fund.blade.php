@section('title', 'Mutual Fund - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Mutual Funds</h1>
        @if (is_null(auth()->user()->previous_reksadana))
            <button onclick="showModal('previous_reksadana')"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i>
                Previous Earning?</button>
        @endif
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <button onclick="showModal('stock')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Mutual Fund</button>
        @endif
    </div>

    <div class="row px-2 ml-0">
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Mutual Funds</div>
                            <div class="h7 mb-0 font-weight-bold text-success">Rp.
                                {{ number_format(Auth::user()->total_mutual_funds->sum('total'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-funnel-dollar fa-2x text-success"></i>
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
                                {{ number_format(Auth::user()->total_mutual_fund_gain_or_loss(), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-warning"></i>
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
        @forelse ($mutual_funds as $mutual_fund)
            @livewire('investasi.mutualfund.topup',['mutual_fund' => $mutual_fund])
            @livewire('investasi.mutualfund.change',['mutual_fund' => $mutual_fund])
            @livewire('investasi.mutualfund.jual',['mutual_fund' => $mutual_fund])
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $mutual_fund->nama_reksadana }} - Rp.
                        {{ number_format($mutual_fund->total, 0, ',', '.') }}
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <button class="dropdown-item text-white"
                                onclick="showModal('topup-{{ $mutual_fund->id }}')">Buy More</button>
                            <button class="dropdown-item text-white"
                                onclick="showModal('change-{{ $mutual_fund->id }}')">Change Goal</button>
                            <button class="dropdown-item text-white"
                                onclick="showModal('jual-{{ $mutual_fund->id }}')">Sell</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body text-white">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            Avg Price: Rp. {{ number_format($mutual_fund->harga_beli, 0, ',', '.') }} per-Unit
                        </div>
                        {{ $mutual_fund->unit }} unit
                    </div>
                </div>
            </div>
        @empty
            @livewire('partials.no-data', ['message' => 'Start Add Mutual Fund to Your Asset'])
        @endforelse
    </div>
    @livewire('investasi.mutualfund.create-mutual-fund')
    @livewire('investasi.mutualfund.previous')
</div>
@section('script')
    <script>
        run();
        var unit = 0;
        var total = 0;
        var buyprice = 0;
        $('input[name=total]').on('input', function(e) {
            total = $('input[name=total]').val().replace(/[^0-9]+/g, '');
            count();
        });
        $('input[name=buyprice]').on('input', function(e) {
            buyprice = $('input[name=buyprice]').val().replace(/[^0-9]+/g, '');
            count();
        });

        function count() {
            if (!isNaN(total) && !isNaN(buyprice)) {
                unit = total / buyprice;
                document.getElementById("myText").innerHTML = unit.toFixed(4);
            }
        }
        @foreach ($mutual_funds as $mutual_fund)
            var unit = 0;
            var total = 0;
            var buyprice{{ $mutual_fund->id }} = {{ $mutual_fund->harga_beli }};
            $('input[name=total-{{ $mutual_fund->id }}]').on('input', function(e) {
            total = $('input[name=total-{{ $mutual_fund->id }}]').val().replace(
            /[^0-9]+/g, '');
            count{{ $mutual_fund->id }}();
            });
            $('input[name=buyprice-{{ $mutual_fund->id }}]').on('input', function(e) {
            buyprice{{ $mutual_fund->id }} = $('input[name=buyprice-{{ $mutual_fund->id }}]').val()
            .replace(/[^0-9]+/g, '');
            count{{ $mutual_fund->id }}();
            });

            function count{{ $mutual_fund->id }}() {
            if (!isNaN(total) && !isNaN(buyprice{{ $mutual_fund->id }})) {
            unit = total / buyprice{{ $mutual_fund->id }};
            document.getElementById("myText-{{ $mutual_fund->id }}").innerHTML = unit
            .toFixed(4);
            }
            }
        @endforeach
    </script>
@endsection
