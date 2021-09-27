    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-balance-scale"></i>
            </div>
            <div class="sidebar-brand-text mx-3">My Finance</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item @if (Route::current()->uri == '/') active @endif ">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Financial
        </div>
        <li class="nav-item @if (Route::current()->uri == 'pockets') active @endif">
            <a class="nav-link" href="{{ route('rekening') }}">

                <i class="fas fa-fw fa-wallet"></i>
                <span>Pockets</span>
            </a>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->

        <li class="nav-item @if (in_array(Route::current()->uri, ['transactions', 'transactions/{id}'])) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-dollar-sign"></i>
                <span>Financial Records</span>
            </a>
            <div id="collapseUtilities" class="collapse @if (in_array(Route::current()->uri, ['transactions', 'transactions/{id}'])) show @endif" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-gray-100 border-0  py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Type:</h6>
                    <a class="collapse-item text-white @if (Route::current()->uri == 'transactions') active @endif" href="{{ route('transaction') }}">All</a>
                    <a class="collapse-item text-white @if (strrchr(url()->current(), 'o') == 'ons/1') active @endif" href="{{ route('transaction.detail',1) }}">Income</a>
                    <a class="collapse-item text-white @if (strrchr(url()->current(), 'o') == 'ons/2') active @endif" href="{{ route('transaction.detail',2) }}">Spending</a>
                    <a class="collapse-item text-white @if (strrchr(url()->current(), 'o') == 'ons/3') active @endif" href="{{ route('transaction.detail',3) }}">Transfer</a>
                    <a class="collapse-item text-white @if (strrchr(url()->current(), 'o') == 'ons/4') active @endif" href="{{ route('transaction.detail',4) }}">Pay Debt</a>
                    <a class="collapse-item text-white @if (strrchr(url()->current(), 'o') == 'ons/5') active @endif" href="{{ route('transaction.detail',5) }}">Friend Pay
                        Debt</a>
                </div>
            </div>
        </li>


        <li class="nav-item @if (Route::current()->uri == 'debts') active @endif">
            <a class="nav-link" href="{{ route('utang') }}">
                <i class="fas fa-fw fa-biohazard"></i>
                <span>Your Debt</span>
            </a>
        </li>
        <li class="nav-item @if (Route::current()->uri == 'frdebts') active @endif">
            <a class="nav-link" href="{{ route('utangteman') }}">
                <i class="fas fa-fw fa-bomb"></i>
                <span>Your Friends Debt </span>
            </a>
        </li>
        <li class="nav-item @if (Route::current()->uri == 'repetitions') active @endif">
            <a class="nav-link" href="{{ route('cicilan') }}">
                <i class="fas fa-fw fa-redo-alt"></i>
                <span>Repetition</span>
            </a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Future
        </div>
        <li class="nav-item @if (Route::current()->uri == 'financialplans') active @endif">
            <a class="nav-link" href="{{ route('financialplan') }}">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Financial Plan</span>
            </a>
        </li>
        <li class="nav-item @if (Route::current()->uri == 'investments') active @endif">
            <a class="nav-link" href="{{ route('investasi') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Investment</span>
            </a>
        </li>
        <li class="nav-item @if (Route::current()->uri == 'settings') active @endif">
            <a class="nav-link" href="{{ route('setting') }}">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Settings</span>
            </a>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
