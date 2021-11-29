    @section('title', 'Repetition - My Finance')
    <div class="container-fluid  small-when-0">
        <!-- Page Heading -->
        <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-white">Repetition</h1>
            @if (!auth()->user()->rekenings->isEmpty())
                <button onclick="showModal('new-pocket')" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Add</button>
            @endif
        </div>
        <div class="row mobile">
            @if (auth()->user()->rekenings->isEmpty())
                @livewire('partials.newaccount')
            @endif
        </div>
        @foreach ($jenisuangs as $jenisuang)

            <!-- DataTales Example -->
            <div class="bg-dark border-0 card shadow mb-4">
                <div class="bg-gray-100 border-0 card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $jenisuang->nama }}</h6>
                </div>
                <div class="card-body">
                    @forelse ($jenisuang->cicilans as $cicilan)
                        <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{ $cicilan->nama }} - Rp.
                                {{ number_format($cicilan->jumlah, 0, ',', '.') }}
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-caret-down"></i>
                                    {{-- <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> --}}
                                </a>
                                <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <a wire:click="editModal({{ $cicilan->id }})" class="dropdown-item text-white"
                                        href="javascript:void(0)">Edit</a>
                                    <a wire:click="deleteModal({{ $cicilan->id }})" class="dropdown-item text-white"
                                        href="javascript:void(0)">Delete</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="text-white my-3 mx-0">
                            <div class="d-flex ">
                                <div class="flex-grow-1">
                                    @switch($cicilan->jenisuang_id)
                                        @case(1)
                                            {{ $cicilan->category_masuk->nama }}
                                        @break
                                        @case(2)
                                            {{ $cicilan->category->nama }}
                                        @break
                                        @case(3)
                                            Transfer
                                        @break
                                        @case(4)
                                            Pay Debt
                                            {{ Str::limit($cicilan->utang->keterangan, 15, $end = '...') ?? $cicilan->utang->nama }}
                                        @break
                                        @default
                                            Friend Pay Debt
                                            {{ Str::limit($cicilan->utangteman->keterangan, 15, $end = '...') ?? $cicilan->utangteman->nama }}
                                    @endswitch
                                    <br>
                                    Date : {{ $cicilan->tanggal }}
                                </div>
                                {{ $cicilan->sekarang }}/@if ($cicilan->bulan == 0)∞@else{{ $cicilan->bulan }}@endif
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
            <div class="modal__container" wire:ignore.self id="deleteModal">
                <div class="bg-black modal__content">
                    <div class="modal-header bg-gray-100 border-0">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Delete {{ $nama }}</h5>
                        <button class="close text-white" onclick="closeModal('deleteModal')">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-white">Select "Delete" below if you are ready to delete this repetition,
                        this
                        action cannot
                        be undone </div>
                    <div class="modal-footer border-0">
                        <a class="btn btn-danger btn-block" href="javascript:void(0)" wire:click="delete">Delete</a>
                    </div>
                </div>
            </div>
            <div class="modal__container" wire:ignore.self id="editModal">
                <div class="bg-black modal__content">
                    <div class="modal-header bg-gray-100 border-0">
                        <h5 class="modal-title text-white">Update Repetition</h5>
                        <button class="close text-white" onclick="closeModal('editModal')">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formeditmodal" wire:submit.prevent="update">
                            <div class="form-group">
                                <input type="text"
                                    class="border-0 form-control form-control-user @error('form.nama') is-invalid @enderror"
                                    wire:model.defer="form.nama" required name="nama" placeholder="Repetition Name">
                                @error('form.nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <select
                                    class="border-0 form-control form-control-user form-block @error('form.jenisuang_id') is-invalid @enderror"
                                    wire:model.defer="form.jenisuang_id" name="jenisuang_id"
                                    style="padding: 0.5rem !important" required disabled>
                                    @foreach ($jenisuangs as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('form.jenisuang_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if ($jenisId == 4)
                                <div class="form-group">
                                    <select
                                        class="border-0 form-control form-control-user form-block @error('form.utang_id') is-invalid @enderror"
                                        wire:model.defer="form.utang_id" name="utang_id" style="padding: 0.5rem !important">
                                        <option value="" selected disabled hidden>Debt who</option>
                                        @foreach (auth()->user()->utangs as $utang)
                                            <option value="{{ $utang->id }}" @if ($utang->id == $cicilan->utang_id) selected @endif>
                                                {{ $utang->nama }},
                                                {{ Str::limit($utang->keterangan, 15, $end = '...') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form.utang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            @if ($jenisId == 5)
                                <div class="form-group">
                                    <select
                                        class="border-0 form-control form-control-user form-block @error('form.utang_id') is-invalid @enderror"
                                        wire:model.defer="form.utangteman_id" name="utangteman_id"
                                        style="padding: 0.5rem !important">
                                        <option value="" selected disabled hidden>Debt Who</option>
                                        @foreach (auth()->user()->utangtemans as $utang)
                                            <option value="{{ $utang->id }}" @if ($utang->id == $cicilan->utangteman_id) selected @endif>
                                                {{ $utang->nama }},
                                                {{ Str::limit($utang->keterangan, 15, $end = '...') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form.utang_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="mb-3 hide-inputbtns input-group">
                                <input type="text" type-currency="IDR" inputmode="numeric" wire:model.defer="form.jumlah"
                                    class="border-0 form-control form-control-user @error('form.jumlah') is-invalid @enderror"
                                    name="jumlah" required placeholder="Total">
                                @error('form.jumlah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number"
                                    class="currency border-0 form-control form-control-user @error('form.tanggal') is-invalid @enderror"
                                    wire:model.defer="form.tanggal" name="tanggal" required placeholder="Date">
                                @error('form.tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 hide-inputbtns input-group">
                                <input type="number"
                                    class="border-0 form-control form-control-user @error('form.bulan') is-invalid @enderror"
                                    name="bulan" wire:model.defer="form.bulan" placeholder="How Many Months">
                                <div class="input-group-append">
                                    <span class="input-group-text">bulan</span>
                                </div>
                                @error('form.bulan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if ($jenisId == 2)
                                <div class="form-group">
                                    <select
                                        class="border-0 form-control form-control-user form-block @error('form.category_id') is-invalid @enderror"
                                        wire:model.defer="form.category_id" name="category_id"
                                        style="padding: 0.5rem !important">
                                        <option value="" selected disabled hidden>Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            @if ($jenisId == 1)
                                <div class="form-group">
                                    <select
                                        class="border-0 form-control form-control-user form-block @error('form.category_masuk_id') is-invalid @enderror"
                                        wire:model.defer="form.category_masuk_id" name="category_masuk_id"
                                        style="padding: 0.5rem !important">
                                        <option value="" selected disabled hidden>Choose Category</option>
                                        @foreach ($categorymasuks as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.category_masuk_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <select
                                    class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                                    wire:model.defer="form.rekening_id" name="rekening_id"
                                    style="padding: 0.5rem !important" required>
                                    <option value="" selected disabled hidden>Choose Pocket</option>
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
                            @if ($jenisId == 3)
                                <div class="form-group">
                                    <select
                                        class="border-0 form-control form-control-user form-block @error('form.rekening_id2') is-invalid @enderror"
                                        wire:model.defer="form.rekening_id2" name="rekening_id2"
                                        style="padding: 0.5rem !important">
                                        <option value="" selected disabled hidden>Choose Pocket Destination</option>
                                        @foreach (auth()->user()->rekenings as $rekening)
                                            <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }} - Rp.
                                                {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.rekening_id2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="text"
                                    class="border-0 form-control form-control-user @error('form.keterangan') is-invalid @enderror"
                                    wire:model.defer="form.keterangan" name="keterangan" placeholder="Description">
                                @error('form.keterangan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </form>
                        <div class="text-white">
                            <b>Empty How Many Months Field For Infinity Repetition</b>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <input type="submit" class="btn btn-primary btn-block" form="formeditmodal" value="Edit" />
                    </div>
                </div>
            </div>


            @livewire('cicilan.create',['jenisuangs' => $jenisuangs,'categories' => $categories,'categorymasuks' =>
            $categorymasuks])
        </div>
