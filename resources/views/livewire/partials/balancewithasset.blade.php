<div class="small-when-0 col-xl-3 col-md-6 mb-4">
    <div class="bg-gray-100 card border-left-warning border-0 shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Net Worth
                    </div>
                    <div class="h7 mb-0 font-weight-bold text-warning">Rp.
                        {{ number_format(Auth::user()->total_with_assets()) }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-landmark fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>
