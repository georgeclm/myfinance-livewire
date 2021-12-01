@section('title', 'Investments - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Investment</h1>
        <button class="d-sm-inline-block btn btn-primary shadow-sm" disabled>Rp.
            {{ number_format(Auth::user()->total_investments(), 0, ',', '.') }}</button>

    </div>
    <ul class="list-group">
        @foreach ($investations as $investation)
            <a href="{{ route($investation->route()) }}"
                class="list-group-item list-group-item-action bg-dark  d-flex align-items-center">
                <div class="flex-grow-1 text-white">
                    {{ $investation->nama }}
                    @if ($investation->nama == 'Cryptocurrency')<span
                            class="badge  badge-primary ">
                            On Development
                        </span>
                    @endif
                </div>
                <div class="text-white">
                    Rp. {{ number_format($investation->total, 0, ',', '.') }}
                </div>
            </a>
        @endforeach
    </ul>
    <br><br><br><br><br><br><br>

</div>
