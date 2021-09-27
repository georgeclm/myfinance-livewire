@section('title', 'Your Debt - My Finance')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Your Debt</h1>
        @if (auth()->user()->rekenings->isNotEmpty())
            <a href="#" data-toggle="modal" data-target="#addRekening"
                class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Your Debt</a>
        @endif
    </div>
    <div class="row mobile">
        @if (Auth::user()->totalutang() != 0)
            <!-- Income (Monthly) Card Example -->
            <div class="small-when-0 col-xl-3 col-md-6 mb-4">
                <div class="bg-gray-100 border-0 card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Total Debt</div>
                                <div class="h7 mb-0 font-weight-bold text-danger">Rp.
                                    {{ number_format(Auth::user()->totalutang(), 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @livewire('partials.no-data', ['message' => 'You dont have any debts'])
        @endif
        @if (auth()->user()->rekenings()->count() == 0)
            @livewire('partials.newaccount')
        @endif
    </div>
    <!-- DataTales Example -->
    <div class="bg-dark border-0 card shadow mb-4">
        <div class="bg-gray-100 border-0 card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Your Debt</h6>
        </div>
        <div class="card-body">
            @forelse (auth()->user()->utangs as $utang)
                @livewire('utang.edit',['utang'=> $utang])

                <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ $utang->nama }} - Rp.
                        {{ number_format($utang->jumlah, 0, ',', '.') }}
                    </h6>
                    <button data-toggle="modal" data-target="#editmodal-{{ $utang->id }}" type="button"
                        class="btn btn-sm btn-info btn-circle">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </div>
                <!-- Card Body -->
                <div class="text-white my-3 mx-0">
                    <div class="d-flex ">
                        <div class="flex-grow-1">
                            {{ $utang->created_at->format('l j F Y') }}
                            {{-- {{ $utang->keterangan ?? '-' }} --}}
                        </div>

                    </div>
                </div>
                <hr class="bg-white my-1">
            @empty
                <div class="text-center font-weight-bold text-white-50">
                    No Debt
                </div>
            @endforelse
        </div>
    </div>

    @livewire('utang.create')
</div>
