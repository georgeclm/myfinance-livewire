@section('title', 'Transaction - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Financial Records</h1>
        @if (!auth()->user()->rekenings->isEmpty())
            <button onclick="showModal('createTransaction')"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Transaction</button>
        @endif
    </div>
    <div class="row px-2 ml-0">
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 card border-left-success border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Income
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#incomeModal">
                                    <i class="fas fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="h7 mb-0 @if ($income >= 1000000000) small @endif font-weight-bold text-success">Rp.
                                {{ number_format($income, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="incomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Income</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Total Income and Total Gain In All Investment Based on
                            Date. (Sell Investment Not
                            Included)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 card border-0 border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Spending
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#spendingModal">
                                    <i class="fas fa-question-circle"></i>
                                </a>

                            </div>
                            <div
                                class="h7 mb-0 @if ($spending >= 1000000000) small @endif
                                font-weight-bold text-danger">
                                Rp.
                                {{ number_format($spending, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-funnel-dollar fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="spendingModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Spending</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Total Spending and Total Loss In All Investment Based on
                            Date.
                            (Investment is not included)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 card border-left-primary border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Balance
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#balanceModal">
                                    <i class="fas fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="h7 mb-0 @if ($balance >= 1000000000) small @endif font-weight-bold text-primary">
                                Rp.
                                {{ number_format($balance, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="balanceModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Balance</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Income - Spending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 card border-left-warning border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Buying Power
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#buyingpower">
                                    <i class="fas fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="h7 mb-0 @if (Auth::user()->total_with_assets() / 10 >= 1000000000) small @endif font-weight-bold text-warning">
                                Rp.
                                {{ number_format(Auth::user()->total_with_assets() / 10, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="buyingpower" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Buying Power</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Your 1:10 Net Worth. If you can't afford it dont buy.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-when-0 col-xl-12 col-md-12 mb-4">
            <div class="bg-gray-100 border-0 card shadow h-100 py-2 border-bottom-warning">
                <div class="h3 fw-bold text-info card-body text-center">
                    <input wire:model="daterange" class="form-control" type="text" readonly
                        onchange="this.dispatchEvent(new InputEvent('input'))" style="text-align:center;"
                        name="daterange" />
                </div>
            </div>
        </div>
        @if (auth()->user()->rekenings->isEmpty())
            @livewire('partials.newaccount')
        @endif
    </div>
    <!-- DataTales Example -->
    <div class="bg-dark border-0 card shadow mb-4">
        <div class="bg-gray-100 border-0 card-header py-3">
            <h6 class="font-weight-bold text-primary">Transaction</h6>
        </div>
        <div id="preloader" wire:loading>
            <div id="loader"></div>
            <br><br><br>
        </div>
        <div class="card-body" wire:loading.remove>
            @forelse ($transactions as $transaction)
                <div class="modal__container" wire:ignore id="refund-{{ $transaction->id }}">
                    <div class="bg-black modal__content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Revert The Transaction?</h5>
                            <button class="close text-white" onclick="closeModal('refund-{{ $transaction->id }}')">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Transaction Will be Reverted and Rp.
                            {{ number_format($transaction->jumlah, 0, ',', '.') }} will
                            @if ($transaction->jenisuang_id == 2) be refunded to your pocket. @else be deducted from your pocket. @endif
                        </div>
                        <div class="modal-footer border-0">
                            <a class="btn btn-warning btn-block" href="javascript:void(0)"
                                wire:click="revert({{ $transaction->id }})">Revert</a>
                        </div>
                    </div>
                </div>

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
                    @if (in_array($transaction->jenisuang_id, [1, 2]))
                        <a href="javascript:void(0)" onclick="showModal('refund-{{ $transaction->id }}')"
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

                        <span
                            class="mobile-small">{{ $transaction->created_at->toDateString() == now()->toDateString() ? 'Today' : $transaction->created_at->format('l j M') }}</span>
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
        @livewire('transaction.create',['jenisuangs' => $jenisuangs])
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
    </div>
