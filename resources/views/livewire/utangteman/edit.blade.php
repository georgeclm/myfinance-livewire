<div class="modal__container" wire:ignore.self id="edit-friend-debt-{{ $utang->id }}">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">
                Update
                Friend Debt
            </h5>
            <button onclick="closeModal('edit-friend-debt-{{ $utang->id }}')" class="close text-white">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="{{ $utang->id }}form" wire:submit.prevent="submit">
                <div class="form-group">
                    <input type="text" name="nama" wire:model.defer="form.nama" required placeholder="Debt to who"
                        class="form-control form-control-user border-0">
                </div>
                <div class="mb-3 hide-inputbtns input-group">
                    <input type="text" wire:model="form.jumlah" inputmode="numeric" type-currency="IDR" disabled
                        placeholder="Total Debt" class="form-control form-control-user border-0">
                </div>
                <div class="form-group">
                    <input type="text" wire:model.defer="form.keterangan" name="keterangan" placeholder="Description"
                        class="form-control form-control-user border-0">
                </div>
            </form>
        </div>
        <div class="modal-footer  border-0">
            <input type="submit" class="btn btn-primary btn-block" form="{{ $utang->id }}form" value="Edit" />
        </div>
    </div>
</div>
