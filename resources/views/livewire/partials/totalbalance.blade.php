<div class="small-when-0  col-xl-3 col-md-6 mb-4">
    <div class="bg-gray-100 card border-0 border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Total Balance
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#totalBalanceModal">
                            <i class="fas fa-question-circle"></i>
                        </a>
                    </div>
                    <div class="h7 mb-0 @if (Auth::user()->saldo() >= 1000000000) small @endif font-weight-bold text-info">Rp.
                        {{ number_format(Auth::user()->saldo(), 0, ',', '.') }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-hand-holding-usd fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="totalBalanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="bg-dark modal-content">
                <div class="border-0 modal-header">
                    <h5 class="modal-title text-white">Total Balance</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-white">Total Balance - Settles Balance</div>
            </div>
        </div>
    </div>
</div>
