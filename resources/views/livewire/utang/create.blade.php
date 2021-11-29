<div>
    @if (session()->has('success'))
        <script>
            new Notify({
                status: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
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
        </script>
    @endif
    <div class="modal__container" wire:ignore.self id="new-pocket">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">New Debt</h5>
                <button class="close text-white" onclick="closeModal('new-pocket')">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rekening" wire:submit.prevent="submit">
                    <div class="form-group">
                        <input type="text" name="nama" required placeholder="Debt to who" wire:model.defer="form.nama"
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
                            wire:model.defer="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                            required>
                            <option value="" selected disabled hidden>For Pocket</option>
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
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" type-currency="IDR" inputmode="numeric" name="jumlah" required
                            wire:model.defer="form.jumlah" placeholder="Total"
                            class="border-0 form-control form-control-user @error('form.jumlah') is-invalid @enderror">
                        @error('form.jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="keterangan" placeholder="Description"
                            wire:model.defer="form.keterangan"
                            class="border-0 form-control form-control-user @error('form.keterangan') is-invalid @enderror">
                        @error('form.keterangan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-block btn-danger" form="rekening" value="Add" />
            </div>
        </div>
    </div>
</div>
