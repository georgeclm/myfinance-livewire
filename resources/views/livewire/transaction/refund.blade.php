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
    <div class="modal fade" wire:ignore id="refund_{{ $transaction->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-dark modal-content">
                <div class="border-0 modal-header">
                    <h5 class="modal-title text-white">Revert The Transaction?</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-white">Transaction Will be Reverted and Rp.
                    {{ number_format($transaction->jumlah, 0, ',', '.') }} will @if ($transaction->jenisuang_id == 2) be refunded to your pocket. @else be deducted from your pocket. @endif</div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="javascript:void(0)" wire:click="revert">Revert</a>
                </div>
            </div>
        </div>
    </div>
</div>
