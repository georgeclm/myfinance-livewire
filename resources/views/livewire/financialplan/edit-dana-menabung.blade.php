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
    <div class="modal__container" wire:ignore.self id="editmodal-{{ $financialplan->id }}">
        <div class="bg-black modal__content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Regular Savings Fund</h5>
                <button onclick="closeModal('editmodal-{{ $financialplan->id }}')" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formeditmodal-{{ $financialplan->id }}" wire:submit.prevent="submit">
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="target" type-currency="IDR" inputmode="numeric" required
                            wire:model.defer="form.target" placeholder="Starting Funds"
                            class="border-0 form-control form-control-user @error('target') is-invalid @enderror">
                        @error('target')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" name="jumlah" type-currency="IDR" inputmode="numeric"
                            wire:model.defer="form.jumlah" required placeholder="Amount to invest each month"
                            class="border-0 form-control form-control-user @error('jumlah') is-invalid @enderror">
                        @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" maxlength="2"
                            class="border-0 form-control form-control-user @error('bulan') is-invalid @enderror"
                            wire:model.defer="form.bulan" name="bulan" placeholder="How long?" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">months</span>
                        </div>
                        @error('bulan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer border-0">
                <input type="submit" class="btn btn-primary btn-block" form="formeditmodal-{{ $financialplan->id }}"
                    value="Update" />
            </div>
        </div>
    </div>
</div>
