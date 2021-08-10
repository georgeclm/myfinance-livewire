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
        @livewire('partials.income')
        @livewire('partials.spending',['daterange' => $daterange])
        @livewire('partials.balance')
        <div class="small-when-0 col-xl-12 col-md-12 mb-4">
            <div class="bg-gray-100 border-0 card shadow h-100 py-2 border-bottom-warning">
                <div class="h3 fw-bold text-info card-body text-center">
                    <input wire:model="daterange" class="form-control picker_select" style="text-align:center;"
                        type="text" name="daterange" onchange="this.dispatchEvent(new InputEvent('input'))" />
                </div>
            </div>
        </div>
        @if (auth()->user()->rekenings->isEmpty())
            @livewire('partials.newaccount')
        @endif
    </div>
    @foreach ($jenisuangs as $jenisuang)
        <!-- DataTales Example -->
        <div class="bg-dark border-0 card shadow mb-4">
            <div class="bg-gray-100 border-0 card-header py-3">
                <h6 class="font-weight-bold text-primary">{{ $jenisuang->nama }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="wrap-table100 " id="thetable">
                        <div class="table">
                            @forelse ($jenisuang->user_transactions($q,$daterange)->take(5) as $transaction)
                                <div class="row">
                                    <div class="cell {{ $jenisuang->textColor() }}" data-title="Jumlah">
                                        Rp. {{ number_format($transaction->jumlah) }}
                                    </div>
                                    @if ($jenisuang->id == 4)
                                        <div class="cell text-white" data-title="Nama Utang">
                                            {{ $transaction->utang->keterangan ?? $transaction->utang->nama }}
                                        </div>
                                    @endif
                                    @if ($jenisuang->id == 5)
                                        <div class="cell text-white" data-title="Nama Utang">
                                            {{ $transaction->utangteman->keterangan ?? $transaction->utangteman->nama }}
                                        </div>
                                    @endif
                                    @if ($jenisuang->id == 1)
                                        <div class="cell text-white" data-title="Kategori">
                                            {{ $transaction->category_masuk->nama }}
                                        </div>
                                    @endif
                                    @if ($jenisuang->id == 2)
                                        <div class="cell text-white" data-title="Kategori">
                                            {{ $transaction->category->nama }}
                                        </div>
                                    @endif
                                    <div class="cell text-white" data-title="Akun">
                                        {{ isset($transaction->rekening) ? $transaction->rekening->nama_akun : 'Pocket deleted' }}
                                    </div>
                                    @if ($jenisuang->id == 3)
                                        <div class="cell text-white" data-title="Akun Tujuan">
                                            {{ isset($transaction->rekening_tujuan) ? $transaction->rekening_tujuan->nama_akun : 'Pocket deleted' }}
                                        </div>
                                    @endif
                                    <div class="cell text-white" data-title="Keterangan">
                                        {{ $transaction->keterangan ?? '-' }}
                                    </div>
                                    <div class="cell text-white" data-title="Tanggal">
                                        {{ $transaction->created_at->format('l j F Y') }}
                                    </div>
                                </div>
                            @empty
                                <div class="row">
                                    <div class="cell">
                                        Records Empty
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <table class="table table-bordered table-dark" id="dataTable{{ $jenisuang->id }}" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr class="{{ $jenisuang->color() }} text-light">
                                <th>Total</th>
                                @if (in_array($jenisuang->id, [4, 5]))
                                    <th>Debt Name</th>
                                @endif

                                @if (in_array($jenisuang->id, [1, 2]))
                                    <th>Category</th>
                                @endif
                                <th>Pocket</th>
                                @if ($jenisuang->id == 3)
                                    <th>Pocket Destination</th>
                                @endif
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisuang->user_transactions($q,$daterange)->take(5) as $transaction)
                                <tr>
                                    <td>Rp {{ number_format($transaction->jumlah) }}</td>
                                    @if ($jenisuang->id == 4)
                                        <td>{{ $transaction->utang->keterangan ?? $transaction->utang->nama }}
                                        </td>
                                    @endif
                                    @if ($jenisuang->id == 5)
                                        <td>{{ $transaction->utangteman->keterangan ?? $transaction->utangteman->nama }}
                                        </td>
                                    @endif
                                    @if ($jenisuang->id == 1)
                                        <td>{{ $transaction->category_masuk->nama }}</td>
                                    @endif
                                    @if ($jenisuang->id == 2)
                                        <td>{{ $transaction->category->nama }}</td>
                                    @endif
                                    <td>{{ isset($transaction->rekening) ? $transaction->rekening->nama_akun : 'Pocket deleted' }}
                                    </td>
                                    @if ($jenisuang->id == 3)
                                        <td>{{ isset($transaction->rekening_tujuan) ? $transaction->rekening_tujuan->nama_akun : 'Pocket deleted' }}
                                        </td>
                                    @endif
                                    <td>{{ $transaction->keterangan ?? '-' }}</td>
                                    <td>{{ $transaction->created_at->format('l j F Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Records Empty</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    @if ($jenisuang->user_transactions($q, $daterange)->count() > 5)
                        <div class="text-end mt-3"><a href="/transactions/{{ $jenisuang->id }}">Show
                                All</a></div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    @livewire('transaction.create',['jenisuangs' => $jenisuangs])
</div>

@section('style')
    <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/data-tables.css') }}" rel="stylesheet">

@endsection
