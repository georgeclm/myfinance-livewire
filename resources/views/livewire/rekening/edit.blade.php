<div class="modal fade" wire:ignore id="editmodal-{{ $rekening->id }}" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="bg-black modal-content">
            <div class="modal-header bg-gray-100 border-0">
                <h5 class="modal-title text-white">
                    Update
                    Pocket
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="{{ $rekening->id }}form" wire:submit.prevent="submit">
                    <div class="form-group">
                        <select wire:model="form.jenis_id" class="border-0 form-control form-control-user form-block"
                            style="padding: 0.5rem !important" disabled>
                            @foreach ($jeniss as $jenis)
                                <option value="{{ $jenis->id }}">
                                    {{ $jenis->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " name="nama_akune"
                            wire:model.defer="form.nama_akun" required placeholder="Pocket Name">
                    </div>
                    @if ($rekening->jenis_id != 1)
                        <div class="form-group">
                            <input type="text" class="border-0 form-control form-control-user " name="nama_banke"
                                wire:model.defer="form.nama_bank" required placeholder="Nama Bank">
                        </div>
                    @endif
                    <div class="mb-3 hide-inputbtns input-group">
                        <input type="text" type-currency="IDR" class="border-0 form-control form-control-user "
                            wire:model.defer="form.saldo_sekarang" disabled placeholder="Current Balance">
                    </div>
                    @if ($rekening->jenis_id == 2)
                        <div class="mb-3 hide-inputbtns input-group">
                            <input type="text" type-currency="IDR" class="border-0 form-control form-control-user "
                                wire:model.defer="form.saldo_mengendap" name="saldo_mengendape"
                                placeholder="Balance Settles">
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" class="border-0 form-control form-control-user " name="keterangane"
                            wire:model.defer="form.keterangan" placeholder="Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <a class="btn btn-danger" href="javascript:void(0)" wire:click="delete">Delete</a>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" form="{{ $rekening->id }}form" value="Edit" />
            </div>
        </div>
    </div>
</div>
