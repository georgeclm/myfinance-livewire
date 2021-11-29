<div class="modal__container" wire:ignore.self id="DanaMembeliBarang">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">Fund For Stuff</h5>
            <button onclick="closeModal('DanaMembeliBarang')" class="close text-white">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="addDanaMembeliBarang" wire:submit.prevent="submit">
                <div class="form-group">
                    <input type="text"
                        class="border-0 form-control form-control-user @error('form.nama') is-invalid @enderror"
                        wire:model.defer="form.nama" name="nama" placeholder="Stuff Name" required>
                    @error('form.nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 hide-inputbtns input-group">
                    <input type="text" name="target" type-currency="IDR" inputmode="numeric"
                        wire:model.defer="form.target" required placeholder="Stuff Price"
                        class="border-0  form-control form-control-user @error('form.target') is-invalid @enderror">
                    @error('form.target')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 hide-inputbtns input-group">
                    <input type="number"
                        class="border-0 form-control form-control-user @error('form.bulan') is-invalid @enderror"
                        wire:model.defer="form.bulan" name="bulan" placeholder="How long?" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">months</span>
                    </div>
                    @error('form.bulan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 hide-inputbtns input-group">
                    <input wire:model.defer="form.jumlah" type-currency="IDR" inputmode="numeric" type="text"
                        name="jumlah" required placeholder="Fund Avalible Now"
                        class="border-0  form-control form-control-user @error('form.jumlah') is-invalid @enderror">
                    @error('form.jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="modal-footer border-0">
            <input type="submit" class="btn btn-primary btn-block" form="addDanaMembeliBarang" value="Add" />
        </div>
    </div>
</div>
