<div>
    @if ($error)
        <script>
            window.addEventListener('contentChanged', event => {
                new Notify({
                    status: 'error',
                    title: 'Error',
                    text: "{{ $error }}",
                    effect: 'fade',
                    speed: 300,
                    customClass: null,
                    customIcon: null,
                    showIcon: true,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 3000,
                    gap: 20,
                    distance: 20,
                    type: 2,
                    position: 'right top'
                })
            });
        </script>
    @endif
    <div class="modal fade" wire:ignore.self id="addCategory" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-black modal-content">
                <div class="modal-header bg-gray-100 border-0">
                    <h5 class="modal-title text-white" id="exampleModalLabel">New Category Spending</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rekening" wire:submit.prevent="submit">
                        <div class="form-group">
                            <input type="text" class="border-0 form-control form-control-user " name="nama"
                                wire:model.defer="form.nama" required placeholder="Category Name">
                        </div>
                    </form>
                </div>
                <div class="border-0 modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" form="rekening" value="Add" />

                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <script>
            window.addEventListener('success', event => {
                new Notify({
                    status: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    effect: 'fade',
                    speed: 300,
                    customClass: null,
                    customIcon: null,
                    showIcon: true,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 3000,
                    gap: 20,
                    distance: 20,
                    type: 2,
                    position: 'right top'
                });
                $('#addCategory').modal('hide');
            });
        </script>
    @endif
</div>
