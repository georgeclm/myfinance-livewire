<div class="modal fade" wire:ignore id="deletemodal-{{ $cicilan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-dark modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white" id="exampleModalLabel">Delete {{ $cicilan->nama }}</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-white">Select "Delete" below if you are ready to delete this repetition, this
                action cannot
                be undone </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="javascript:void(0)" wire:click="delete">Delete</a>
            </div>
        </div>
    </div>
</div>
