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

    <div class="modal fade" wire:ignore id="stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-black  modal-content">
                <div class="modal-header bg-gray-100 border-0">
                    <h5 class="modal-title text-white">Stock</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close text-white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addStock" wire:submit.prevent="submit">
                        <div class="form-group">
                            <input type="text" maxlength="4"
                                class="border-0 form-control form-control-user @error('kode') is-invalid @enderror"
                                name="kode" wire:model="form.kode" placeholder="Stock Code" required>
                            @error('kode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 hide-inputbtns input-group">
                            <input type="number" wire:model="form.lot"
                                class="border-0 form-control form-control-user @error('lot') is-invalid @enderror"
                                name="lot" placeholder="Total" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">lot</span>
                            </div>
                            @error('lot')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 hide-inputbtns input-group">
                            <input type="text" name="harga_beli" required placeholder="Buy Price" type-currency="IDR"
                                wire:model="form.harga_beli"
                                class="border-0 form-control form-control-user @error('harga_beli') is-invalid @enderror">
                            <div class="input-group-append">
                                <span class="input-group-text">Per Lembar</span>
                            </div>
                            @error('harga_beli')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="mb-3 hide-inputbtns input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input data-number-stepfactor="100" type="number" name="biaya_lain"
                            value="{{ old('biaya_lain') ?? 0 }}" placeholder="Biaya Lainnya"
                            class="currency form-control form-control-user @error('biaya_lain') is-invalid @enderror">
                        @error('biaya_lain')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                        <div class="form-group">
                            <select
                                class="border-0 form-control form-control-user form-block @error('rekening_id') is-invalid @enderror"
                                name="rekening_id" style="padding: 0.5rem !important" required
                                wire:model="form.rekening_id">
                                <option value="" selected disabled hidden>From Pocket</option>
                                @foreach (auth()->user()->rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }}</option>
                                @endforeach
                            </select>
                            @error('rekening_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select
                                class="border-0 form-control form-control-user form-block @error('financial_plan_id') is-invalid @enderror"
                                wire:model="form.financial_plan_id" name="financial_plan_id"
                                style="padding: 0.5rem !important" required>
                                <option value="" selected disabled hidden>Invest Goal</option>
                                @foreach (auth()->user()->financialplans as $financialplan)
                                    <option value="{{ $financialplan->id }}" @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>{{ $financialplan->nama }} - Rp.
                                        {{ number_format($financialplan->target) }}</option>
                                @endforeach
                            </select>
                            @error('financial_plan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text"
                                class="border-0 form-control form-control-user @error('keterangan') is-invalid @enderror"
                                name="keterangan" wire:model="form.keterangan" id="keterangan"
                                placeholder="Description">
                            @error('keterangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" form="addStock" value="Add" />
                </div>
            </div>
        </div>
    </div>
</div>
