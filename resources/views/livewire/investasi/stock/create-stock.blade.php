<div class="modal__container" wire:ignore.self id="new-pocket">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">Stock</h5>
            <button onclick="closeModal('new-pocket')" class="close text-white">
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
                        <option value="0">Trading</option>
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
@section('script')
    <script src="{{ asset('js/chart.js/Chart.min.js') }}" data-turbolinks-track="true"></script>
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
                }
            }
        });
        $('.livesearch').on('change', function(e) {
            var data = $('.livesearch').select2("val");
            @this.set('form.kode', data);
        });
        var ctx = document.getElementById("myPieChart");
        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };
        var label_ticker = [];
        var data_stock = [];
        var coloR = [];
        var border = [];
        @foreach ($stocks as $stock)
            coloR.push(dynamicColors());
            label_ticker.push("{{ $stock->kode }}");
            data_stock.push("{{ round(($stock->total * 100) / Auth::user()->total_stocks->sum('total')) }}");
            border.push(0);
        @endforeach

        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: label_ticker,
                datasets: [{
                    data: data_stock,
                    backgroundColor: coloR,
                    borderWidth: border
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true,
                    position: 'bottom',
                },
                cutoutPercentage: 80,
            },
        });
    </script>
@endsection
