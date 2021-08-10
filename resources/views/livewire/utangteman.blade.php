    @section('title', 'Your Friend Debt - My Finance')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-white">Your Friends Debt </h1>
            @if (auth()->user()->rekenings->isNotEmpty())
                <a href="#" data-toggle="modal" data-target="#addRekening"
                    class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Add Your Friends Debt </a>
            @endif
        </div>
        <div class="row mobile">
            <!-- Income (Monthly) Card Example -->
            @if (!$utangs->isEmpty())
                <div class="small-when-0 col-xl-3 col-md-6 mb-4">
                    <div class="bg-gray-100 border-0 card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Friends Debt </div>
                                    <div class="h7 mb-0 font-weight-bold text-success">Rp.
                                        {{ number_format(Auth::user()->totalutangteman()) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-donate fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @livewire('partials.no-data', ['message' => 'No debts'])
            @endif
            @if (auth()->user()->rekenings->isEmpty())
                @livewire('partials.newaccount')
            @endif
        </div>
        <!-- DataTales Example -->
        <div class="bg-dark border-0 card shadow mb-4">
            <div class="bg-gray-100 border-0 card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Debt</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%" cellspacing="0" class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th>Debt from who</th>
                                <th>Total</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($utangs as $utang)
                                @livewire('utangteman.edit',['utang'=> $utang])
                                <tr>
                                    <td>{{ $utang->nama }}</td>
                                    <td>Rp. {{ number_format($utang->jumlah) }}</td>
                                    <td>{{ $utang->keterangan ?? '-' }}</td>
                                    <td>{{ $utang->created_at->format('l j F Y') }}</td>
                                    <td> <button data-toggle="modal" data-target="#editmodal-{{ $utang->id }}"
                                            type="button" class="btn btn-info btn-circle">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No debts</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->
        @livewire('utangteman.create')
    </div>
