@section('title', 'Investments - My Finance')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Investment</h1>
        <a href="javascript:void(0)" class="d-sm-inline-block btn btn-primary shadow-sm">Rp.
            {{ number_format(Auth::user()->total_investments(), 0, ',', '.') }}</a>

    </div>
    <ul class="list-group">
        @foreach ($investations as $investation)
            <a href="{{ route($investation->route()) }}"
                class="list-group-item list-group-item-action bg-dark  d-flex align-items-center">
                <div class="flex-grow-1 text-white">
                    {{ $investation->nama }}
                </div>
                <div class="text-white">
                    Rp. {{ number_format($investation->total, 0, ',', '.') }}
                </div>
            </a>
        @endforeach
    </ul>
</div>
