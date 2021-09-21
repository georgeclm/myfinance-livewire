<li class="nav-item dropdown no-arrow" wire:ignore.self>
    <a class="nav-link dropdown-toggle" wire:click="check_notif" href="#" id="alertsDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter">{{ Auth::user()->total_notif() }}</span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in scrollable {{ $style }}"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header bg-dark border-0">
            Notification
        </h6>
        @forelse ($notifications as $notification)
            <div class="dropdown-item bg-black border-0 d-flex align-items-center">
                <div class="mr-3">
                    <div class="icon-circle bg-gray-100">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                    <span class="font-weight-bold text-white">{{ $notification->notification }}</span>
                </div>
            </div>
        @empty
            <h6 class="dropdown-header bg-black border-0 text-center">
                No Notification
            </h6>
        @endforelse

    </div>
</li>
