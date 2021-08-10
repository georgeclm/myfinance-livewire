@section('title', 'Home - My Finance')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class=" d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-white">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>
    <!-- Content Row -->
    <div class="row mobile">
        <div class="col-lg-6 small-when-0 mb-3 this_small">
            <!-- Project Card Example -->
            <div class="d-flex align-items-center justify-content-between">
                <a class="card bg-dark border-0" href="/frdebts" style="max-width: 69px; line-height: 80% !important">
                    <div class="card-body text-center p-2">
                        <i class="fas fa-fw fa-bomb"></i><br>
                        <small style="font-size: 10px">Friend&nbspDebt</small>
                    </div>
                </a>
                <a class="card bg-dark border-0" href="/debts" style="max-width: 69px; line-height: 80% !important">
                    <div class="card-body text-center p-2">
                        <i class="fas fa-fw fa-biohazard"></i><br>
                        <span style="font-size: 10px; " class="d-sm-inline">Your Debt</span>
                    </div>
                </a>
                <a class="card bg-dark border-0" href="/repetitions"
                    style="max-width: 69px; line-height: 80% !important; word-wrap:normal;">
                    <div class="card-body text-center p-2">
                        <i class="fas fa-fw fa-redo-alt"></i>
                        <span style="font-size: 10px" class="d-sm-inline">Repetition</span>
                    </div>
                </a>
            </div>
        </div>
        @livewire('partials.income')
        @livewire('partials.spending')
        @livewire('partials.balance')
        @livewire('partials.balancewithasset')
    </div>

    <div class="row mobile">
        @if (auth()->user()->uangkeluar() != 0)
            <!-- Content Column -->
            <div class="small-when-0 col-lg-6 mb-4">
                <!-- Project Card Example -->
                <div class="bg-dark card shadow mb-4 border-0">
                    <div class="bg-gray-100 card-header py-3 border-0">
                        <h6 class="m-0 font-weight-bold text-danger">{{ now()->format('F') }}
                            Spending
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach ($categories as $category)
                            @if ($category->persen() != 0)
                                <h4 class="small font-weight-bold text-white">
                                    {{ $category->nama }}<span class="float-right">{{ $category->persen() }}%</span>
                                </h4>
                                <div class="progress mb-4">
                                    <div role="progressbar" style="width: {{ $category->persen() }}%"
                                        aria-valuenow="{{ $category->persen() }}" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar {{ $category->bgColor() }}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            @livewire('partials.no-data',['message' => 'Start Writting Records'])
        @endif
        @if (auth()->user()->uangmasuk() != 0)
            <!-- Content Column -->
            <div class="col-lg-6 small-when-0  mb-4">
                <!-- Project Card Example -->
                <div class="bg-dark card shadow mb-4 border-0">
                    <div class="bg-gray-100 card-header py-3 border-0">
                        <h6 class="m-0 font-weight-bold text-success">{{ now()->format('F') }}
                            Income
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach ($category_masuks as $category)
                            @if ($category->persen() != 0)
                                <h4 class="small font-weight-bold text-white">
                                    {{ $category->nama }}<span class="float-right">{{ $category->persen() }}%</span>
                                </h4>
                                <div class="progress mb-4">
                                    <div role="progressbar" style="width: {{ $category->persen() }}%"
                                        aria-valuenow="{{ $category->persen() }}" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar {{ $category->bgColor() }}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- /.container-fluid -->
</div>
