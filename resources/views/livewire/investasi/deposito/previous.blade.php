<div class="modal__container" wire:ignore.self id="previous_deposito">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">Previous Earning From Deposito</h5>
            <button onclick="closeModal('previous_deposito')" class="close text-white">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="prev_p2p" wire:submit.prevent="submit">
                <div class="mb-3 hide-inputbtns input-group">
                    <input wire:model.defer="jumlah" type-currency="IDR" inputmode="numeric" type="text" name="jumlah"
                        required placeholder="Total Earnings"
                        class=" border-0 form-control form-control-user @error('jumlah') is-invalid @enderror">
                    @error('jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="modal-footer border-0">
            <input type="submit" class="btn btn-primary btn-block" form="prev_p2p" value="Store" />
        </div>
    </div>
</div>
