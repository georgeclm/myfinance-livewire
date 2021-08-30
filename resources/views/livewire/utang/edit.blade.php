<div class="modal fade" wire:ignores.self id="editmodal-{{ $utang->id }}" role="dialog" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-black modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">
                    Update
                    Debt
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="{{ $utang->id }}form" wire:submit.prevent="submit">
                    <div class="form-group">
                        <input type="text" name="nama" required wire:model.defer="form.nama" placeholder="Debt to who"
                            class="border-0 form-control form-control-user">
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model="form.jumlah" type-currency="IDR" inputmode="numeric" type="text" disabled
                            placeholder="Jumlah Utang" class="border-0 form-control form-control-user">
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.keterangan" name="keterangan"
                            placeholder="Description" class="border-0 form-control form-control-user">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="{{ $utang->id }}form" value="Edit" />
            </div>
        </div>
    </div>
</div>
