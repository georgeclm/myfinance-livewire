@section('title', 'Pockets - My Finance')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Pockets</h1>
        <a href="#" data-toggle="modal" data-target="#addRekening"
            class="d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Add Pocket</a>
    </div>
    <!-- Content Row -->
    <div class="row mobile">
        @livewire('partials.totalbalance')
        @livewire('partials.balancewithasset')
    </div>

    @foreach ($jeniss as $jenis)

        <!-- DataTales Example -->
        <div class="bg-dark border-0 card shadow mb-4">
            <div class="bg-gray-100 border-0 card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $jenis->nama }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-dark" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Pocket Name</th>
                                @if ($jenis->id != 1)
                                    <th>Bank Name</th>
                                @endif
                                <th>Current Balance</th>
                                @if ($jenis->id == 2)
                                    <th>Balance Settles</th>
                                @endif
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenis->user_rekenings as $rekening)
                                @livewire('rekening.edit',['rekening' => $rekening,'jeniss' =>
                                $jeniss])
                                @livewire('rekening.delete',['rekening' => $rekening])
                                @livewire('rekening.adjust',['rekening' => $rekening])
                                <tr>
                                    <td>{{ $rekening->nama_akun }}</td>
                                    @if ($rekening->jenis_id != 1)
                                        <td>{{ $rekening->nama_bank }}</td>
                                    @endif
                                    <td>Rp. {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}</td>
                                    @if ($rekening->jenis_id == 2)
                                        <td>Rp. {{ number_format($rekening->saldo_mengendap, 0, ',', '.') }}
                                        </td>
                                    @endif
                                    <td>{{ $rekening->keterangan ?? '-' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <div class=" bg-dark border-0  dropdown-menu"
                                                aria-labelledby="dropdownMenuButton">
                                                <a data-toggle="modal" data-target="#editmodal-{{ $rekening->id }}"
                                                    class="dropdown-item text-white" href="javascript:void(0)">Edit</a>
                                                <a data-toggle="modal" data-target="#deletemodal-{{ $rekening->id }}"
                                                    class="dropdown-item text-white"
                                                    href="javascript:void(0)">Delete</a>
                                                <a data-toggle="modal" data-target="#adjustmodal-{{ $rekening->id }}"
                                                    class="dropdown-item text-white"
                                                    href="javascript:void(0)">Adjust</a>
                                                <a class="dropdown-item text-white"
                                                    href="/pockets/{{ $rekening->id }}">Mutation
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Pocket Empty</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
    @livewire('rekening.create',['jeniss' => $jeniss])
</div>
