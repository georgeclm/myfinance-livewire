@section('title', 'P2P - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Peer to Peer</h1>
        @if (is_null(auth()->user()->previous_p2p))
            <button onclick="showModal('previous_p2p')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i>
                Previous Earning?</button>
        @endif
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <button onclick="showModal('p2p')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add P2P</button>
        @endif
    </div>
    <div class="row px-2 ml-0">
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total P2P</div>
                            <div class="h7 mb-0 font-weight-bold text-success">Rp.
                                {{ number_format(Auth::user()->total_p2ps(), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Earnings</div>
                            <div class="h7 mb-0 font-weight-bold text-primary">Rp.
                                {{ number_format(Auth::user()->total_p2p_gain_or_loss(), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-primary"></i>
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
    <div class="card-body small-when-0">
        @forelse (auth()->user()->p2ps as $p2p)
            @livewire('investasi.p2p.change' , ['p2p' => $p2p])
            @livewire('investasi.p2p.sell', ['p2p' => $p2p])
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $p2p->nama_p2p }} - Rp.
                        {{ number_format($p2p->harga_jual, 0, ',', '.') }}
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <button class="dropdown-item text-white"
                                onclick="showModal('change-{{ $p2p->id }}')">Change Goal</button>
                            <button class="dropdown-item text-white"
                                onclick="showModal('sell-{{ $p2p->id }}')">Sell</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body text-white">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            Amount : Rp. {{ number_format($p2p->jumlah, 0, ',', '.') }}<br />
                            {{ $p2p->jatuh_tempo->diffForHumans() }}
                        </div>
                        +{{ number_format($p2p->bunga, 1, ',', '.') }} %
                    </div>
                </div>
            </div>
        @empty
            @livewire('partials.no-data', ['message' => 'Start Add P2P to Your Asset'])
        @endforelse
    </div>
    @livewire('investasi.p2p.create')
    @livewire('investasi.p2p.previous')
    <br><br><br><br><br><br><br>

</div>
@section('script')
    <script>
        run();
        $(function() {
            $('input[name="jatuh_tempo"]').daterangepicker({
                singleDatePicker: true,
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " / ",
                },
            });
        });
    </script>
@endsection
