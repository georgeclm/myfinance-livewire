<div class="modal fade" wire:ignore id="addRekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-black modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white" id="exampleModalLabel">New Pocket</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rekening" wire:submit.prevent="submit">
                    <div class="form-group">
                        <select
                            class="border-0 form-control form-control-user form-block @error('form.jenis_id') is-invalid @enderror"
                            wire:model.defer="form.jenis_id" name="jenis_id" style="padding: 0.5rem !important"
                            required>
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
                            wire:model.defer="form.nama_akun" name="nama_akun" required placeholder="Pocket Name"
                            disabled>
                        @error('form.nama_akun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text"
                            class="border-0 form-control form-control-user @error('form.nama_bank') is-invalid @enderror"
                            wire:model.defer="form.nama_bank" name="nama_bank" required id="nama_bank"
                            placeholder="Nama Bank" disabled>
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
                            wire:model.defer="form.keterangan" name="keterangan" id="keterangan"
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
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="rekening" value="Add" />
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        $(document).ready(function() {
            $(".dropdown-toggle").dropdown();
        });
        // $(document).ready(function() {
        //     $('#1').DataTable();
        //     $('#2').DataTable();
        //     $('#3').DataTable();
        // });
        $('select').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $('#nama-akun').prop('disabled', false);
            $('#nama-bank').prop('disabled', false);
            $('#saldo_mengendap').prop('disabled', false);
            $('#saldo_sekarang').prop('disabled', false);
            $('#keterangan').prop('disabled', false);
            if (valueSelected == 1) {
                $('#nama_bank').prop('disabled', true);
                $('#nama_bank').prop('required', false);
                $('#saldo_mengendap').prop('disabled', true);
                $('#saldo_mengendap').prop('required', false);
            } else if (valueSelected == 2) {
                $('#nama_bank').prop('disabled', false);
                $('#nama_bank').prop('required', true);
                $('#saldo_mengendap').prop('disabled', false);
                $('#saldo_mengendap').prop('required', true);
            } else {
                $('#nama_bank').prop('disabled', false);
                $('#nama_bank').prop('required', true);
                $('#saldo_mengendap').prop('disabled', true);
                $('#saldo_mengendap').prop('required', false);
            }
        });
    </script>

@endsection
