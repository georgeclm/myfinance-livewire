<div class="modal__container" id="modalSaving" wire:ignore.self>
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white" id="exampleModalLabel">New Category Spending</h5>
            <button class="close" type="button" onclick="closeModal('modalSaving')">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="rekening" wire:submit.prevent="submit">
                <div class="form-group">
                    <input type="text"
                        class="border-0 form-control form-control-user @error('form.nama') is-invalid @enderror"
                        name="nama" wire:model.defer="form.nama" required placeholder="Category Name">
                    @error('form.nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="border-0 modal-footer">
            <input type="submit" class="btn btn-primary btn-block" form="rekening" value="Add" />

        </div>
    </div>
</div>
