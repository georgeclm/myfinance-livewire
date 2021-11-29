    <div class="modal__container" wire:ignore.self id="danaDarurat">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Emergency Fund</h5>
                <button type="button" onclick="closeModal('danaDarurat')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addDanaDarurat" wire:submit.prevent="submit">
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="jumlah" type-currency="IDR" inputmode="numeric" required
                            placeholder="Spending Monthly" wire:model.defer="form.jumlah"
                            class="border-0 form-control form-control-user @error('jumlah') is-invalid @enderror">
                        @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select
                            class="border-0 form-control form-control-user form-block @error('status') is-invalid @enderror"
                            wire:model.defer="form.status" name="status" style="padding: 0.5rem !important" required>
                            <option value="" selected disabled hidden>Marital Status</option>
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
                <input type="submit" class="btn btn-primary btn-block" form="addDanaDarurat" value="Add" />
            </div>
        </div>
    </div>

    </div>
