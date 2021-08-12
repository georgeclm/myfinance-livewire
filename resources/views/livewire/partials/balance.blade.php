<div class="small-when-0 col-xl-3 col-md-6 mb-4">
    <div class="bg-gray-100 card border-left-primary border-0 shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Balance @if (request()->q == 2)@else
                            (Monthly)@endif
                    </div>
                    <div class="h7 mb-0 @if (Auth::user()->saldoperbulan() >= 1000000000) small @endif font-weight-bold text-primary">Rp.
                        {{ number_format(Auth::user()->saldoperbulan(), 0, ',', '.') }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-coins fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>
