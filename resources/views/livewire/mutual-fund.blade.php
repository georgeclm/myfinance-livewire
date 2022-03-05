@section('title', 'Mutual Fund - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Mutual Funds</h1>
        @if (is_null(auth()->user()->previous_reksadana))
            <button onclick="showModal('editmodalEmergency')"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i>
                Previous Earning?</button>
        @endif
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <a href="javascript:void(0)" onclick="create()"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Mutual Fund</a>
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
    <div class="row card-body small-when-0  px-2 ml-0">
        <div class="col-xl-8 col-lg-7 small-when-0">
            @forelse ($mutual_funds as $mutual_fund)
                {{-- @livewire('investasi.mutualfund.topup',['mutual_fund' => $mutual_fund])
            @livewire('investasi.mutualfund.change',['mutual_fund' => $mutual_fund])
            @livewire('investasi.mutualfund.jual',['mutual_fund' => $mutual_fund]) --}}
                <div class="bg-dark border-0 card shadow mb-4">
                    <div
                        class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $mutual_fund->nama_reksadana }} - Rp.
                            {{ number_format($mutual_fund->total, 0, ',', '.') }}
                        </h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle only-big" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <a class="this_small" href="#" data-toggle="modal"
                                data-target="#exampleModal-{{ $mutual_fund->id }}">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <button class="dropdown-item text-white"
                                    wire:click="topUpModal({{ $mutual_fund->id }})">Buy More</button>
                                <button class="dropdown-item text-white"
                                    wire:click="changeModal({{ $mutual_fund->id }})">Change Goal</button>
                                <button class="dropdown-item text-white"
                                    wire:click="sellModal({{ $mutual_fund->id }})">Sell</button>
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
                <div class="modal custom fade" id="exampleModal-{{ $mutual_fund->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="bg-black modal-content">
                            <div class="modal-body p-0">
                                <ul class="list-group p-0">
                                    <a href="javascript:void(0)" data-dismiss="modal"
                                        wire:click="topUpModal({{ $mutual_fund->id }})"
                                        class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                        <div class="w-100 text-white">
                                            <i class="fas fa-plus text-white mx-2"></i>Buy More
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" data-dismiss="modal"
                                        wire:click="changeModal({{ $mutual_fund->id }})"
                                        class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                        <div class="w-100 text-white">
                                            <i class="fas fa-sliders-h text-white mx-2"></i>Change Goal
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" wire:click="sellModal({{ $mutual_fund->id }})"
                                        data-dismiss="modal"
                                        class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                        <div class="w-100 text-white">
                                            <i class="fas fa-minus text-white mx-2"></i>Sell
                                        </div>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                @livewire('partials.no-data', ['message' => 'Start Add Mutual Fund to Your Asset'])
            @endforelse
        </div>
        <div wire.ignore class="col-xl-4 col-lg-5 small-when-0">
            <div class="bg-dark card shadow mb-4 border-0">
                <!-- Card Header - Dropdown -->
                <div class="bg-gray-100 card-header py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Mutual Fund Allocation</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie my-4">
                        <canvas id="myPieChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="editModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Buy More Mutual Fund</h5>
                <button onclick="closeModal('editModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <form id="formtopupModal" wire:submit.prevent="topUp">
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user"
                            wire:model="form.nama_reksadana" placeholder="mutual_fund Code" disabled>
                    </div>
                    {{-- <div class="mb-3 hide-inputbtns input-group">
                                <input type="number" class="border-0 form-control form-control-user"
                                    wire:model.defer="form.unit" placeholder="Total" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">unit</span>
                                </div>
                            </div> --}}
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.harga_beli" type-currency="IDR" inputmode="numeric" type="text"
                            name="buyprice" required placeholder="Buy Price (NAV)"
                            class="border-0 form-control form-control-user ">
                        <div class="input-group-append">
                            <span class="input-group-text">Per Unit</span>
                        </div>

                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="total" required placeholder="Purchase Amount" inputmode="numeric"
                            type-currency="IDR" wire:model.defer="form.total"
                            class="border-0 form-control form-control-user @error('form.total') is-invalid @enderror">
                        @error('form.total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="form.rekening_id"
                            class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                            style="padding: 0.5rem !important">
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">
                                    {{ $rekening->nama_akun }} - Rp.
                                    {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('form.rekening_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="form.financial_plan_id"
                            class="border-0 form-control form-control-user form-block @error('financial_plan_id') is-invalid @enderror"
                            style="padding: 0.5rem !important" name="financial_plan_id" disabled>
                            @foreach (auth()->user()->financialplans as $financialplan)
                                <option value="{{ $financialplan->id }}"
                                    @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>
                                    {{ $financialplan->nama }} - Rp.
                                    {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                            @endforeach
                            @error('financial_plan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </select>

                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.keterangan"
                            class="border-0 form-control form-control-user" disabled placeholder="Description">
                    </div>
                </form>
                <b> Unit Estimation</b>
                <span class="float-right"> <span id="myText"></span> Unit</span>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formtopupModal" value="Update" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore id="adjustModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Change Mutual Fund Goal</h5>
                <button onclick="closeModal('adjustModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formchangeModal" wire:submit.prevent="change">
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user"
                            wire:model="form.nama_reksadana" placeholder="mutual_fund Code" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" class="border-0 form-control form-control-user" disabled
                            wire:model="form.unit" placeholder="Total" required>
                        <div class="input-group-append">
                            <span class="input-group-text">unit</span>
                        </div>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model="form.harga_beli" type-currency="IDR" inputmode="numeric" type="text" required
                            placeholder="Buy Price (NAV)" class="border-0 form-control form-control-user " disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">Per Unit</span>
                        </div>

                    </div>
                    <div class="form-group">
                        <select wire:model="form.rekening_id"
                            class="border-0 form-control form-control-user form-block"
                            style="padding: 0.5rem !important" disabled>
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">
                                    {{ $rekening->nama_akun }} - Rp.
                                    {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select wire:model="form.financial_plan_id"
                            class="border-0 form-control form-control-user form-block @error('financial_plan_id') is-invalid @enderror"
                            style="padding: 0.5rem !important" name="financial_plan_id">
                            @foreach (auth()->user()->financialplans as $financialplan)
                                <option value="{{ $financialplan->id }}"
                                    @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>
                                    {{ $financialplan->nama }} - Rp.
                                    {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                            @endforeach
                            @error('financial_plan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </select>

                    </div>
                    <div class="form-group">
                        <input type="text" wire:model="form.keterangan" class="border-0 form-control form-control-user"
                            disabled placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formchangeModal" value="Update" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="deleteModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Sell Mutual Fund</h5>
                <button onclick="closeModal('deleteModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formjualModal" wire:submit.prevent="sell">
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user "
                            wire:model="form.nama_reksadana" placeholder="Mutual Fund Name" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number"
                            class="border-0 form-control form-control-user @error('form.unit') is-invalid @enderror"
                            wire:model.defer="form.unit" step="any" placeholder="Total" required>
                        <div class="input-group-append">
                            <span class="input-group-text">unit</span>
                        </div>
                        @error('form.unit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.harga_beli" type-currency="IDR" inputmode="numeric" type="text"
                            required placeholder="Sell Price (NAV)" class="border-0 form-control form-control-user ">
                        <div class="input-group-append">
                            <span class="input-group-text">Per Unit</span>
                        </div>

                    </div>
                    <div class="form-group">
                        <select wire:model.defer="form.rekening_id"
                            class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                            style="padding: 0.5rem !important">
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">
                                    {{ $rekening->nama_akun }} - Rp.
                                    {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('form.rekening_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="form.financial_plan_id"
                            class="border-0 form-control form-control-user form-block @error('form.financial_plan_id') is-invalid @enderror"
                            style="padding: 0.5rem !important" name="financial_plan_id" disabled>
                            @foreach (auth()->user()->financialplans as $financialplan)
                                <option value="{{ $financialplan->id }}"
                                    @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>
                                    {{ $financialplan->nama }} - Rp.
                                    {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                            @endforeach
                            @error('form.financial_plan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </select>

                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.keterangan"
                            class="border-0 form-control form-control-user" disabled placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-block btn-primary" form="formjualModal" value="Sell" />
            </div>
        </div>
    </div>

    @livewire('investasi.mutualfund.create-mutual-fund')
    @livewire('investasi.mutualfund.previous')
    <br><br><br><br><br><br><br>
</div>
@section('script')
    <script src="{{ asset('js/chart.js/Chart.min.js') }}" data-turbolinks-track="true"></script>
    <script>
        function create() {
            showModal('new-pocket');
            unitcalculate('Rp. 0');
        }

        run();
        var unit = 0;
        var total = 0;
        var buyprice = 0;
        var unitCreate = 0;
        var totalCreate = 0;
        var buypriceCreate = 0;
        Livewire.on('refresh-count', price => {
            unitcalculate(price);
        });


        function unitcalculate(price) {
            buyprice = price.replace(/[^0-9]+/g, '');
            count();
            $('input[name=total]').on('input', function(e) {
                total = $('input[name=total]').val().replace(/[^0-9]+/g, '');
                count();
            });
            $('input[name=buyprice]').on('input', function(e) {
                buyprice = $('input[name=buyprice]').val().replace(/[^0-9]+/g, '');
                count();
            });
            $('input[name=totalCreate]').on('input', function(e) {
                totalCreate = $('input[name=totalCreate]').val().replace(/[^0-9]+/g, '');
                count();
            });
            $('input[name=buypriceCreate]').on('input', function(e) {
                buypriceCreate = $('input[name=buypriceCreate]').val().replace(/[^0-9]+/g, '');
                count();
            });
        }

        function count() {
            if (!isNaN(total) && !isNaN(buyprice)) {
                unit = total / buyprice;
                document.getElementById("myText").innerHTML = unit.toFixed(4);
            }
            if (!isNaN(totalCreate) && !isNaN(buypriceCreate)) {
                unitCreate = totalCreate / buypriceCreate;
                document.getElementById("Create").innerHTML = unitCreate.toFixed(4);
            }
        }
        unitcalculate('Rp. 0');

        function refreshChart() {
            var ctx = document.getElementById("myPieChart");
            var dynamicColors = function() {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
            };
            var label_name = [];
            var data_mutual_fund = [];
            var coloR = [];
            var border = [];
            @foreach ($mutual_funds as $mutual_fund)
                coloR.push(dynamicColors());
                label_name.push("{{ $mutual_fund->nama_reksadana }}");
                data_mutual_fund.push("{{ round(($mutual_fund->total * 100) / Auth::user()->total_mutual_funds->sum('total')) }}");
                border.push(0);
            @endforeach

            var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: label_name,
                    datasets: [{
                        data: data_mutual_fund,
                        backgroundColor: coloR,
                        borderWidth: border
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                    cutoutPercentage: 80,
                },
            });
        }
        refreshChart();
    </script>
@endsection
