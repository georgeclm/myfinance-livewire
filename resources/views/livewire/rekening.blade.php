@section('title', 'Pockets - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Pockets</h1>
        <button onclick="showModal('new-pocket')" class="d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i>
            Create Pocket</button>
    </div>

    <!-- Content Row -->
    <div class="row px-2 ml-0">
        @livewire('partials.totalbalance')
        @livewire('partials.balancewithasset')
    </div>

    @foreach ($jeniss as $jenis)

        <div class="bg-dark border-0 card shadow mb-4 small-when-0 ">
            <div class="bg-gray-100 border-0 card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $jenis->nama }}</h6>
            </div>
            <div class="card-body ">
                @forelse ($jenis->user_rekenings as $rekening)
                    @livewire('rekening.edit',['rekening' => $rekening,'jeniss' =>
                    $jeniss])
                    @livewire('rekening.delete',['rekening' => $rekening])
                    @livewire('rekening.adjust',['rekening' => $rekening])
                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a
                                href="{{ route('rekening.show', $rekening->id) }}">{{ $rekening->nama_akun }}</a>
                            - Rp.
                            {{ number_format($rekening->saldo_sekarang, 0, ',', '.') }}
                        </h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-caret-down"></i>
                                {{-- <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> --}}
                            </a>
                            <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <a onclick="showModal('edit-{{ $rekening->id }}')" class="dropdown-item text-white"
                                    href="javascript:void(0)">Edit</a>
                                <a onclick="showModal('delete-{{ $rekening->id }}')" class="dropdown-item text-white"
                                    href="javascript:void(0)">Delete</a>
                                <a onclick="showModal('adjust-{{ $rekening->id }}')" class="dropdown-item text-white"
                                    href="javascript:void(0)">Adjust</a>
                                <a class="dropdown-item text-white"
                                    href="{{ route('rekening.show', $rekening->id) }}">Mutation
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="text-white my-3 mx-0">
                        <div class="d-flex ">
                            <div class="flex-grow-1">
                                {{ Str::limit($rekening->keterangan, 15, $end = '...') ?? '-' }}
                            </div>
                            @if ($rekening->jenis_id != 1)
                                {{ $rekening->nama_bank }}
                            @endif
                        </div>
                    </div>
                    <hr class="bg-white my-1">


                @empty
                    <div class="text-center font-weight-bold text-white-50">
                        Empty
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
    <div class="mt-2 text-center">
        <a class="font-weight-bold text-primary" href="#" data-toggle="modal" data-target="#addRekening">
            <i class="fas fa-plus-circle text-white-50"></i> Create New Pocket
        </a>
    </div>
    @livewire('rekening.create',['jeniss' => $jeniss])
</div>
