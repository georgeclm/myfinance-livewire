<div class="modal fade" wire:ignore.self id="change-{{ $deposito->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-black  modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Change Deposito Goal</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formchange-{{ $deposito->id }}" wire:submit.prevent="submit">
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.nama_bank"
                            class="border-0 form-control form-control-user " name="nama_bank" placeholder="Bank Name"
                            disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="form.nama_deposito"
                            class="border-0 form-control form-control-user " name="nama_deposito"
                            placeholder="Deposito Name" disabled>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="number" class="border-0 form-control form-control-user " name="bunga"
                            placeholder="Interest" wire:model.defer="form.bunga" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model.defer="form.jumlah" type-currency="IDR" inputmode="numeric" disabled
                            type="text" name="jumlah" required placeholder="Amount"
                            class=" border-0 form-control form-control-user ">
                    </div>
                    <div class="form-group">
                        <input wire:model.defer="form.jatuh_tempo" disabled
                            onchange="this.dispatchEvent(new InputEvent('input'))" class="border-0 form-control"
                            type="text" name="jatuh_tempo" />
                    </div>
                    <div class="form-group">
                        <select class="border-0 form-control form-control-user form-block " disabled
                            wire:model.defer="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                            required>
                            <option value="" selected disabled hidden>From Pocket</option>
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }} - Rp.
                                    {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="border-0 form-control form-control-user form-block"
                            wire:model.defer="form.financial_plan_id" name="financial_plan_id"
                            style="padding: 0.5rem !important" required>
                            <option value="" selected disabled hidden>Invest Goal</option>
                            @foreach (auth()->user()->financialplans as $financialplan)
                                <option value="{{ $financialplan->id }}" @if ($financialplan->jumlah >= $financialplan->target) hidden @endif>
                                    {{ $financialplan->nama }} - Rp.
                                    {{ number_format($financialplan->target, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " disabled
                            wire:model.defer="form.keterangan" name="keterangan" placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="formchange-{{ $deposito->id }}" value="Change" />
            </div>
        </div>
    </div>
</div>
