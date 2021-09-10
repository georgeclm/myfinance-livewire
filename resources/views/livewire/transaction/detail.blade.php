@section('title', "{$jenisuang->nama} - My Finance")
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">{{ $jenisuang->nama }}</h1>
    </div>
    <div class="row mobile">
        @livewire('partials.income')
        @livewire('partials.spending')
        @livewire('partials.balance')
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
    <div class="bg-dark border-0 card shadow mb-4">
        <div class="bg-gray-100 border-0 card-header py-3">
            <div class="row align-items-baseline">
                <div class="col-md-5">
                    <h6 class="font-weight-bold text-primary">{{ $jenisuang->nama }}</h6>
                </div>
                <div class="col-md-5 my-2">
                    <h6 class="font-weight-bold text-primary">Rp.
                        {{ number_format($total, 0, ',', '.') }}
                    </h6>
                </div>
                @if ($jenisuang->id == 2)
                    <div class="col-md-2">
                        {{-- <input type="hidden" wire:model="q" value="{{ request()->q }}"> --}}
                        <select wire:model="search" class="form-control form-control-user" onchange="$wire.render()">
                            <option value="0" selected>Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($jenisuang->id == 1)
                    <div class="col-md-2">
                        {{-- <input type="hidden" wire:model="q" value="{{ request()->q }}"> --}}
                        <select wire:model="search2" class="form-control form-control-user">
                            <option value="0" selected>Category</option>
                            @foreach ($category_masuks as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="wrap-table100 " id="thetable">
                    <div class="table">
                        @forelse ($transactions as $transaction)
                            <div class="row">
                                <div class="cell {{ $jenisuang->textColor() }}" data-title="Total">
                                    Rp. {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                </div>
                                @if ($jenisuang->id == 4)
                                    <div class="cell text-white" data-title="Debt Name">
                                        {{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                                    </div>
                                @endif
                                @if ($jenisuang->id == 5)
                                    <div class="cell text-white" data-title="Debt Name">
                                        {{ Str::limit($transaction->utangteman->keterangan, 15, $end = '...') ?? $transaction->utangteman->nama }}
                                    </div>
                                @endif
                                @if ($jenisuang->id == 1)
                                    <div class="cell text-white" data-title="Category">
                                        {{ $transaction->category_masuk->nama }}
                                    </div>
                                @endif
                                @if ($jenisuang->id == 2)
                                    <div class="cell text-white" data-title="Category">
                                        {{ $transaction->category->nama }}
                                    </div>
                                @endif
                                <div class="cell text-white" data-title="Pocket">
                                    {{ isset($transaction->rekening) ? $transaction->rekening->nama_akun : 'Pocket deleted' }}
                                </div>
                                @if ($jenisuang->id == 3)
                                    <div class="cell text-white" data-title="Pocket Destination">
                                        {{ isset($transaction->rekening_tujuan) ? $transaction->rekening_tujuan->nama_akun : 'Pocket deleted' }}
                                    </div>
                                @endif
                                <div class="cell text-white" data-title="Description">
                                    {{ Str::limit($transaction->keterangan, 15, $send = '...') ?? '-' }}
                                </div>
                                <div class="cell text-white" data-title="Date">
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
                <table class="only-big table table-bordered table-dark" width="100%" cellspacing="0" id="bigtable">
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
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                                @if ($jenisuang->id == 4)
                                    <td>{{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                                    </td>
                                @endif
                                @if ($jenisuang->id == 5)
                                    <td>{{ Str::limit($transaction->utangteman->keterangan, 15, $end = '...') ?? $transaction->utangteman->nama }}
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
                                <td>{{ Str::limit($transaction->keterangan, 15, $end = '...') ?? '-' }}</td>
                                <td>{{ $transaction->created_at->format('l j F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Records Empty</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#bigtable').DataTable({
                paging: false,
                columnDefs: [{
                    type: 'formatted-num',
                    targets: 0
                }]
            });
        });
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "formatted-num-pre": function(a) {
                a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
                return parseFloat(a);
            },

            "formatted-num-asc": function(a, b) {
                return a - b;
            },

            "formatted-num-desc": function(a, b) {
                return b - a;
            }
        });
    </script>

@endsection
@section('style')
    <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/data-tables.css') }}" rel="stylesheet">

@endsection
