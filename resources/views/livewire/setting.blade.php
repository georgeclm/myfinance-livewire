@section('title', 'Settings - My Finance')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-white">Settings</h1>
    </div>
    <div class="mobile row">

        <div class="small-when-0 col-lg-6">
            <!-- Dropdown Card Example -->
            <div class="bg-dark border-0 card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">Categories Spending</h6>
                    <a href="#" data-toggle="modal" data-target="#addCategory">
                        <i class="fas fa-plus fa-sm fa-fw text-danger"></i>
                    </a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($categories as $category)
                            <li class="bg-black list-group-item d-flex align-items-center">
                                <div class="w-100 text-danger">
                                    <i
                                        class="fas {{ $category->icon() }} text-danger mx-2"></i>{{ $category->nama }}
                                </div>
                                {{-- @if ($category->user_id != null)
                                                    <a href="{{ route('categories.remove', $category) }}">
                                                        <span class="badge badge-danger badge-pill text-end">x</span></a>
                                                @endif --}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-lg-6 small-when-0 ">
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Categories Income</h6>
                    <a href="#" data-toggle="modal" data-target="#addCategoryMasuk">
                        <i class="fas fa-plus fa-sm fa-fw text-success"></i>
                    </a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($category_masuks as $category)
                            <li class="bg-black list-group-item d-flex align-items-center">
                                <div class="w-100 text-success">
                                    <i
                                        class="fas {{ $category->icon() }} text-success mx-2"></i>{{ $category->nama }}
                                </div>
                                {{-- @if ($category->user_id != null)
                                                    <a href="{{ route('category_masuks.remove', $category) }}">
                                                        <span class="badge badge-success badge-pill">x</span></a>
                                                @endif --}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-lg-6 small-when-0 ">
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Previous P2P Earnings</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model.defer="jumlah" type-currency="IDR" inputmode="numeric" type="text"
                                name="jumlah" required placeholder="Total Earnings"
                                class="form-control form-control-user @error('jumlah') is-invalid @enderror">
                            @error('jumlah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update" />
                    </form>
                    {{-- @foreach ($category_masuks as $category)
                            <li class="bg-black list-group-item d-flex align-items-center">
                                <div class="w-100 text-success">
                                    <i
                                        class="fas {{ $category->icon() }} text-success mx-2"></i>{{ $category->nama }}
                                </div>
                                 @if ($category->user_id != null)
                                                    <a href="{{ route('category_masuks.remove', $category) }}">
                                                        <span class="badge badge-success badge-pill">x</span></a>
                                                @endif
                            </li>
                        @endforeach --}}
                </div>
            </div>

        </div>

    </div>
    @livewire('setting.create-category')
    @livewire('setting.create-category-masuk')
    <!-- End of Page Wrapper -->
</div>
