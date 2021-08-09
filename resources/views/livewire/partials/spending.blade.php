                    <div class="small-when-0 col-xl-3 col-md-6 mb-4">
                        <div class="bg-gray-100 card border-0 border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Spending @if (request()->q == 2)@else
                                                (Monthly)
                                            @endif
                                        </div>
                                        <div class="h7 mb-0 font-weight-bold text-danger">Rp.
                                            {{ number_format(Auth::user()->uangkeluar($daterange)) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-funnel-dollar fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
