@section('title', 'Pockets - My Finance')
<div class="container-fluid small-when-0">
    @if (session()->has('success'))
        <script>
            new Notify({
                status: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 2,
                position: 'right top'
            })
        </script>
    @endif
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Pockets</h1>
        <button onclick="showModal('new-pocket')" class="d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i>
            Create Pocket</button>
    </div>

    <!-- Content Row -->
    <div class="row px-2 ml-0">
        @livewire('partials.totalbalance')
        @livewire('partials.balancewithasset')
    </div>

    @foreach ($jeniss as $jenis)

        <div class="bg-dark border-0 card shadow mb-4 small-when-0 ">
            <div class="bg-gray-100 border-0 card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $jenis->nama }}</h6>
            </div>
            <div id="preloader" wire:loading>
                <div id="loader"></div>
                <br><br><br>
            </div>
            <div class="card-body" wire:loading.remove>
                @forelse ($jenis->user_rekenings as $rekening)
                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a
                                href="{{ route('rekening.show', $rekening->id) }}">{{ $rekening->nama_akun }}</a>
                            - Rp.
                            {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}
                        </h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-caret-down"></i>
                                {{-- <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> --}}
                            </a>
                            <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                <a wire:click="editModal({{ $rekening->id }})" class="dropdown-item text-white"
                                    href="javascript:void(0)">Edit</a>
                                <a wire:click="deleteModal({{ $rekening->id }})" class="dropdown-item text-white"
                                    href="javascript:void(0)">Delete</a>
                                <a wire:click="adjustModal({{ $rekening->id }})" class="dropdown-item text-white"
                                    href="javascript:void(0)">Adjust</a>
                                <a class="dropdown-item text-white"
                                    href="{{ route('rekening.show', $rekening->id) }}">Mutation
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="text-white my-3 mx-0">
                        <div class="d-flex ">
                            <div class="flex-grow-1">
                                {{ Str::limit($rekening->keterangan, 15, $end = '...') ?? '-' }}
                            </div>
                            @if ($rekening->jenis_id != 1)
                                {{ $rekening->nama_bank }}
                            @endif
                        </div>
                    </div>
                    <hr class="bg-white my-1">
                @empty
                    <div class="text-center font-weight-bold text-white-50">
                        Empty
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
    <div class="mt-2 text-center">
        <a class="font-weight-bold text-primary" onclick="showModal('new-pocket')" href="javascript:void(0)">
            <i class="fas fa-plus-circle text-white-50"></i> Create New Pocket
        </a>
    </div>
    <div class="modal__container" wire:ignore.self id="editModal">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">
                    Update
                    Pocket
                </h5>
                <button class="close text-white" type="button" onclick="closeModal('editModal')">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editform" wire:submit.prevent="update">
                    <div class="form-group">
                        <select wire:model="form.jenis_id" class="border-0 form-control form-control-user form-block"
                            style="padding: 0.5rem !important" disabled>
                            @foreach ($jeniss as $jenis)
                                <option value="{{ $jenis->id }}">
                                    {{ $jenis->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " name="nama_akune"
                            wire:model.defer="form.nama_akun" required placeholder="Pocket Name">
                    </div>
                    @if ($editJenis != 1)
                        <div class="form-group">
                            <input type="text" class="border-0 form-control form-control-user " name="nama_banke"
                                wire:model.defer="form.nama_bank" readonly placeholder="Nama Bank">
                        </div>
                    @endif
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" type-currency="IDR" inputmode="numeric"
                            class="border-0 form-control form-control-user " wire:model.defer="form.saldo_sekarang"
                            readonly placeholder="Current Balance">
                    </div>
                    @if ($editJenis == 2)
                        <div class="mb-3 hide-inputbtns input-group">
                            <input type="text" type-currency="IDR" inputmode="numeric"
                                class="border-0 form-control form-control-user " wire:model.defer="form.saldo_mengendap"
                                name="saldo_mengendape" placeholder="Balance Settles">
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " name="keterangane"
                            wire:model.defer="form.keterangan" placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-block btn-primary" form="editform" value="Edit" />
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
            <div class="modal-body text-white">Select "Delete" below if you are ready to delete this pocket, this
                action cannot
                be undone </div>
            <div class="modal-footer border-0">
                <a class="btn btn-danger btn-block" href="javascript:void(0)" wire:click="delete">Delete</a>
            </div>
        </div>
    </div>
    <div class="modal__container" id="adjustModal" wire:ignore.self>
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">
                    Adjust Balance
                </h5>
                <button class="close text-white" onclick="closeModal('adjustModal')" type="button">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <b> Current Balance</b>
                <br>
                Balance {{ $name }} : Rp. {{ number_format($saldo, 0, ',', '.') }}
                <hr>
                <b> Adjust Balance</b>
                <br>
                Your Real Balance
                <form class="mt-2" id="adjustform" wire:submit.prevent="adjust">
                    <div class="hide-inputbtns input-group">
                        <input type="text" type-currency="IDR" inputmode="numeric" name="saldo_sekarang"
                            wire:model.defer="update_saldo" placeholder="Fill Your Real Balance" required
                            class="border-0 form-control @error('update_saldo') is-invalid @enderror">
                        @error('update_saldo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-block btn-primary" form="adjustform" value="Update" />
            </div>
        </div>
    </div>

    @livewire('rekening.create',['jeniss' => $jeniss])
</div>
