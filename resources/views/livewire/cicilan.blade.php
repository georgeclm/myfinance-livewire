    @section('title', 'Repetition - My Finance')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-white">Repetition</h1>
            @if (!auth()->user()->rekenings->isEmpty())
                <button onclick="showModal('create-cicilan')"
                    class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Add</button>
            @endif
        </div>
        <div class="row mobile">
            @if (auth()->user()->rekenings->isEmpty())
                @livewire('partials.newaccount')
            @endif
        </div>
        @foreach ($jenisuangs as $jenisuang)

            <!-- DataTales Example -->
            <div class="bg-dark border-0 card shadow mb-4">
                <div class="bg-gray-100 border-0 card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $jenisuang->nama }}</h6>
                </div>
                <div class="card-body">
                    @forelse ($jenisuang->cicilans->take(5) as $cicilan)
                        @livewire('cicilan.delete',['cicilan' => $cicilan])
                        @livewire('cicilan.edit',['cicilan' => $cicilan,'jenisuangsSelect' => $jenisuangs,'categories'
                        => $categories,'categorymasuks' => $categorymasuks])
                        <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{ $cicilan->nama }} - Rp.
                                {{ number_format($cicilan->jumlah, 0, ',', '.') }}
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-caret-down"></i>
                                    {{-- <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> --}}
                                </a>
                                <div class="bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <a onclick="showModal('editmodal-{{ $cicilan->id }}')"
                                        class="dropdown-item text-white" href="javascript:void(0)">Edit</a>
                                    <a onclick="showModal('deletemodal-{{ $cicilan->id }}')"
                                        class="dropdown-item text-white" href="javascript:void(0)">Delete</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="text-white my-3 mx-0">
                            <div class="d-flex ">
                                <div class="flex-grow-1">
                                    @switch($cicilan->jenisuang_id)
                                        @case(1)
                                            {{ $cicilan->category_masuk->nama }}
                                        @break
                                        @case(2)
                                            {{ $cicilan->category->nama }}
                                        @break
                                        @case(3)
                                            Transfer
                                        @break
                                        @case(4)
                                            Pay Debt
                                            {{ Str::limit($cicilan->utang->keterangan, 15, $end = '...') ?? $cicilan->utang->nama }}
                                        @break
                                        @default
                                            Friend Pay Debt
                                            {{ Str::limit($cicilan->utangteman->keterangan, 15, $end = '...') ?? $cicilan->utangteman->nama }}
                                    @endswitch
                                    <br>
                                    Date : {{ $cicilan->tanggal }}
                                </div>
                                {{ $cicilan->sekarang }}/{{ $cicilan->bulan }}
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
            @livewire('cicilan.create',['jenisuangs' => $jenisuangs,'categories' => $categories,'categorymasuks' =>
            $categorymasuks])
        </div>
