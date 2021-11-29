@section('title', "{$rekening->nama_akun} - My Finance")
<div class="container-fluid small-when-0">
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">{{ $rekening->nama_akun }}</h1>
    </div>
    <div class="row mobile">
        <div class="small-when-0 col-xl-12 col-md-12 mb-4">
            <div class="bg-gray-100 border-0 card shadow h-100 py-2 border-bottom-warning">
                <div class="h3 fw-bold text-info card-body text-center">
                    <input wire:model="daterange" class="form-control picker_select" style="text-align:center;"
                        type="text" readonly name="daterange" onchange="this.dispatchEvent(new InputEvent('input'))" />
                </div>
            </div>
        </div>
    </div>
    <div class="bg-dark border-0 card shadow mb-4">
        <div class="bg-gray-100 border-0 card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transaction</h6>
        </div>
        <div id="preloader" wire:loading>
            <div id="loader"></div>
            <br><br><br>
        </div>
        <div class="card-body" wire:loading.remove>
            @forelse ($transactions as $transaction)
                <div class="pt-3 pb-0 d-flex flex-row align-items-center justify-content-between">
                    <div class="flex-grow-1">

                        <h6 class="m-0 font-weight-bold {{ $transaction->jenisuang->textColor() }}">
                            @switch($transaction->jenisuang_id)
                                @case(1)
                                    {{ $transaction->category_masuk->nama }}
                                @break
                                @case(2)
                                    {{ $transaction->category->nama }}
                                @break
                                @case(3)
                                    Transfer
                                @break
                                @case(4)
                                    Pay Debt
                                    {{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                                @break
                                @default
                                    Friend Pay Debt
                                    {{ Str::limit($transaction->utangteman->keterangan, 15, $end = '...') ?? $transaction->utangteman->nama }}
                            @endswitch - Rp.
                            {{ number_format($transaction->jumlah, 0, ',', '.') }}
                        </h6>
                    </div>
                    @if (in_array($transaction->jenisuang_id, [1, 2]) && $transaction->rekening->nama_akun != 'Pocket Deleted')
                        <a href="javascript:void(0)" wire:click="refundModal({{ $transaction->id }})"
                            class="btn btn-sm btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                            <span class="text only-big">Refund</span>
                        </a>
                    @endif
                </div>
                <div class="text-white my-3 mx-0">
                    <div class="d-flex ">
                        <div class="flex-grow-1">
                            {{ Str::limit($transaction->keterangan, 15, $end = '...') ?? '-' }}
                            <br>
                            {{ $transaction->rekening->nama_akun }}
                            @if ($transaction->jenisuang_id == 3)
                                to
                                {{ $transaction->rekening_tujuan->nama_akun }}
                            @endif
                        </div>
                        <span class="mobile-small">{{ $transaction->created_at->format('l j M') }}</span>
                    </div>
                </div>
                <hr class="bg-white my-1">
                @empty
                    <div class="text-center font-weight-bold text-white-50">
                        Empty
                    </div>
                @endforelse
            </div>
        </div>
        <div class="modal__container" wire:ignore.self id="editModal">
            <div class="bg-black modal__content">
                <div class="border-0 modal-header">
                    <h5 class="modal-title text-white">Revert The Transaction?</h5>
                    <button class="close text-white" onclick="closeModal('editModal')">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-white">Transaction Will be Reverted and Rp.
                    {{ number_format($jumlah, 0, ',', '.') }} will
                    @if (@$jenisuang_id == 2) be refunded to your pocket. @else be deducted from your pocket. @endif
                </div>
                <div class="modal-footer border-0">
                    <a class="btn btn-warning btn-block" href="javascript:void(0)" wire:click="revert">Revert</a>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br><br>
    </div>
