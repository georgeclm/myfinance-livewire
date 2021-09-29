@section('title', 'Home - My Finance')

<div class="container-fluid">
    {{-- <h1>{{ $new_user }}</h1> --}}
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
                <a class="card bg-dark border-0" href="{{ route('utangteman') }}" style="max-width: 69px; line-height: 80% !important">
                    <div class="card-body text-center p-2">
                        <i class="fas fa-fw fa-bomb"></i><br>
                        <small style="font-size: 10px">Friend&nbspDebt</small>
                    </div>
                </a>
                <a class="card bg-dark border-0" href="{{ route('utang') }}" style="max-width: 69px; line-height: 80% !important">
                    <div class="card-body text-center p-2">
                        <i class="fas fa-fw fa-biohazard"></i><br>
                        <span style="font-size: 10px; " class="d-sm-inline">Your Debt</span>
                    </div>
                </a>
                <a class="card bg-dark border-0" href="{{ route('cicilan') }}"
                    style="max-width: 69px; line-height: 80% !important; word-wrap:normal;">
                    <div class="card-body text-center p-2">
                        <i class="fas fa-fw fa-redo-alt"></i>
                        <span style="font-size: 10px" class="d-sm-inline">Repetition</span>
                    </div>
                </a>
            </div>
        </div>
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
                                {{ number_format($income, 0, ',', '.') }}</div>
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
                        <div class="modal-body text-white">Total {{ now()->format('F') }} Income and Total Gain In All Investment.
                            (Sell Investment Not Included)</div>
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
                                <a href="javascript:void(0)" data-toggle="modal"
                                    data-target="#spendingModal">
                                    <i class="fas fa-question-circle"></i>
                                </a>

                            </div>
                            <div
                                class="h7 mb-0 @if ($spending >= 1000000000) small @endif
                                font-weight-bold text-danger">
                                Rp.
                                {{ number_format($spending, 0, ',', '.') }}
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
                            <button class="close text-white" type="button" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Total {{ now()->format('F') }} Spending and Total Loss In All Investment.
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
                            <div class="h7 mb-0 @if ($balance >= 1000000000) small @endif font-weight-bold text-primary">Rp.
                                {{ number_format($balance, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="balanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
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
        @livewire('partials.balancewithasset')
    </div>

    <div class="row mobile">
        @if (auth()->user()->all_transactions->count() != 0)
            <div class="col-xl-8 col-lg-7 small-when-0">
                <div class="bg-dark card shadow mb-4 border-0">
                    <div class="bg-gray-100 card-header py-3 border-0">
                        <h6 class="m-0 font-weight-bold text-primary">Income vs Spending Chart</h6>
                    </div>
                    <div class="card-body small-when-0"><br>
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!auth()->user()->rekenings->isEmpty())
            <div class="col-xl-4 col-lg-5 small-when-0">
                <div class="bg-dark card shadow mb-4 border-0">
                    <!-- Card Header - Dropdown -->
                    <div class="bg-gray-100 card-header py-3 border-0">
                        <h6 class="m-0 font-weight-bold text-primary">Asset Allocation</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4">
                            <canvas id="myPieChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        @if ($spending != 0)
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
                            @if ($category->persen() != 0 && $category->nama != 'Investment')
                                <h4 class="small font-weight-bold text-white">
                                    {{ $category->nama }}<span
                                        class="float-right">{{ $category->persen() }}%</span>
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
        @if ($income != 0)
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
                            @if ($category->persen() != 0 && $category->nama != 'Sell Investment')
                                <h4 class="small font-weight-bold text-white">
                                    {{ $category->nama }}<span
                                        class="float-right">{{ $category->persen() }}%</span>
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

        @if ($new_user == 1)
            <div class="modal fade" id="new-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="bg-dark modal-content">
                        <div class="border-0 modal-header">
                            <h5 class="modal-title text-white">Welcome To MyFinance</h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-white">Start Create Your First Pocket to Use The App</div>
                        <div class="modal-footer border-0">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="{{ route('rekening') }}">Pocket</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <!-- /.container-fluid -->
</div>
@section('script')
    <script src="{{ asset('js/chart.js/Chart.min.js') }}" data-turbolinks-track="true"></script>
    <script>

        @if (auth()->user()->all_transactions->count() != 0)

        var x = window.matchMedia("(max-width: 700px)");
        if (x.matches) {
            var size = 10;
        } else {
            var size = 12;
        }
        // Set new default font family and font color to mimic Bootstrap's default styling
        (Chart.defaults.global.defaultFontFamily = "Nunito"),
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = "#858796";

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + "").replace(",", "").replace(" ", "");
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === "undefined" ? "." : thousands_sep,
                dec = typeof dec_point === "undefined" ? "," : dec_point,
                s = "",
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return "" + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || "").length < prec) {
                s[1] = s[1] || "";
                s[1] += new Array(prec - s[1].length + 1).join("0");
            }
            return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var x = window.matchMedia("(max-width: 700px)");

        var myLineChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "{{ substr(
    now()->subMonth(4)->format('F'),
    0,
    3,
) }}",
                    "{{ substr(
    now()->subMonth(3)->format('F'),
    0,
    3,
) }}",
                    "{{ substr(
    now()->subMonth(2)->format('F'),
    0,
    3,
) }}",
                    "{{ substr(
    now()->subMonth(1)->format('F'),
    0,
    3,
) }}",
                    "{{ substr(now()->format('F'), 0, 3) }}",
                ],
                datasets: [{
                        label: "Spending",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "#e74a3b",
                        pointRadius: 3,
                        pointBackgroundColor: "#e74a3b",
                        pointBorderColor: "#e74a3b",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#e74a3b",
                        pointHoverBorderColor: "#e74a3b",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [
                            "{{ auth()->user()->uangkeluar_by_month(4) }}",
                            "{{ auth()->user()->uangkeluar_by_month(3) }}",
                            "{{ auth()->user()->uangkeluar_by_month(2) }}",
                            "{{ auth()->user()->uangkeluar_by_month(1) }}",
                            "{{ $spending }}",
                        ],
                    },
                    {
                        label: "Income",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "#1cc88a",
                        pointRadius: 3,
                        pointBackgroundColor: "#1cc88a",
                        pointBorderColor: "#1cc88a",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#1cc88a",
                        pointHoverBorderColor: "#1cc88a",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [
                            "{{ auth()->user()->uangmasuk_by_month(4) }}",
                            "{{ auth()->user()->uangmasuk_by_month(3) }}",
                            "{{ auth()->user()->uangmasuk_by_month(2) }}",
                            "{{ auth()->user()->uangmasuk_by_month(1) }}",
                            "{{ $income }}",
                        ],
                    }
                ],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        time: {
                            unit: "date",
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            maxTicksLimit: 7,
                        },
                    }, ],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            fontSize: size,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return "Rp." + number_format(value);
                            },
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2],
                        },
                    }, ],
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: "index",
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return (
                                datasetLabel +
                                ": Rp." +
                                number_format(tooltipItem.yLabel)
                            );
                        },
                    },
                },
            },
        });
        @endif

        // Pie Chart Example
        @if (!auth()->user()->rekenings->isEmpty())

            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
            labels: ["Deposito", "Mutual Funds (Reksadana)", "Stock", "P2P", 'Cash'],
            datasets: [{
            data: ["{{ auth()->user()->deposito_persen() }}",
            "{{ auth()->user()->mutualfund_persen() }}",
            "{{ auth()->user()->stock_persen() }}",
            "{{ auth()->user()->p2p_persen() }}",
            "{{ auth()->user()->saldo_persen() }}"
            ],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e02d1b'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            borderWidth: [0, 0, 0, 0, 0]
            }],
            },
            options: {
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
            display: true,
            position: 'bottom',
            },
            cutoutPercentage: 80,
            },
            });
        @endif
    </script>

@endsection
