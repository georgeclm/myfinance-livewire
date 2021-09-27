@section('title', "{$rekening->nama_akun} - My Finance")
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
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
</div>
@section('script')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
