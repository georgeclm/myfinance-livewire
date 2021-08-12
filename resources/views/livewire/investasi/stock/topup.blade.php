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

    <div class="modal fade" wire:ignore.self id="topup-{{ $stock->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-dark  modal-content">
                <div class="modal-header bg-gray-100 border-0">
                    <h5 class="modal-title text-white">Buy More Stock</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close text-white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formtopup-{{ $stock->id }}" wire:submit.prevent="submit">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" wire:model="form.kode"
                                placeholder="Stock Code" disabled>
                        </div>
                        <div class="mb-3 hide-inputbtns input-group">
                            <input type="number" class="form-control form-control-user" wire:model.defer="form.lot"
                                placeholder="Total" required>
                            <div class="input-group-append">
                                <span class="input-group-text">lot</span>
                            </div>
                        </div>
                        <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model.defer="form.harga_beli" type-currency="IDR" type="text" required
                                placeholder="Buy Price" class="form-control form-control-user ">
                            <div class="input-group-append">
                                <span class="input-group-text">Per Lembar</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <select wire:model.defer="form.rekening_id"
                                class="form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                                style="padding: 0.5rem !important">
                                @foreach (auth()->user()->rekenings as $rekening)
                                    <option value="{{ $rekening->id }}">
                                        {{ $rekening->nama_akun }}</option>
                                @endforeach
                            </select>
                            @error('form.rekening_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="form.financial_plan_id"
                                class="form-control form-control-user form-block @error('financial_plan_id') is-invalid @enderror"
                                style="padding: 0.5rem !important" name="financial_plan_id" disabled>
                                @foreach (auth()->user()->financialplans as $financialplan)
                                    <option value="{{ $financialplan->id }}" @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>{{ $financialplan->nama }} - Rp.
                                        {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                                @endforeach
                                @error('financial_plan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </select>

                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="form.keterangan" class="form-control form-control-user"
                                disabled placeholder="Description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" form="formtopup-{{ $stock->id }}" value="Update" />
                </div>
            </div>
        </div>
    </div>
</div>
