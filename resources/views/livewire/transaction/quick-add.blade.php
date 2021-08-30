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
    <div class="modal fade" wire:ignore id="quickAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-black modal-content">
                <div class="modal-header bg-gray-100 border-0">
                    <h5 class="modal-title text-white">Quick Transaction</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="quick" wire:submit.prevent="submit">
                        <div class="form-group">
                            <select
                                class="border-0 form-control form-control-user form-block @error('form.jenisuang_id') is-invalid @enderror"
                                wire:model.defer="form.jenisuang_id" name="jenisuang_id"
                                style="padding: 0.5rem !important" required id="jenisuang">
                                <option value="" selected disabled hidden>Choose Type</option>
                                @foreach ($jenisuangsSelect as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                @endforeach
                            </select>
                            @error('form.jenisuang_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 hide-inputbtns input-group">
                            <input type="text" disabled type-currency="IDR"
                                class="border-0 form-control form-control-user @error('form.jumlah') is-invalid @enderror"
                                wire:model.defer="form.jumlah" inputmode="numeric" name="jumlah" required
                                placeholder="Total">
                            @error('form.jumlah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select disabled
                                class="border-0 form-control form-control-user form-block @error('form.category_id') is-invalid @enderror"
                                wire:model.defer="form.category_id" name="category_id"
                                style="padding: 0.5rem !important" id="category_id">
                                <option value='' selected disabled hidden>Choose Category</option>
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
                        <div class="form-group">
                            <select disabled
                                class="border-0 form-control form-control-user form-block @error('form.category_masuk_id') is-invalid @enderror"
                                wire:model.defer="form.category_masuk_id" name="category_masuk_id"
                                style="padding: 0.5rem !important" id="category_masuk_id">
                                <option value='' selected disabled hidden>Choose Category</option>
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
                        <div class="form-group">
                            <select disabled
                                class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                                wire:model.defer="form.rekening_id" name="rekening_id"
                                style="padding: 0.5rem !important" required>
                                <option value="" selected disabled hidden>Choose Pocket</option>
                                @foreach (auth()->user()->rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }}</option>
                                @endforeach
                            </select>
                            @error('form.rekening_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" disabled
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
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" form="quick" value="Add" />
                </div>
            </div>
        </div>
    </div>
</div>
