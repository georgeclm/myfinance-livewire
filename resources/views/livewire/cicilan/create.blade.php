<div class="modal__container" wire:ignore id="create-cicilan">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">Repetition</h5>
            <button class="close text-white" onclick="closeModal('create-cicilan')">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="transaction" wire:submit.prevent="submit">
                {{-- <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="sekarang" value="0"> --}}
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
                        class="border-0 form-control form-control-user form-block @error('form.utang_id') is-invalid @enderror"
                        wire:model.defer="form.utang_id" name="utang_id" style="padding: 0.5rem !important">
                        <option value="" selected disabled hidden>Debt who</option>
                        @foreach (auth()->user()->utangs as $utang)
                            <option value="{{ $utang->id }}">
                                {{ $utang->nama }},
                                {{ Str::limit($utang->keterangan, 15, $end = '...') ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('form.utang_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group" id="utangteman">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.utang_id') is-invalid @enderror"
                        wire:model.defer="form.utangteman_id" name="utangteman_id" style="padding: 0.5rem !important">
                        <option value="" selected disabled hidden>Debt Who</option>
                        @foreach (auth()->user()->utangtemans as $utang)
                            <option value="{{ $utang->id }}">
                                {{ $utang->nama }},
                                {{ Str::limit($utang->keterangan, 15, $end = '...') ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('form.utang_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 hide-inputbtns input-group" id="jumlah">
                    <input type="text" disabled type-currency="IDR" inputmode="numeric" wire:model.defer="form.jumlah"
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
                <div class="form-group">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.category_id') is-invalid @enderror"
                        wire:model.defer="form.category_id" name="category_id" style="padding: 0.5rem !important"
                        id="category_id">
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
                <div class="form-group">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.category_masuk_id') is-invalid @enderror"
                        wire:model.defer="form.category_masuk_id" name="category_masuk_id"
                        style="padding: 0.5rem !important" id="category_masuk_id">
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
                <div class="form-group">
                    <select disabled id="transfer"
                        class="border-0 form-control form-control-user form-block @error('form.rekening_id2') is-invalid @enderror"
                        wire:model.defer="form.rekening_id2" name="rekening_id2" style="padding: 0.5rem !important">
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
            <input type="submit" class="btn btn-success btn-block" form="transaction" value="Save" />
        </div>
    </div>
</div>
@section('script')
    <script>
        run();
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
    </script>
@endsection
