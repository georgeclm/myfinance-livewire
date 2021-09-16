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

    <div class="modal fade" wire:ignore id="p2p" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-black  modal-content">
                <div class="modal-header bg-gray-100 border-0">
                    <h5 class="modal-title text-white">Deposito</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close text-white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addStock" wire:submit.prevent="submit">
                        <div class="form-group" id="thebank">
                            <select wire:model.defer="form.nama_bank"
                                class="livesearch border-0 form-control form-control-user @error('form.nama_bank') is-invalid @enderror"
                                style="width: 100%; " name="nama_bank" id="nama_bank" required>
                            </select>
                            @error('form.nama_bank')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <input type="text" wire:model.defer="form.nama_bank"
                                class="border-0 form-control form-control-user " name="nama_bank" placeholder="Bank Name"
                                required>
                        </div> --}}
                        <div class="form-group">
                            <input type="text" wire:model.defer="form.nama_deposito"
                                class="border-0 form-control form-control-user " name="nama_deposito"
                                placeholder="Deposito Name" required>
                        </div>
                        <div class="mb-3 hide-inputbtns input-group">
                            <input type="number"
                                class="border-0 form-control form-control-user @error('form.bunga') is-invalid @enderror"
                                name="bunga" placeholder="Interest" wire:model.defer="form.bunga" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                            @error('form.bunga')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model.defer="form.jumlah" type-currency="IDR" inputmode="numeric" type="text"
                                name="jumlah" required placeholder="Amount"
                                class=" border-0 form-control form-control-user ">
                        </div>
                        {{-- <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model.defer="form.harga_jual" type-currency="IDR" inputmode="numeric"
                                type="text" name="harga_jual" required placeholder=" Expected Maturity Amount"
                                class="border-0  form-control form-control-user  @error('form.harga_jual') is-invalid @enderror ">
                            @error('form.harga_jual')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <input wire:model.defer="form.jatuh_tempo"
                                onchange="this.dispatchEvent(new InputEvent('input'))" class="border-0 form-control"
                                type="text" name="jatuh_tempo" />
                        </div>
                        <div class="form-group">
                            <select
                                class="border-0 form-control form-control-user form-block  @error('form.rekening_id') is-invalid @enderror"
                                wire:model.defer="form.rekening_id" name="rekening_id"
                                style="padding: 0.5rem !important" required>
                                <option value="" selected disabled hidden>From Pocket</option>
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
                            <input type="text" class="border-0 form-control form-control-user "
                                wire:model.defer="form.keterangan" name="keterangan" id="keterangan"
                                placeholder="Description">
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
@section('script')
    <script>
        $(function() {
            $('input[name="jatuh_tempo"]').daterangepicker({
                singleDatePicker: true,
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " / ",
                },
            });
        });
        $('.livesearch').select2({
            placeholder: 'Select bank',
            ajax: {
                url: '/ajax-autocomplete-search',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama,
                                id: item.nama
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.livesearch').on('change', function(e) {
            var data = $('.livesearch').select2("val");
            @this.set('form.nama_bank', data);
        });
    </script>
@endsection
