@section('title', "{$rekening->nama_akun} - My Finance")
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">{{ $rekening->nama_akun }}</h1>
    </div>
    <div class="row mobile">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="bg-gray-100 border-0 card shadow h-100 py-2 border-bottom-info">
                <div class="h3 fw-bold text-info card-body">
                    <select wire:model="q" class="form-control form-control-user" name="q">
                        <option value="0">This Month</option>
                        <option value="1" selected>Previous Month</option>
                        <option value="2" selected>All</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    @foreach ($jenisuangs as $jenisuang)
        <!-- DataTales Example -->
        <div class="bg-dark border-0 card shadow mb-4">
            <div class="bg-gray-100 border-0 card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $jenisuang->nama }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="wrap-table100 " id="thetable">
                        <div class="table">
                            <div class="row header">
                                <div class="cell ">
                                    Jumlah
                                </div>
                                @if (in_array($jenisuang->id, [4, 5]))
                                    <div class="cell">
                                        Nama Utang
                                    </div>
                                @endif
                                @if (in_array($jenisuang->id, [1, 2]))
                                    <div class="cell">
                                        Kategori
                                    </div>
                                @endif
                                <div class="cell">
                                    Akun
                                </div>
                                @if ($jenisuang->id == 3)
                                    <div class="cell">
                                        Akun Tujuan
                                    </div>
                                @endif
                                <div class="cell">
                                    Keterangan
                                </div>
                                <div class="cell">
                                    Tanggal
                                </div>
                            </div>
                            @forelse ($jenisuang->user_transactions($q)->where('rekening_id',$rekening->id) as $transaction)
                                <div class="row">
                                    <div class="cell {{ $jenisuang->textColor() }}" data-title="Total">
                                        Rp. {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                    </div>
                                    @if ($transaction->utang_id)
                                        <div class="cell text-white" data-title="Debt Name">
                                            {{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                                        </div>
                                    @endif
                                    @if ($transaction->utangteman_id)
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
                                        {{ Str::limit($transaction->keterangan, 15, $end = '...') }}
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
                            @forelse ($jenisuang->user_transactions($q)->where('rekening_id',$rekening->id) as $transaction)
                                <tr>
                                    <td>Rp. {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                                    @if ($transaction->utang_id)
                                        <td>{{ Str::limit($transaction->utang->keterangan, 15, $end = '...') ?? $transaction->utang->nama }}
                                        </td>
                                    @endif
                                    @if ($transaction->utangteman_id)
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
    @endforeach
</div>
@section('script')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
