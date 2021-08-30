<div class="small-when-0 col-xl-3 col-md-6 mb-4">
    <div class="bg-gray-100 card border-left-success border-0 shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Income
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
                            title="Total {{ now()->format('F') }} Income">
                            <i class="fas fa-question-circle"></i>
                        </a>
                    </div>
                    <div class="h7 mb-0 @if (Auth::user()->uangmasuk() >= 1000000000) small @endif font-weight-bold text-success">Rp.
                        {{ number_format(Auth::user()->uangmasuk(), 0, ',', '.') }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-money-bill-wave-alt fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>
