@section('title', 'Financial Plan - My Finance')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Financial Plan</h1>
    </div>
    <div class="row">
        <div class="col-lg-6 small-when-0">
            <!-- Dropdown Card Example -->
            <div class="bg-dark border-0 card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Add</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <ul class="list-group">
                        <a href="#" data-toggle="modal" data-target="#danaDarurat"
                            class="list-group-item list-group-item-action bg-black  d-flex align-items-center">
                            <div class="w-100 text-white">
                                <i class="fas fa-exclamation-circle text-warning mx-2"></i>Emergency
                                Fund
                            </div>
                        </a>
                        <a href="#" data-toggle="modal" data-target="#DanaMembeliBarang"
                            class="list-group-item list-group-item-action bg-black d-flex align-items-center">
                            <div class="w-100 text-white">
                                <i class="fas fa-shopping-basket text-warning mx-2"></i>Fund for
                                Stuff
                            </div>
                        </a>
                        {{-- <a href="#"
                                            class="list-group-item list-group-item-action bg-black d-flex align-items-center">
                                            <div class="w-100 text-white">
                                                <i class="fas fa-umbrella-beach text-success mx-2"></i>Dana Liburan
                                            </div>
                                        </a> --}}
                        <a href="#" data-toggle="modal" data-target="#DanaMenabung"
                            class="list-group-item list-group-item-action bg-black d-flex align-items-center">
                            <div class="w-100 text-white">
                                <i class="fas fa-piggy-bank text-primary mx-2"></i>Savings Fund
                            </div>
                        </a>
                    </ul>
                </div>
            </div>
            <!-- Project Card Example -->
            <div class="bg-dark card shadow mb-4 border-0">
                <div class="bg-gray-100 card-header py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Realised</h6>
                </div>
                <div class="card-body p-2 bg-success ">
                    @forelse (auth()->user()->financialplans as $financialplan)
                        @if ($financialplan->jumlah >= $financialplan->target)
                            <div class="pt-4 rounded mb-3">
                                <div class="text-center font-weight-bold text-white">
                                    {{ $financialplan->produk }}
                                </div>
                                <div class="progress mb-1">
                                    <div role="progressbar" style="width: {{ $financialplan->persen() }}%"
                                        aria-valuenow="{{ $financialplan->persen() }}" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar bg-primary">
                                    </div>
                                </div>
                                <h4 class="small font-weight-bold text-white">Rp.
                                    {{ number_format($financialplan->jumlah) }}<span class="float-right">Rp.
                                        {{ number_format($financialplan->target) }}</span>
                                </h4>
                                <div class="text-center  font-weight-bold text-white"> Rp.
                                    {{ number_format($financialplan->perbulan) }} /Month
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr style="border-color: white !important" class="my-0">
                            @endif
                        @endif
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-6 small-when-0  mb-4">
            <!-- Project Card Example -->
            <div class="bg-dark card shadow mb-4 border-0">
                <div class="bg-gray-100 card-header py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-danger">In Progress</h6>
                </div>
                <div class="card-body p-2">
                    @forelse (auth()->user()->financialplans as $financialplan)
                        @if ($financialplan->jumlah < $financialplan->target)
                            {{-- @include('financialplan.delete') --}}
                            @livewire($financialplan->edit(),['financialplan'=> $financialplan])
                            <div class="pt-4 rounded mb-3">
                                <div class="text-center font-weight-bold text-white">
                                    {{ $financialplan->produk }}
                                </div>
                                <h4 class="small font-weight-bold text-white">
                                    {{ $financialplan->nama }}
                                    <span class="float-right">
                                        <div class="dropdown ml-2">
                                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <div class=" bg-dark border-0  dropdown-menu"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-white" href="/investments">Invest</a>
                                                <a data-toggle="modal"
                                                    data-target="#editmodal-{{ $financialplan->id }}"
                                                    class="dropdown-item text-white" href="#">Adjust</a>
                                                {{-- <a class="dropdown-item text-white" href="#">Detail
                                                                </a> --}}
                                                {{-- <a data-toggle="modal"
                                                                    data-target="#deletemodal-{{ $financialplan->id }}"
                                                                    class="dropdown-item text-white" href="#">Hapus</a> --}}
                                            </div>
                                        </div>
                                    </span>
                                </h4>
                                <div class="progress mb-1">
                                    <div role="progressbar" style="width: {{ $financialplan->persen() }}%"
                                        aria-valuenow="{{ $financialplan->persen() }}" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar bg-primary">
                                    </div>
                                </div>
                                <h4 class="small font-weight-bold text-white">Rp.
                                    {{ number_format($financialplan->jumlah) }}<span class="float-right">Rp.
                                        {{ number_format($financialplan->target) }}</span>
                                </h4>
                                <div class="text-center  font-weight-bold text-white"> Rp.
                                    {{ number_format($financialplan->perbulan) }} /Month
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr style="border-color: white !important" class="my-0">
                            @endif
                        @endif
                    @empty
                        <div class="bg-black p-4 rounded mb-3">
                            <div class="text-center font-weight-bold text-white">
                                Create Financial Plan
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @livewire('financialplan.create-dana-darurat')
    @livewire('financialplan.create-dana-menabung')
    @livewire('financialplan.create-dana-membeli-barang')
</div>
