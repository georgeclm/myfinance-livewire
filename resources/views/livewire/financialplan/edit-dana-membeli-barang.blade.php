    <div class="modal__container" wire:ignore.self id="editmodal-{{ $financialplan->id }}">
        <div class="bg-black modal__content">

            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Fund For Stuff</h5>
                <button onclick="closeModal('editmodal-{{ $financialplan->id }}')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditmodal-{{ $financialplan->id }}" wire:submit.prevent="submit">
                    <div class="form-group">
                        <input type="text"
                            class="border-0 form-control form-control-user @error('nama') is-invalid @enderror"
                            name="nama" wire:model.defer="form.nama" placeholder="Stuff Name" required>
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="target" type-currency="IDR" inputmode="numeric"
                            wire:model.defer="form.target" required placeholder="Stuff Price"
                            class="border-0 form-control form-control-user @error('target') is-invalid @enderror">
                        @error('target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" wire:model.defer="form.bulan"
                            class="border-0 form-control form-control-user @error('bulan') is-invalid @enderror"
                            name="bulan" placeholder="How long?" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">months</span>
                        </div>
                        @error('bulan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="jumlah" type-currency="IDR" inputmode="numeric"
                            wire:model.defer="form.jumlah" required placeholder="Fund Avalible Now"
                            class="border-0 form-control form-control-user @error('jumlah') is-invalid @enderror">
                        @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formeditmodal-{{ $financialplan->id }}"
                    value="Update" />
            </div>
        </div>
    </div>
