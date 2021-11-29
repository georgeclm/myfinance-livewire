    <div class="modal__container" wire:ignore.self id="editmodal-{{ $financialplan->id }}">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Emergency Fund</h5>
                <button onclick="closeModal('editmodal-{{ $financialplan->id }}')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditmodal-{{ $financialplan->id }}" wire:submit.prevent="submit">
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type-currency="IDR" inputmode="numeric" type="text" name="jumlah"
                            wire:model.defer="form.jumlah" required
                            class="border-0 form-control form-control-user @error('jumlah') is-invalid @enderror">
                        @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="form.status"
                            class="border-0 form-control form-control-user form-block @error('status') is-invalid @enderror"
                            name="status" style="padding: 0.5rem !important" required>
                            <option value="1">Single</option>
                            <option value="2">Married</option>
                            <option value="3">Married with children</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-block btn-primary" form="formeditmodal-{{ $financialplan->id }}"
                    value="Update" />
            </div>
        </div>
    </div>
