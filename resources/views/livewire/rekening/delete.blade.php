<div class="modal__container" wire:ignore.self id="delete-{{ $rekening->id }}">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white" id="exampleModalLabel">Delete {{ $rekening->nama_akun }}</h5>
            <button class="close text-white" type="button" onclick="closeModal('delete-{{ $rekening->id }}')">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body text-white">Select "Delete" below if you are ready to delete this pocket, this
            action cannot
            be undone </div>
        <div class="modal-footer border-0">
            <a class="btn btn-danger btn-block" href="javascript:void(0)" wire:click="delete">Delete</a>
        </div>
    </div>
</div>
