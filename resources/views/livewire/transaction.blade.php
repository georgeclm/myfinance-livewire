@section('title', 'Transaction - My Finance')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Financial Records</h1>
        @if (!auth()->user()->rekenings->isEmpty())
            <a href="#" data-toggle="modal" data-target="#addRekening"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Transaction</a>
        @endif
    </div>
    <div class="row mobile">
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
                                {{ number_format($income,0,',','.') }}
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
                        <div class="modal-body text-white">Total {{ now()->format('F') }} Income (Sell Investment Not
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
                                {{ number_format($spending,0,',','.') }}
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
                        <div class="modal-body text-white">Total {{ now()->format('F') }} Spending
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
                            <div
                                class="h7 mb-0 @if ($balance >= 1000000000) small @endif font-weight-bold text-primary">
                                Rp.
                                {{ number_format($balance,0,',','.') }}
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
        <div class="small-when-0 col-xl-12 col-md-12 mb-4">
            <div class="bg-gray-100 border-0 card shadow h-100 py-2 border-bottom-warning">
                <div class="h3 fw-bold text-info card-body text-center">
                    <input wire:model="daterange" class="form-control picker_select" style="text-align:center;"
                        type="text" readonly name="daterange" onchange="this.dispatchEvent(new InputEvent('input'))" />
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
        <div class="card-body">
            @forelse ($transactions as $transaction)
                <div class="pt-3 pb-0 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold {{ $transaction->jenisuang->textColor() }}">
                        @if ($transaction->jenisuang_id == 1)
                            {{ $transaction->category_masuk->nama }}
                        @elseif($transaction->jenisuang_id == 2)
                            {{ $transaction->category->nama }}
                        @elseif ($transaction->jenisuang_id == 4)
                            Pay Debt
                            {{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                        @elseif ($transaction->jenisuang_id == 5)
                            Friend Pay Debt
                            {{ Str::limit($transaction->utangteman->keterangan, 15, $end = '...') ?? $transaction->utangteman->nama }}
                        @elseif ($transaction->jenisuang_id == 3)
                            Transfer
                        @endif - Rp.
                        {{ number_format($transaction->jumlah, 0, ',', '.') }}
                    </h6>
                </div>
                <div class="text-white my-3 mx-0">
                    <div class="d-flex ">
                        <div class="flex-grow-1">
                            {{ Str::limit($transaction->keterangan, 15, $end = '...') ?? '-' }}
                            <br>
                            {{ $transaction->rekening->nama_akun ?? 'Pocket deleted' }}
                            @if ($transaction->jenisuang_id == 3)
                                to
                                {{ isset($transaction->rekening_tujuan) ? $transaction->rekening_tujuan->nama_akun : 'Pocket deleted' }}
                            @endif
                        </div>
                        <span class="mobile-small">{{ $transaction->created_at->format('l j F') }}</span>
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
</div>

@section('style')
    <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/data-tables.css') }}" rel="stylesheet">

@endsection
