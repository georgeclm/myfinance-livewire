@section('title', 'Stocks - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Stock</h1>
        @if (is_null(auth()->user()->previous_stock))
            <button onclick="showModal('modalFund')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i>
                Previous Earning?</button>
        @endif
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <button onclick="showModal('new-pocket')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
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
        @if ($unrealized != 0 && !$errorAPI)
            <div class="small-when-0 col-xl-3 col-md-6 mb-4">
                <div
                    class="bg-gray-100 border-0 card @if ($gain) border-left-success @else border-left-danger @endif  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold @if ($gain) text-success @else text-danger @endif text-uppercase mb-1">
                                    Unrealized @if ($gain)
                                        Gain
                                    @else
                                        Loss
                                    @endif
                                </div>
                                <div
                                    class="h7 mb-0 font-weight-bold @if ($gain) text-success @else text-danger @endif">
                                    Rp.
                                    {{ number_format($unrealized, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="fas fa-chart-line fa-2x @if ($gain) text-success @else text-danger @endif"></i>
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
    <div class="row card-body small-when-0  px-2 ml-0 ">
        <div class="col-xl-8 col-lg-7 small-when-0">
            @forelse ($stocks as  $stock)
                <div class="bg-dark border-0 card shadow mb-4">
                    <div
                        class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $stock->kode }} - Rp.
                            {{ number_format($stock->total, 0, ',', '.') }}
                            @if (!$errorAPI)
                                <span
                                    class="badge @if ($stockPrice[$stock->kode] >= $stock->harga_beli) badge-success @else badge-danger @endif">
                                    @if ($stockPrice[$stock->kode] > $stock->harga_beli)
                                        +
                                    @endif
                                    {{ round((($stockPrice[$stock->kode] - $stock->harga_beli) / $stock->harga_beli) * 100, 2) }}
                                    %
                                </span>
                            @endif
                        </h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle only-big" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <a class="this_small" href="#" data-toggle="modal"
                                data-target="#exampleModal-{{ $stock->id }}">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <button class="dropdown-item text-white"
                                    wire:click="topupModal({{ $stock->id }})">Buy
                                    More</button>
                                @if ($stock->financial_plan_id != 0)
                                    <button class="dropdown-item text-white"
                                        wire:click="adjustModal({{ $stock->id }})">Change
                                        Goal</button>
                                @endif
                                <button class="dropdown-item text-white"
                                    wire:click="sellModal({{ $stock->id }})">Sell</button>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body text-white">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                Avg Price: Rp. {{ number_format($stock->harga_beli, 0, ',', '.') }} per-Lembar
                                <br>
                                @if (!$errorAPI)
                                    @if ($stockPrice[$stock->kode] != 0)
                                        Current Price: Rp.
                                        {{ number_format($stockPrice[$stock->kode], 0, ',', '.') }} per-Lembar
                                    @endif
                                @endif
                            </div>
                            {{ $stock->lot }} Lot
                        </div>
                    </div>
                </div>
                <div class="modal custom fade" id="exampleModal-{{ $stock->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="bg-black modal-content">
                            <div class="modal-body p-0">
                                <ul class="list-group p-0">
                                    <a href="javascript:void(0)" data-dismiss="modal"
                                        wire:click="topupModal({{ $stock->id }})"
                                        class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                        <div class="w-100 text-white">
                                            <i class="fas fa-plus text-white mx-2"></i>Buy More
                                        </div>
                                    </a>
                                    @if ($stock->financial_plan_id != 0)
                                        <a href="javascript:void(0)" data-dismiss="modal"
                                            wire:click="adjustModal({{ $stock->id }})"
                                            class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                            <div class="w-100 text-white">
                                                <i class="fas fa-sliders-h text-white mx-2"></i>Change Goal
                                            </div>
                                        </a>
                                    @endif
                                    <a href="javascript:void(0)" wire:click="sellModal({{ $stock->id }})"
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
                @livewire('partials.no-data', ['message' => 'Start Add Stock to Your Asset'])
            @endforelse
        </div>
        <div class="col-xl-4 col-lg-5 small-when-0">
            <div class="bg-dark card shadow mb-4 border-0">
                <!-- Card Header - Dropdown -->
                <div class="bg-gray-100 card-header py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Stock Allocation</h6>
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
                <h5 class="modal-title text-white">Buy More Stock</h5>
                <button onclick="closeModal('editModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditModal" wire:submit.prevent="topup">
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user" wire:model="form.kode"
                            placeholder="Stock Code" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" class="border-0 form-control form-control-user" wire:model.defer="form.lot"
                            placeholder="Total" required>
                        <div class="input-group-append">
                            <span class="input-group-text">lot</span>
                        </div>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.harga_beli" type-currency="IDR" inputmode="numeric" type="text"
                            required placeholder="Buy Price" class="border-0 form-control form-control-user ">
                        <div class="input-group-append">
                            <span class="input-group-text">Per Lembar</span>
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
                            class="border-0 form-control form-control-user form-block @error('financial_plan_id') is-invalid @enderror"
                            style="padding: 0.5rem !important" name="financial_plan_id" disabled>
                            <option value="0">Trading</option>

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
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formeditModal" value="Buy" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="deleteModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Sell Stock</h5>
                <button onclick="closeModal('deleteModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formdeleteModal" wire:submit.prevent="sell">
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " wire:model="form.kode"
                            placeholder="Stock Code" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number"
                            class="border-0 form-control form-control-user @error('form.lot') is-invalid @enderror"
                            wire:model.defer="form.lot" placeholder="Total" required>
                        <div class="input-group-append">
                            <span class="input-group-text">lot</span>
                        </div>
                        @error('form.lot')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.harga_beli" type-currency="IDR" inputmode="numeric" type="text"
                            required placeholder="Sell Price" class="border-0 form-control form-control-user ">
                        <div class="input-group-append">
                            <span class="input-group-text">Per Lembar</span>
                        </div>

                    </div>
                    <div class="form-group">
                        <select wire:model.defer="form.rekening_id"
                            class="border-0 form-control form-control-user form-block"
                            style="padding: 0.5rem !important">
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">
                                    {{ $rekening->nama_akun }} - Rp.
                                    {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="form.financial_plan_id"
                            class="border-0 form-control form-control-user form-block @error('financial_plan_id') is-invalid @enderror"
                            style="padding: 0.5rem !important" name="financial_plan_id" disabled>
                            <option value="0">Trading</option>

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
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formdeleteModal" value="Sell" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore id="adjustModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Change Stock Goal</h5>
                <button onclick="closeModal('adjustModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formadjustModal" wire:submit.prevent="change">
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user" wire:model="form.kode"
                            placeholder="Stock Code" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" class="border-0 form-control form-control-user" disabled
                            wire:model="form.lot" placeholder="Total" required>
                        <div class="input-group-append">
                            <span class="input-group-text">lot</span>
                        </div>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model="form.harga_beli" type-currency="IDR" inputmode="numeric" type="text" required
                            placeholder="Buy Price" class="border-0 form-control form-control-user " disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">Per Lembar</span>
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
                <input type="submit" class="btn btn-primary btn-block" form="formadjustModal" value="Update" />
            </div>
        </div>
    </div>
    @livewire('investasi.stock.previous')
    @livewire('investasi.stock.create-stock',['stocks' => $stocks])
    <br><br><br><br><br><br><br>
</div>
