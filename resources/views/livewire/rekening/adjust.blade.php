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
    <div class="modal fade" wire:ignore id="adjustmodal-{{ $rekening->id }}" role="dialog" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-black modal-content">
                <div class="modal-header bg-gray-100 border-0">
                    <h5 class="modal-title text-white">
                        Adjust Balance
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-white">
                    <b> Current Balance</b>
                    <br>
                    Balance {{ $rekening->nama }} : Rp. {{ number_format($rekening->saldo_sekarang) }}
                    <hr>
                    <b> Adjust Balance</b>
                    <br>
                    Your Real Balance
                    <form class="mt-2" id="{{ $rekening->id }}adjustform" wire:submit.prevent="submit">
                        <div class="hide-inputbtns input-group">
                            <input type="text" type-currency="IDR" name="saldo_sekarang"
                                wire:model.defer="saldo_sekarang" placeholder="Fill Your Real Balance" required
                                class="border-0 form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" form="{{ $rekening->id }}adjustform" value="Save" />
                </div>
            </div>
        </div>
    </div>
</div>
