<div class="modal fade" wire:ignore.self id="previous_deposito" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-black  modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Previous Earning From Deposito</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="prev_p2p" wire:submit.prevent="submit">
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="jumlah" type-currency="IDR" inputmode="numeric" type="text"
                            name="jumlah" required placeholder="Total Earnings"
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
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="prev_p2p" value="Store" />
            </div>
        </div>
    </div>
</div>
