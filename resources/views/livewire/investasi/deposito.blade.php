@section('title', 'Deposito - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Deposito</h1>
        @if (is_null(auth()->user()->previous_deposito))
            <button onclick="showModal('modalFund')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i>
                Previous Earning?</button>
        @endif
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <button onclick="showModal('new-pocket')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Deposito</button>
        @endif
    </div>
    <div class="row px-2 ml-0">
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Deposito</div>
                            <div class="h7 mb-0 font-weight-bold text-success">Rp.
                                {{ number_format(Auth::user()->total_depositos(), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fab fa-cc-amazon-pay fa-2x text-success"></i>
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
                                {{ number_format(Auth::user()->total_depositos_gain_or_loss(), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-primary"></i>
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
        @forelse (auth()->user()->depositos as $deposito)
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $deposito->nama_deposito }} - Rp.
                        {{ number_format($deposito->harga_jual, 0, ',', '.') }}
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <button class="dropdown-item text-white"
                                wire:click="changeModal({{ $deposito->id }})">Change Goal</button>
                            <button class="dropdown-item text-white"
                                wire:click="editModal({{ $deposito->id }})">Sell</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body text-white">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            Amount : Rp. {{ number_format($deposito->jumlah, 0, ',', '.') }}<br />
                            {{ $deposito->jatuh_tempo->diffForHumans() }}
                        </div>
                        {{ number_format($deposito->bunga, 1, ',', '.') }} %
                    </div>
                </div>
            </div>
        @empty
            @livewire('partials.no-data', ['message' => 'Start Add Deposito to Your Asset'])
        @endforelse
    </div>
    <div class="modal__container" wire:ignore.self id="editModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Sell Deposito</h5>
                <button onclick="closeModal('editModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditModal" wire:submit.prevent="sell">
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.nama_bank"
                            class="border-0 form-control form-control-user " name="nama_bank" placeholder="Bank Name"
                            disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.nama_deposito"
                            class="border-0 form-control form-control-user " name="nama_deposito"
                            placeholder="Deposito Name" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" class="border-0 form-control form-control-user " name="bunga"
                            placeholder="Interest" wire:model.defer="form.bunga" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model="form.harga_jual" type-currency="IDR" inputmode="numeric" type="text"
                            name="harga_jual" required placeholder=" Expected Maturity Amount"
                            class="border-0  form-control form-control-user ">
                    </div>
                    <div class="form-group">
                        <input wire:model="form.jatuh_tempo" disabled
                            onchange="this.dispatchEvent(new InputEvent('input'))" class="border-0 form-control"
                            type="text" name="jatuh_tempo" />
                    </div>
                    <div class="form-group">
                        <select
                            class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                            wire:model="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                            required>
                            <option value="" selected disabled hidden>From Pocket</option>
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }} - Rp.
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
                        <select class="border-0 form-control form-control-user form-block" disabled
                            wire:model="form.financial_plan_id" name="financial_plan_id"
                            style="padding: 0.5rem !important" required>
                            <option value="" selected disabled hidden>Invest Goal</option>
                            @foreach (auth()->user()->financialplans as $financialplan)
                                <option value="{{ $financialplan->id }}" @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>
                                    {{ $financialplan->nama }} - Rp.
                                    {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " disabled
                            wire:model="form.keterangan" name="keterangan" placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formeditModal" value="Sell" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="adjustModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Change Deposito Goal</h5>
                <button onclick="closeModal('adjustModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formadjustModal" wire:submit.prevent="change">
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.nama_bank"
                            class="border-0 form-control form-control-user " name="nama_bank" placeholder="Bank Name"
                            disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.nama_deposito"
                            class="border-0 form-control form-control-user " name="nama_deposito"
                            placeholder="Deposito Name" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" class="border-0 form-control form-control-user " name="bunga"
                            placeholder="Interest" wire:model.defer="form.bunga" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.jumlah" type-currency="IDR" inputmode="numeric" disabled
                            type="text" name="jumlah" required placeholder="Amount"
                            class=" border-0 form-control form-control-user ">
                    </div>
                    <div class="form-group">
                        <input wire:model.defer="form.jatuh_tempo" disabled
                            onchange="this.dispatchEvent(new InputEvent('input'))" class="border-0 form-control"
                            type="text" name="jatuh_tempo" />
                    </div>
                    <div class="form-group">
                        <select class="border-0 form-control form-control-user form-block " disabled
                            wire:model.defer="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                            required>
                            <option value="" selected disabled hidden>From Pocket</option>
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }} - Rp.
                                    {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="border-0 form-control form-control-user form-block"
                            wire:model.defer="form.financial_plan_id" name="financial_plan_id"
                            style="padding: 0.5rem !important" required>
                            <option value="" selected disabled hidden>Invest Goal</option>
                            @foreach (auth()->user()->financialplans as $financialplan)
                                <option value="{{ $financialplan->id }}" @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>
                                    {{ $financialplan->nama }} - Rp.
                                    {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " disabled
                            wire:model.defer="form.keterangan" name="keterangan" placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formadjustModal" value="Change" />
            </div>
        </div>
    </div>

    @livewire('investasi.deposito.create')
    @livewire('investasi.deposito.previous')
    <br><br><br><br><br><br><br><br><br>
</div>
