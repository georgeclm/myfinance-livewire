@section('title', 'Settings - My Finance')
<div class="container-fluid small-when-0">
    <!-- Page Heading -->
    <div class="text-center d-sm-flex align-items-center justify-content-between mb-4">
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
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-lg-3 small-when-0 ">
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Previous P2P Earnings</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form wire:submit.prevent="submitp2p">
                        <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model="p2pjumlah" type-currency="IDR" inputmode="numeric" type="text"
                                name="jumlah" required placeholder="Total Earnings"
                                class="form-control form-control-user">
                        </div>
                        <button type="submit" class="btn btn-primary" {{ $this->updatep2p }}>Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 small-when-0 ">
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Previous Stock Earnings</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form wire:submit.prevent="submitstock">
                        <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model="stockjumlah" type-currency="IDR" inputmode="numeric" type="text"
                                name="jumlah" required placeholder="Total Earnings"
                                class="form-control form-control-user">
                        </div>
                        <button type="submit" class="btn btn-primary" {{ $this->updatestock }}>Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 small-when-0 ">
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Previous Deposito Earnings</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form wire:submit.prevent="submitdeposito">
                        <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model="depositojumlah" type-currency="IDR" inputmode="numeric" type="text"
                                name="jumlah" required placeholder="Total Earnings"
                                class="form-control form-control-user">
                        </div>
                        <button type="submit" class="btn btn-primary" {{ $this->updatedeposito }}>Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 small-when-0 ">
            <div class="bg-dark border-0 card shadow mb-4">
                <div
                    class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Previous Mutual Fund Earnings</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form wire:submit.prevent="submitreksadana">
                        <div class="mb-3 hide-inputbtns input-group">
                            <input wire:model="reksadanajumlah" type-currency="IDR" inputmode="numeric" type="text"
                                name="jumlah" required placeholder="Total Earnings"
                                class="form-control form-control-user">
                        </div>
                        <button type="submit" class="btn btn-primary" {{ $this->updatemutualfund }}>Update</button>
                    </form>
                </div>
            </div>
        </div>
        @if (auth()->user()->email == 'cavidjaja@gmail.com')
            <div class="col-lg-6 small-when-0 ">
                <div class="bg-dark border-0 card shadow mb-4">
                    <div
                        class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add New Bank</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form wire:submit.prevent="store_bank">
                            <div class="form-group">
                                <input type="text" name="jumlah" required placeholder="Bank Name"
                                    wire:model.defer="bankform.nama"
                                    class="form-control form-control-user @error('bankform.nama') is-invalid @enderror">
                                @error('bankform.nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" name="jumlah" required placeholder="Bank Code"
                                    wire:model.defer="bankform.code"
                                    class="form-control form-control-user @error('bankform.code') is-invalid @enderror">
                                @error('bankform.code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 small-when-0 ">
                <div class="bg-dark border-0 card shadow mb-4">
                    <div
                        class="bg-gray-100 border-0 card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add New Stock</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form wire:submit.prevent="store_stock">
                            <div class="form-group">
                                <input type="text" name="jumlah" required placeholder="Stock Name"
                                    wire:model.defer="tickerform.nama"
                                    class="form-control form-control-user @error('tickerform.nama') is-invalid @enderror">
                                @error('tickerform.nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="jumlah" required placeholder="Stock Code"
                                    wire:model.defer="tickerform.code" maxlength="4"
                                    class="form-control form-control-user @error('tickerform.code') is-invalid @enderror">
                                @error('tickerform.code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @livewire('setting.create-category')
    @livewire('setting.create-category-masuk')
    <!-- End of Page Wrapper -->
    @if (session()->has('success'))
        <script>
            new Notify({
                status: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 2,
                position: 'right top'
            })
        </script>
    @endif
</div>
