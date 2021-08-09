<div class="modal fade" wire:ignore id="editmodal-{{ $utang->id }}" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-dark modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">
                    Update
                    Friend Debt
                </h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="{{ $utang->id }}form" wire:submit.prevent="submit">
                    <div class="form-group">
                        <input type="text" name="nama" wire:model="form.nama" required placeholder="Debt to who"
                            class="form-control form-control-user">
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" wire:model="form.jumlah" type-currency="IDR" disabled
                            placeholder="Total Debt" class="form-control form-control-user">
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model="form.keterangan" name="keterangan" placeholder="Description"
                            class="form-control form-control-user">
                    </div>
                </form>
            </div>
            <div class="modal-footer  border-0">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="{{ $utang->id }}form" value="Edit" />
            </div>
        </div>
    </div>
</div>
