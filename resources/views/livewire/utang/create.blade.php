<div class="modal fade" wire:ignore.self id="addRekening" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-black modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">New Debt</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rekening" wire:submit.prevent="submit">
                    <div class="form-group">
                        <input type="text" name="nama" required placeholder="Debt to who" wire:model="form.nama"
                            class="border-0 form-control form-control-user @error('form.nama') is-invalid @enderror">
                        @error('form.nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select
                            class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                            wire:model="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                            required>
                            <option value="" selected disabled hidden>For Pocket</option>
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
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" type-currency="IDR" name="jumlah" required wire:model="form.jumlah"
                            placeholder="Total"
                            class="border-0 form-control form-control-user @error('form.jumlah') is-invalid @enderror">
                        @error('form.jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="keterangan" placeholder="Description" wire:model="form.keterangan"
                            class="border-0 form-control form-control-user @error('form.keterangan') is-invalid @enderror">
                        @error('form.keterangan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="rekening" value="Add" />
            </div>
        </div>
    </div>
</div>
