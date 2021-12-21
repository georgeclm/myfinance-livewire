@section('title', 'Financial Plan - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Financial Plan</h1>
    </div>
    <div class="row mobile">
        <div class="col-lg-6 small-when-0">
            <!-- Dropdown Card Example -->
            <div class="bg-dark border-0 card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Add</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <ul class="list-group">
                        <button onclick="showModal('modalEmergency')"
                            class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                            <div class="w-100 text-white">
                                <i class="fas fa-exclamation-circle text-warning mx-2"></i>Emergency
                                Fund
                            </div>
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button onclick="showModal('modalFund')"
                            class="list-group-item list-group-item-action bg-black d-flex align-items-center">
                            <div class="w-100 text-white">
                                <i class="fas fa-shopping-basket text-warning mx-2"></i>Fund for
                                Stuff
                            </div>
                            <i class="fas fa-angle-right"></i>

                        </button>
                        {{-- <a href="#"
                                            class="list-group-item list-group-item-action bg-black d-flex align-items-center">
                                            <div class="w-100 text-white">
                                                <i class="fas fa-umbrella-beach text-success mx-2"></i>Dana Liburan
                                            </div>
                                        </a> --}}
                        <button onclick="showModal('modalSaving')"
                            class="list-group-item list-group-item-action bg-black d-flex align-items-center">
                            <div class="w-100 text-white">
                                <i class="fas fa-piggy-bank text-primary mx-2"></i>Savings Fund
                            </div>
                            <i class="fas fa-angle-right"></i>

                        </button>
                    </ul>
                </div>
            </div>
            <!-- Project Card Example -->
            <div class="bg-dark card shadow mb-4 border-0">
                <div class="bg-gray-100 card-header py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Realised</h6>
                </div>
                <div class="card-body p-2 bg-success ">
                    @forelse (auth()->user()->financialplans as $financialplan)
                        @if ($financialplan->jumlah >= $financialplan->target)
                            <div class="pt-4 rounded mb-3">
                                <div class="text-center font-weight-bold text-white">
                                    {{ $financialplan->produk }}
                                </div>
                                <h4 class="small font-weight-bold text-white">
                                    {{ $financialplan->nama }}
                                    <span class="float-right">
                                        <div class="dropdown ml-2">
                                            <button class="btn btn-secondary only-big" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <a class="this_small" href="javascript:void(0)" data-toggle="modal"
                                                data-target="#done-{{ $financialplan->id }}">
                                                <i class="fas fa-ellipsis-v fa-fw text-gray-400"></i>
                                            </a>
                                            <div class=" bg-dark border-0  dropdown-menu"
                                                aria-labelledby="dropdownMenuButton">
                                                <button wire:click="editModal({{ $financialplan->id }})"
                                                    class="dropdown-item text-white">Adjust</button>
                                                {{-- <a class="dropdown-item text-white" href="#">Detail
                                                                </a> --}}
                                                {{-- <a data-toggle="modal"
                                                                    data-target="#deletemodal-{{ $financialplan->id }}"
                                                                    class="dropdown-item text-white" href="#">Hapus</a> --}}
                                            </div>
                                        </div>
                                    </span>
                                </h4>
                                <div class="progress mb-1">
                                    <div role="progressbar" style="width: {{ $financialplan->persen() }}%"
                                        aria-valuenow="{{ $financialplan->persen() }}" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar bg-primary">
                                    </div>
                                </div>
                                <h4 class="small font-weight-bold text-white">Rp.
                                    {{ number_format($financialplan->jumlah, 0, ',', '.') }}<span
                                        class="float-right">Rp.
                                        {{ number_format($financialplan->target, 0, ',', '.') }}</span>
                                </h4>
                                <div class="text-center  font-weight-bold text-white"> Rp.
                                    {{ number_format($financialplan->perbulan, 0, ',', '.') }} /Month
                                </div>
                            </div>
                            <div class="modal custom fade" id="done-{{ $financialplan->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="bg-black modal-content">
                                        <div class="modal-body p-0">
                                            <ul class="list-group p-0">
                                                <a href="javascript:void(0)" data-dismiss="modal"
                                                    wire:click="editModal({{ $financialplan->id }})"
                                                    class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                                    <div class="w-100 text-white">
                                                        <i class="fas fa-edit text-white mx-2"></i>Edit
                                                    </div>
                                                </a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr style="border-color: white !important" class="my-0">
                            @endif
                        @endif
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-6 small-when-0  mb-4">
            <!-- Project Card Example -->
            <div class="bg-dark card shadow mb-4 border-0">
                <div class="bg-gray-100 card-header py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-danger">In Progress</h6>
                </div>
                <div class="card-body p-2">
                    @forelse (auth()->user()->financialplans as $financialplan)
                        {{-- @livewire($financialplan->edit(),['financialplan'=> $financialplan]) --}}
                        @if ($financialplan->jumlah < $financialplan->target)
                            {{-- @include('financialplan.delete') --}}
                            <div class="pt-4 rounded mb-3">
                                <div class="text-center font-weight-bold text-white">
                                    {{ $financialplan->produk }}
                                </div>
                                <h4 class="small font-weight-bold text-white">
                                    {{ $financialplan->nama }}
                                    <span class="float-right">
                                        <div class="dropdown ml-2">
                                            <button class="btn btn-secondary only-big" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <a class="this_small" href="#" data-toggle="modal"
                                                data-target="#notdone-{{ $financialplan->id }}">
                                                <i class="fas fa-ellipsis-v fa-fw text-gray-400"></i>
                                            </a>
                                            <div class=" bg-dark border-0  dropdown-menu"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-white"
                                                    href="{{ route('investasi') }}">Invest</a>
                                                <button wire:click="editModal({{ $financialplan->id }})"
                                                    class="dropdown-item text-white">Adjust</button>
                                                {{-- <a class="dropdown-item text-white" href="#">Detail
                                                                </a> --}}
                                                @if ($financialplan->jumlah == 0)
                                                    <button class="dropdown-item text-white"
                                                        wire:click="deleteModal({{ $financialplan->id }})">Delete</button>
                                                @endif
                                            </div>
                                        </div>
                                    </span>
                                </h4>
                                <div class="progress mb-1">
                                    <div role="progressbar" style="width: {{ $financialplan->persen() }}%"
                                        aria-valuenow="{{ $financialplan->persen() }}" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar bg-primary">
                                    </div>
                                </div>
                                <h4 class="small font-weight-bold text-white">Rp.
                                    {{ number_format($financialplan->jumlah, 0, ',', '.') }}<span
                                        class="float-right">Rp.
                                        {{ number_format($financialplan->target, 0, ',', '.') }}</span>
                                </h4>
                                <div class="text-center  font-weight-bold text-white"> Rp.
                                    {{ number_format($financialplan->perbulan, 0, ',', '.') }} /Month
                                </div>
                            </div>
                            <div class="modal custom fade" id="notdone-{{ $financialplan->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="bg-black modal-content">
                                        <div class="modal-body p-0">
                                            <ul class="list-group p-0">
                                                <a href="javascript:void(0)" data-dismiss="modal"
                                                    wire:click="editModal({{ $financialplan->id }})"
                                                    class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                                    <div class="w-100 text-white">
                                                        <i class="fas fa-edit text-white mx-2"></i>Edit
                                                    </div>
                                                </a>
                                                <a href="{{ route('investasi') }}"
                                                    class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                                    <div class="w-100 text-white">
                                                        <i class="fas fa-chart-bar text-white mx-2"></i>Invest
                                                    </div>
                                                </a>
                                                @if ($financialplan->jumlah == 0)
                                                    <a href="javascript:void(0)" data-dismiss="modal"
                                                        wire:click="deleteModal({{ $financialplan->id }})"
                                                        class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                                                        <div class="w-100 text-white">
                                                            <i class="fas fa-trash text-white mx-2"></i>Delete
                                                        </div>
                                                    </a>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr style="border-color: white !important" class="my-0">
                            @endif
                        @endif
                    @empty
                        <div class="bg-black p-4 rounded mb-3">
                            <div class="text-center font-weight-bold text-white">
                                Create Financial Plan
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="editmodalEmergency">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Emergency Fund</h5>
                <button onclick="closeModal('editmodalEmergency')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditmodalEmergency" wire:submit.prevent="update">
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type-currency="IDR" inputmode="numeric" type="text" name="jumlah"
                            wire:model.defer="emergency.jumlah" required
                            class="border-0 form-control form-control-user @error('emergency.jumlah') is-invalid @enderror">
                        @error('emergency.jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="emergency.status_pernikahan"
                            class="border-0 form-control form-control-user form-block @error('emergency.status_pernikahan') is-invalid @enderror"
                            style="padding: 0.5rem !important" required>
                            <option value="1">Single</option>
                            <option value="2">Married</option>
                            <option value="3">Married with children</option>
                        </select>
                        @error('emergency.status_pernikahan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-block btn-primary" form="formeditmodalEmergency" value="Update" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="editmodalSaving">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Regular Savings Fund</h5>
                <button onclick="closeModal('editmodalSaving')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditmodalSaving" wire:submit.prevent="update">
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="target" type-currency="IDR" inputmode="numeric" required
                            wire:model.defer="saving.target" placeholder="Starting Funds"
                            class="border-0 form-control form-control-user @error('saving.target') is-invalid @enderror">
                        @error('saving.target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="jumlah" type-currency="IDR" inputmode="numeric"
                            wire:model.defer="saving.jumlah" required placeholder="Amount to invest each month"
                            class="border-0 form-control form-control-user @error('saving.jumlah') is-invalid @enderror">
                        @error('saving.jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" maxlength="2"
                            class="border-0 form-control form-control-user @error('saving.bulan') is-invalid @enderror"
                            wire:model.defer="saving.bulan" name="bulan" placeholder="How long?" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">months</span>
                        </div>
                        @error('saving.bulan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formeditmodalSaving" value="Update" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="editmodalFund">
        <div class="bg-black modal__content">

            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Fund For Stuff</h5>
                <button onclick="closeModal('editmodalFund')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditmodalFund" wire:submit.prevent="update">
                    <div class="form-group">
                        <input type="text"
                            class="border-0 form-control form-control-user @error('fund.nama') is-invalid @enderror"
                            name="nama" wire:model.defer="fund.nama" placeholder="Stuff Name" required>
                        @error('fund.nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="target" type-currency="IDR" inputmode="numeric"
                            wire:model.defer="fund.target" required placeholder="Stuff Price"
                            class="border-0 form-control form-control-user @error('fund.target') is-invalid @enderror">
                        @error('fund.target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" wire:model.defer="fund.bulan"
                            class="border-0 form-control form-control-user @error('fund.bulan') is-invalid @enderror"
                            name="bulan" placeholder="How long?" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">months</span>
                        </div>
                        @error('fund.bulan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="jumlah" type-currency="IDR" inputmode="numeric"
                            wire:model.defer="fund.jumlah" required placeholder="Fund Avalible Now"
                            class="border-0 form-control form-control-user @error('fund.jumlah') is-invalid @enderror">
                        @error('fund.jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formeditmodalFund" value="Update" />
            </div>
        </div>
    </div>
    <div class="modal__container" wire:ignore.self id="deleteModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white" id="exampleModalLabel">Delete {{ $name }}?</h5>
                <button class="close text-white" type="button" onclick="closeModal('deleteModal')">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-white">Select "Delete" below if you are ready to delete this Financial Plan,
                this
                action cannot
                be undone </div>
            <div class="modal-footer border-0">
                <a class="btn btn-danger btn-block" href="javascript:void(0)" wire:click="delete">Delete</a>
            </div>
        </div>
    </div>
    @livewire('financialplan.create-dana-darurat')
    @livewire('financialplan.create-dana-menabung')
    @livewire('financialplan.create-dana-membeli-barang')

    <br><br><br><br><br><br><br>
</div>
@section('script')
    <script>
        run();
    </script>
@endsection
