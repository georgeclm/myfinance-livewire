<div class="modal fade" wire:ignore.self id="sell-{{ $p2p->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-black  modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">Sell P2P</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close text-white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formsell-{{ $p2p->id }}" wire:submit.prevent="submit">
                    <div class="form-group">
                        <input type="text" wire:model="form.nama_p2p" class="border-0 form-control form-control-user"
                            disabled name="nama_p2p" placeholder="P2P Name" required>
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model="form.jumlah" type-currency="IDR" inputmode="numeric" disabled type="text"
                            name="jumlah" required placeholder="Amount"
                            class=" border-0 form-control form-control-user ">
                    </div>
                    <div class="mb-3 hide-inputbtns input-group">
                        <input wire:model="form.harga_jual" type-currency="IDR" inputmode="numeric" type="text"
                            name="harga_jual" required placeholder=" Expected Maturity Amount"
                            class="border-0  form-control form-control-user ">
                    </div>
                    <div class="form-group">
                        <input wire:model="form.jatuh_tempo" disabled
                            onchange="this.dispatchEvent(new InputEvent('input'))" class="border-0 form-control"
                            type="text" name="jatuh_tempo" />
                    </div>
                    <div class="form-group">
                        <select
                            class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                            wire:model="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                            required>
                            <option value="" selected disabled hidden>From Pocket</option>
                            @foreach (auth()->user()->rekenings as $rekening)
                                <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }}</option>
                            @endforeach
                        </select>
                        @error('form.rekening_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select class="border-0 form-control form-control-user form-block" disabled
                            wire:model="form.financial_plan_id" name="financial_plan_id"
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
                            wire:model="form.keterangan" name="keterangan" id="keterangan" placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="formsell-{{ $p2p->id }}" value="Sell" />
            </div>
        </div>
    </div>
</div>
