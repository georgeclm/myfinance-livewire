<div class="modal__container" wire:ignore id="createTransaction">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">New Transaction</h5>
            <button class="close text-white" onclick="closeModal('createTransaction')">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="transaction" wire:submit.prevent="submit">
                <div class="form-group">
                    <select
                        class="border-0 form-control form-control-user form-block @error('form.jenisuang_id') is-invalid @enderror"
                        wire:model.defer="form.jenisuang_id" name="jenisuang_id" style="padding: 0.5rem !important"
                        required id="jenisuang">
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
                <div class="form-group" id="utang">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.utangid') is-invalid @enderror utang"
                        wire:model.defer="form.utangid" name="utangid" style="padding: 0.5rem !important">
                        <option value='' selected disabled hidden>Debt Who</option>
                        @foreach (auth()->user()->utangs as $utang)
                            <option value="{{ $utang->id }}">
                                {{ $utang->nama }}, Rp.
                                {{ number_format($utang->jumlah, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('form.utangid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group" id="utangteman">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.utangtemanid') is-invalid @enderror utangteman"
                        wire:model.defer="form.utangtemanid" name="utangtemanid" style="padding: 0.5rem !important">
                        <option value='' selected disabled hidden>Debt Who</option>
                        @foreach (auth()->user()->utangtemans as $utang)
                            <option value="{{ $utang->id }}">
                                {{ $utang->nama }}, Rp.
                                {{ number_format($utang->jumlah, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('form.utangtemanid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <select disabled id="rekening_id"
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
                <div class="mb-3 hide-inputbtns input-group" id="jumlah">
                    <input type="text" disabled type-currency="IDR" inputmode="numeric"
                        class="border-0 form-control form-control-user @error('form.jumlah') is-invalid @enderror"
                        wire:model.defer="form.jumlah" name="jumlah" required placeholder="Total">
                    @error('form.jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.category_id') is-invalid @enderror"
                        wire:model.defer="form.category_id" name="category_id" style="padding: 0.5rem !important"
                        id="category_id">
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
                        class="border-0 form-control form-control-user form-block @error('form.rekening_id2') is-invalid @enderror"
                        wire:model.defer="form.rekening_id2" name="rekening_id2" style="padding: 0.5rem !important"
                        id="transfer">
                        <option value='' selected disabled hidden>Choose Pocket Destination</option>
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
                <div class="form-group">
                    <input type="text" disabled id="keterangan"
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
            <input type="submit" class="btn btn-block btn-success" form="transaction" value="Save" />
        </div>
    </div>
</div>
@section('script')
    <script>
        $('#category_id').hide("slow");
        $('#category_masuk_id').hide("slow");
        $('#transfer').hide("slow");
        $('#utang').hide("slow");
        $('#utangteman').hide("slow");
        $('#keterangan').hide("slow");
        $('#rekening_id').hide("slow");
        $('#jumlah').hide("slow");
        $('#jenisuang').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('input').prop('disabled', false);
            $('select').prop('disabled', false);
            $('#category_id').prop('required', false);
            $('#category_masuk_id').prop('required', false);
            $('#transfer').prop('required', false);
            $('#utang').prop('required', false);
            $('#utangteman').prop('required', false);
            $('#category_id').hide("slow");
            $('#category_masuk_id').hide("slow");
            $('#transfer').hide("slow");
            $('#utang').hide("slow");
            $('#utangteman').hide("slow");
            $('#keterangan').show("slow");
            $('#rekening_id').show("slow");
            $('#jumlah').show("slow");
            if (valueSelected == 1) {
                $('#category_masuk_id').show("slow");
                $('#category_masuk_id').prop('required', true);
            } else if (valueSelected == 2) {
                $('#category_id').show("slow");
                $('#category_id').prop('required', true);
            } else if (valueSelected == 4) {
                $('#utang').show("slow");
                $('#utang').prop('required', true);
            } else if (valueSelected == 3) {
                $('#transfer').show("slow");
                $('#transfer').prop('required', true);
            } else {
                $('#utangteman').show("slow");
                $('#utangteman').prop('required', true);
            }
        });
        $('.utang').on('change', function(e) {
            var valueSelected = this.value;
            console.log(valueSelected);
            @this.set('form.utangid', valueSelected);
        });
        $('.utangteman').on('change', function(e) {
            var valueSelected = this.value;
            console.log(valueSelected);
            @this.set('form.utangtemanid', valueSelected);
        });
    </script>
@endsection
