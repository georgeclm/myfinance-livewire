<div>
    @if ($error)
        <script>
            window.addEventListener('contentChanged', event => {
                new Notify({
                    status: 'error',
                    title: 'Error',
                    text: "{{ $error }}",
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
            });
        </script>
    @endif

    <div class="modal__container" wire:ignore id="editmodal-{{ $cicilan->id }}">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Update Repetition</h5>
                <button class="close text-white" onclick="closeModal('editmodal-{{ $cicilan->id }}')">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditmodal-{{ $cicilan->id }}" wire:submit.prevent="submit">
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
                            wire:model.defer="form.jenisuang_id" name="jenisuang_id" style="padding: 0.5rem !important"
                            required disabled>
                            @foreach ($jenisuangsSelect as $jenis)
                                <option value="{{ $jenis->id }}" @if ($jenis->id == $cicilan->jenisuang_id) selected @endif>{{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('form.jenisuang_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if ($cicilan->utang_id != null)
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
                    @if ($cicilan->utangteman_id != null)
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
                            name="bulan" wire:model.defer="form.bulan" placeholder="How Many Months" required>
                        <div class="input-group-append">
                            <span class="input-group-text">bulan</span>
                        </div>
                        @error('form.bulan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if ($cicilan->category_id != null)
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
                    @if ($cicilan->category_masuk_id != null)
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
                            wire:model.defer="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                            required>
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
                    @if ($cicilan->rekening_id2 != null)
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
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formeditmodal-{{ $cicilan->id }}"
                    value="Edit" />
            </div>
        </div>
    </div>
</div>
