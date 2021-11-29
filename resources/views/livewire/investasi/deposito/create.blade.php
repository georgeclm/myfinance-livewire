<div class="modal__container" wire:ignore id="new-pocket">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">Deposito</h5>
            <button onclick="closeModal('new-pocket')" class="close text-white">
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
                        name="bunga" placeholder="Interest (Base On Your Time Not Annual)" wire:model.defer="form.bunga"
                        required step="0.01">
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
                        name="jumlah" required placeholder="Amount" class=" border-0 form-control form-control-user ">
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
                    <input wire:model.defer="form.jatuh_tempo" onchange="this.dispatchEvent(new InputEvent('input'))"
                        class="border-0 form-control" type="text" name="jatuh_tempo" readonly />
                </div>
                <div class="form-group">
                    <select
                        class="border-0 form-control form-control-user form-block  @error('form.rekening_id') is-invalid @enderror"
                        wire:model.defer="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
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
                        wire:model.defer="form.keterangan" name="keterangan" placeholder="Description">
                </div>
            </form>
        </div>
        <div class="modal-footer border-0">
            <input type="submit" class="btn btn-block btn-primary" form="addStock" value="Add" />
        </div>
    </div>
</div>
@section('script')
    <script>
        run();
        window.livewire.on('refreshView', () => {
            refresh();
        });
        refresh();

        function refresh() {

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
                    url: '/bank-search',
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
                    }
                }
            });
            $('.livesearch').on('change', function(e) {
                var data = $('.livesearch').select2("val");
                @this.set('form.nama_bank', data);
            });
        }
    </script>
@endsection
