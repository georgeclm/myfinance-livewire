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
    <div class="modal__container" wire:ignore.self id="stock">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Stock</h5>
                <button onclick="closeModal('stock')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addStock" wire:submit.prevent="submit">
                    <div class="form-group" wire:ignore>
                        <select wire:model.defer="form.kode"
                            class="livesearch border-0 form-control form-control-user @error('form.kode') is-invalid @enderror"
                            style="width: 100%; " name="kode" required>
                        </select>
                        @error('form.kode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                            <input type="text" maxlength="4"
                                class="border-0 form-control form-control-user @error('form.kode') is-invalid @enderror"
                                name="kode" wire:model.defer="form.kode" placeholder="Stock Code" required>
                            @error('form.kode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" wire:model.defer="form.lot"
                            class="border-0 form-control form-control-user @error('form.lot') is-invalid @enderror"
                            name="lot" placeholder="Total" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">lot</span>
                        </div>
                        @error('form.lot')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="harga_beli" required placeholder="Buy Price" inputmode="numeric"
                            type-currency="IDR" wire:model.defer="form.harga_beli"
                            class="border-0 form-control form-control-user @error('form.harga_beli') is-invalid @enderror">
                        <div class="input-group-append">
                            <span class="input-group-text">Per Lembar</span>
                        </div>
                        @error('form.harga_beli')
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
                            class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                            name="rekening_id" style="padding: 0.5rem !important" required
                            wire:model.defer="form.rekening_id">
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
                        <select
                            class="border-0 form-control form-control-user form-block @error('form.financial_plan_id') is-invalid @enderror"
                            wire:model.defer="form.financial_plan_id" name="financial_plan_id"
                            style="padding: 0.5rem !important" required>
                            <option value="" selected disabled hidden>Invest Goal</option>
                            @foreach (auth()->user()->financialplans as $financialplan)
                                <option value="{{ $financialplan->id }}" @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>
                                    {{ $financialplan->nama }} - Rp.
                                    {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('form.financial_plan_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text"
                            class="border-0 form-control form-control-user @error('form.keterangan') is-invalid @enderror"
                            name="keterangan" wire:model.defer="form.keterangan" placeholder="Description">
                        @error('form.keterangan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="addStock" value="Add" />
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        run();
        $('.livesearch').select2({
            placeholder: 'Select Stock',
            ajax: {
                url: '/ticker-search',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama + " - " + item.code,
                                id: item.code
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.livesearch').on('change', function(e) {
            var data = $('.livesearch').select2("val");
            @this.set('form.kode', data);
        });
    </script>
@endsection
