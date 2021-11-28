    @section('title', 'Your Friend Debt - My Finance')
    <div class="container-fluid small-when-0">
        <!-- Page Heading -->
        <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-white">Your Friends Debt </h1>
            @if (auth()->user()->rekenings->isNotEmpty())
                <button onclick="showModal('create-friend-debt')"
                    class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Add Your Friends Debt </button>
            @endif
        </div>
        <div class="row px-2 ml-0">
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
                                        {{ number_format(Auth::user()->totalutangteman(), 0, ',', '.') }}
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
            @if (auth()->user()->rekenings()->count() == 0)
                @livewire('partials.newaccount')
            @endif
        </div>

        <div class="bg-dark border-0 card shadow mb-4">
            <div class="bg-gray-100 border-0 card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Debt</h6>
            </div>
            <div class="card-body">
                @forelse ($utangs as $utang)
                    @livewire('utangteman.edit',['utang'=> $utang])

                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-warning">{{ $utang->nama }} - Rp.
                            {{ number_format($utang->jumlah, 0, ',', '.') }}
                        </h6>
                        <button onclick="showModal('edit-friend-debt-{{ $utang->id }}')"
                            class="btn btn-sm btn-info btn-circle">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                    <!-- Card Body -->
                    <div class="text-white my-3 mx-0">
                        <div class="d-flex ">
                            <div class="flex-grow-1">
                                {{ $utang->created_at->format('l j F Y') }}
                                <br>
                                {{ $utang->keterangan ?? '-' }}
                            </div>

                        </div>
                    </div>
                    <hr class="bg-white my-1">
                @empty
                    <div class="text-center font-weight-bold text-white-50">
                        No Friends Debt
                    </div>
                @endforelse
            </div>
        </div>
        <!-- End of Main Content -->
        @livewire('utangteman.create')
        <br><br><br><br><br><br><br>

    </div>
