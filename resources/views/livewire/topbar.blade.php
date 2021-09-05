<div>
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-dark bg-dark topbar static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        {{-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                    <i class="fa fa-bars"></i>
                                </button> --}}
        <a class="ml-3 this_small text-white" href="{{ route('home') }}">
            <i class="fa fa-balance-scale fa-2x"></i>
        </a>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Alerts -->
            {{-- <livewire:alert-center /> --}}
            @livewire('partials.alert-center')

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-white small">
                        {{ Auth::user()->name }}
                    </span>
                    <img class="img-profile rounded-circle" src="{{ asset('img/default-user-icon.jpg') }}">
                </a>
                <!-- Dropdown - User Information -->
                <div class=" bg-dark border-0 dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    {{-- <a class="dropdown-item" href="#">
                                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Profile
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Settings
                                            </a> --}}
                    <a class="dropdown-item text-white" href="http://web.epafroditusgeorge.com" target="_blank">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        My Website
                    </a>
                    <div class="this_small">
                        <a class="dropdown-item text-white" href="/settings">
                            <i class="fas fa-wrench fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-white" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
    </nav>
    <nav class="navbar navbar-dark bg-black navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom p-0">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item" style="line-height: 80% !important; word-wrap:normal;">
                <a href="/" class="nav-link  @if (Route::current()->uri == '/') active @endif"><i class="fas fa-fw fa-tachometer-alt"></i><br>
                    <span style="font-size: 10px">Home</span>
                </a>
            </li>
            <li class="nav-item" style="line-height: 80% !important; word-wrap:normal;">
                <a href="/pockets" class="nav-link @if (Route::current()->uri == 'pockets') active @endif"><i class="fas fa-fw fa-wallet"></i><br>
                    <span style="font-size: 10px">Pockets</span>
                </a>
            </li>
            <li class="nav-item dropup no-arrow @if (in_array(Route::current()->uri, ['transactions', 'transactions/{id}'])) active @endif" style="line-height: 80%
                !important; word-wrap:normal;">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-dollar-sign"></i><br>
                    <span style="font-size: 10px">Records</span>

                </a>
                <div class="dropdown-menu bg-dark border-0" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-white @if (Route::current()->uri == 'transactions') active @endif" href="/transactions">All</a>
                    <a class="dropdown-item text-white @if (strrchr(url()->current(), 'o') == 'ons/1') active @endif" href="/transactions/1">Income</a>
                    <a class="dropdown-item text-white @if (strrchr(url()->current(), 'o') == 'ons/2') active @endif" href="/transactions/2">Spending</a>
                    <a class="dropdown-item text-white @if (strrchr(url()->current(), 'o') == 'ons/3') active @endif" href="/transactions/3">Transfer</a>
                    <a class="dropdown-item text-white @if (strrchr(url()->current(), 'o') == 'ons/4') active @endif" href="/transactions/4">Your Debt</a>
                    <a class="dropdown-item text-white @if (strrchr(url()->current(), 'o') == 'ons/5') active @endif" href="/transactions/5">Your Friend
                        Debt</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="/financialplans" style="line-height: 80% !important; word-wrap:normal;"
                    class="nav-link @if (Route::current()->uri == 'financialplans') active @endif"><i class="fas fa-fw fa-clipboard-list"></i><br>
                    <span style="font-size: 10px">Plan</span>

                </a>
            </li>
            <li class="nav-item">
                <a href="/investments" style="line-height: 80% !important; word-wrap:normal;"
                    class="nav-link @if (Route::current()->uri == 'investments') active @endif"><i class="fas fa-fw fa-chart-line"></i><br>
                    <span style="font-size: 10px">Investment</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End of Topbar -->
    <!-- Logout Modal-->
    <livewire:logout />
    <hr class="bg-gray-100 sidebar-divider my-0">
</div>
