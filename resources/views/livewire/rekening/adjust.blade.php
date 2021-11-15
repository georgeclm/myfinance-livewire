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
    <div class="modal__container" wire:ignore id="adjust-{{ $rekening->id }}">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">
                    Adjust Balance
                </h5>
                <button class="close text-white" onclick="closeModal('adjust-{{ $rekening->id }}')" type="button">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <b> Current Balance</b>
                <br>
                Balance {{ $rekening->nama }} : Rp. {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}
                <hr>
                <b> Adjust Balance</b>
                <br>
                Your Real Balance
                <form class="mt-2" id="{{ $rekening->id }}adjustform" wire:submit.prevent="submit">
                    <div class="hide-inputbtns input-group">
                        <input type="text" type-currency="IDR" inputmode="numeric" name="saldo_sekarang"
                            wire:model.defer="saldo_sekarang" placeholder="Fill Your Real Balance" required
                            class="border-0 form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-block btn-primary" form="{{ $rekening->id }}adjustform"
                    value="Update" />
            </div>
        </div>
    </div>
