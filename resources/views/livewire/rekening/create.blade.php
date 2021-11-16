<div class="modal__container" wire:ignore.self id="new-pocket">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white" id="exampleModalLabel">New Pocket</h5>
            <button class="close text-white" onclick="closeModal('new-pocket')" type="button">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="rekening" wire:submit.prevent="submit">
                <div class="form-group">
                    <select
                        class="theselect border-0 form-control form-control-user form-block @error('form.jenis_id') is-invalid @enderror"
                        wire:model.defer="form.jenis_id" name="jenis_id" style="padding: 0.5rem !important" required>
                        <option value="" selected disabled hidden>Choose Type</option>
                        @foreach ($jeniss as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                        @endforeach
                    </select>
                    @error('form.jenis_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" id="nama-akun"
                        class="border-0 form-control form-control-user @error('form.nama_akun') is-invalid @enderror"
                        wire:model.defer="form.nama_akun" name="nama_akun" required placeholder="Pocket Name" disabled>
                    @error('form.nama_akun')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
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
                <div class="form-group">
                    <select
                        class="border-0 form-control form-control-user form-block @error('form.nama_bank') is-invalid @enderror"
                        wire:model.defer="form.nama_bank" id="ewallet" name="ewallet" style="padding: 0.5rem !important"
                        required disabled>
                        <option value="" selected>Select Provider</option>
                        @foreach (App\Models\Bank::where('code', '9999')->get() as $ewallet)
                            <option value="{{ $ewallet->nama }}">{{ $ewallet->nama }}</option>
                        @endforeach
                    </select>
                    @error('form.nama_bank')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 hide-inputbtns input-group">
                    <input type="text" type-currency="IDR" inputmode="numeric"
                        class="border-0 form-control form-control-user @error('form.saldo_sekarang') is-invalid @enderror "
                        wire:model.defer="form.saldo_sekarang" name="saldo_sekarang" required disabled
                        id="saldo_sekarang" placeholder="Current Balance">
                    @error('form.saldo_sekarang') .
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 hide-inputbtns input-group">
                    <input type="text" type-currency="IDR" inputmode="numeric"
                        class="border-0 form-control form-control-user @error('form.saldo_mengendap') is-invalid @enderror"
                        wire:model.defer="form.saldo_mengendap" name="saldo_mengendap" id="saldo_mengendap"
                        placeholder="Balance Settles" disabled>
                    @error('form.saldo_mengendap')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text"
                        class="border-0 form-control form-control-user @error('form.keterangan') is-invalid @enderror"
                        wire:model.defer="form.keterangan" name="keterangan" id="keteranganpocket"
                        placeholder="Description" disabled>
                    @error('form.keterangan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="modal-footer border-0">
            {{-- <button class="btn btn-secondary" onclick="closeModal('new-pocket')" type="button">Cancel</button> --}}
            <input type="submit" class="btn btn-block btn-success" form="rekening" value="Create" />
        </div>
    </div>
</div>

@section('script')
    <script>
        run();
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
                },
                cache: true
            }
        });
        $('.livesearch').on('change', function(e) {
            var data = $('.livesearch').select2("val");
            @this.set('form.nama_bank', data);
        });
        $(document).ready(function() {
            $(".dropdown-toggle").dropdown();
            $('#thebank').hide('slow');
            $('#ewallet').hide('slow');
        });
        // $(document).ready(function() {
        //     $('#1').DataTable();
        //     $('#2').DataTable();
        //     $('#3').DataTable();
        // });

        $('.theselect').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('#nama-akun').prop('disabled', false);
            $('#nama-bank').prop('disabled', false);
            $('#saldo_mengendap').prop('disabled', false);
            $('#saldo_sekarang').prop('disabled', false);
            $('#keteranganpocket').prop('disabled', false);
            $('#ewallet').prop('disabled', false);
            if (valueSelected == 1) {
                $('#nama_bank').prop('disabled', true);
                $('#thebank').hide('slow');
                $('#ewallet').hide('slow');
                $('#ewallet').prop('required', false);
                $('#nama_bank').prop('required', false);
                $('#saldo_mengendap').prop('disabled', true);
                $('#saldo_mengendap').prop('required', false);
            } else if (valueSelected == 2) {
                $('#nama_bank').prop('disabled', false);
                $('#thebank').show('slow');
                $('#ewallet').hide('slow');
                $('#ewallet').prop('required', false);
                $('#nama_bank').prop('required', true);
                $('#saldo_mengendap').prop('disabled', false);
                $('#saldo_mengendap').prop('required', true);
            } else {
                $('#nama_bank').prop('disabled', false);
                $('#thebank').hide('slow');
                $('#ewallet').show('slow');
                $('#nama_bank').prop('required', false);
                $('#saldo_mengendap').prop('disabled', true);
                $('#saldo_mengendap').prop('required', false);
                $('#ewallet').prop('disabled', false);
                $('#ewallet').prop('required', true);
            }
        });
    </script>

@endsection
