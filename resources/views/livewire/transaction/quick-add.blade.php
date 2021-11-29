<div class="modal__container" wire:ignore id="createTransaction">
    <div class="bg-black modal__content">
        <div class="modal-header bg-gray-100 border-0">
            <h5 class="modal-title text-white">Quick Transaction</h5>
            <button class="close text-white" type="button" onclick="closeModal('createTransaction')">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="quick" wire:submit.prevent="submit">
                <div class="form-group">
                    <select
                        class="border-0 form-control form-control-user form-block @error('form.jenisuang_id') is-invalid @enderror"
                        wire:model.defer="form.jenisuang_id" name="jenisuang_id" style="padding: 0.5rem !important"
                        required id="jenisuang">
                        <option value="" selected disabled hidden>Choose Type</option>
                        <option value="1">Income</option>
                        <option value="2">Spending</option>
                    </select>
                    @error('form.jenisuang_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 hide-inputbtns input-group" id="jumlah">
                    <input type="text" disabled type-currency="IDR"
                        class="border-0 form-control form-control-user @error('form.jumlah') is-invalid @enderror"
                        wire:model.defer="form.jumlah" inputmode="numeric" name="jumlah" required placeholder="Total">
                    @error('form.jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.category_id') is-invalid @enderror"
                        wire:model.defer="form.category_id" name="category_id" style="padding: 0.5rem !important"
                        id="category_id">
                        <option value='' selected disabled hidden>Choose Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                    @error('form.category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <select disabled
                        class="border-0 form-control form-control-user form-block @error('form.category_masuk_id') is-invalid @enderror"
                        wire:model.defer="form.category_masuk_id" name="category_masuk_id"
                        style="padding: 0.5rem !important" id="category_masuk_id">
                        <option value='' selected disabled hidden>Choose Category</option>
                        @foreach ($category_masuks as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                    @error('form.category_masuk_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <select disabled id="rekening_id"
                        class="border-0 form-control form-control-user form-block @error('form.rekening_id') is-invalid @enderror"
                        wire:model.defer="form.rekening_id" name="rekening_id" style="padding: 0.5rem !important"
                        required>
                        <option value="" selected disabled hidden>Choose Pocket</option>
                        @foreach (auth()->user()->rekenings as $rekening)
                            <option value="{{ $rekening->id }}">{{ $rekening->nama_akun }} - Rp.
                                {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                    @error('form.rekening_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" disabled id="keterangan"
                        class="border-0 form-control form-control-user @error('form.keterangan') is-invalid @enderror"
                        wire:model.defer="form.keterangan" name="keterangan" placeholder="Description">
                    @error('form.keterangan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="modal-footer border-0">
            <input type="submit" class="btn btn-block btn-success" form="quick" value="Save" />
        </div>
    </div>
</div>
