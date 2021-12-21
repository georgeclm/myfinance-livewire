@section('title', 'P2P - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Peer to Peer</h1>
        @if (is_null(auth()->user()->previous_p2p))
            <button onclick="showModal('modalFund')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i>
                Previous Earning?</button>
        @endif
        @if (auth()->user()->rekenings->isNotEmpty() &&
    auth()->user()->financialplans->isNotEmpty())
            <button onclick="showModal('new-pocket')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
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
            {{-- @livewire('investasi.p2p.change' , ['p2p' => $p2p])
            @livewire('investasi.p2p.sell', ['p2p' => $p2p]) --}}
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $p2p->nama_p2p }} - Rp.
                        {{ number_format($p2p->harga_jual, 0, ',', '.') }}
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle only-big" href="javascript:void(0)" role="button"
                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <a class="this_small" href="#" data-toggle="modal"
                            data-target="#exampleModal-{{ $p2p->id }}">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <button class="dropdown-item text-white"
                                wire:click="changeModal({{ $p2p->id }})">Change Goal</button>
                            <button class="dropdown-item text-white"
                                wire:click="sellModal({{ $p2p->id }})">Sell</button>
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
            <div class="modal custom fade" id="exampleModal-{{ $p2p->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-black modal-content">
                        <div class="modal-body p-0">
                            <ul class="list-group p-0">
                                <a href="javascript:void(0)" data-dismiss="modal"
                                    wire:click="changeModal({{ $p2p->id }})"
                                    class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                    <div class="w-100 text-white">
                                        <i class="fas fa-sliders-h text-white mx-2"></i>Change Goal
                                    </div>
                                </a>
                                <a href="javascript:void(0)" wire:click="sellModal({{ $p2p->id }})"
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
            @livewire('partials.no-data', ['message' => 'Start Add P2P to Your Asset'])
        @endforelse
    </div>
    <div class="modal__container" wire:ignore.self id="editModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Change P2P Goal</h5>
                <button onclick="closeModal('editModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditModal" wire:submit.prevent="change">
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.nama_p2p"
                            class="border-0 form-control form-control-user" disabled name="nama_p2p"
                            placeholder="P2P Name" required>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.jumlah" type-currency="IDR" inputmode="numeric" disabled
                            type="text" name="jumlah" required placeholder="Amount"
                            class=" border-0 form-control form-control-user ">
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.harga_jual" type-currency="IDR" inputmode="numeric" disabled
                            type="text" name="harga_jual" required placeholder=" Expected Maturity Amount"
                            class="border-0  form-control form-control-user ">
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
                <input type="submit" class="btn btn-primary btn-block" form="formeditModal" value="Update" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="deleteModal">
        <div class="bg-black modal__content">

            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Sell P2P</h5>
                <button onclick="closeModal('deleteModal')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formdeleteModal" wire:submit.prevent="sell">
                    <div class="form-group">
                        <input type="text" wire:model="form.nama_p2p" class="border-0 form-control form-control-user"
                            disabled name="nama_p2p" placeholder="P2P Name" required>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model="form.jumlah" type-currency="IDR" inputmode="numeric" disabled type="text"
                            name="jumlah" required placeholder="Amount"
                            class=" border-0 form-control form-control-user ">
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
                <input type="submit" class="btn btn-primary btn-block" form="formdeleteModal" value="Sell" />
            </div>
        </div>
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
