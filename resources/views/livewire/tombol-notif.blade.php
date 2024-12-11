<div>
    <div class="dropdown d-inline-block position-relative">
        <button wire:poll.5s='fetchNotif' wire:click="toggleDropdown" type="button"
            class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ $isDropdownOpen ? 'true' : 'false' }}"
            onclick="event.stopPropagation()">
            <i class="bx bx-bell bx-tada"></i>
            @if ($unread > 0)
                <span class="badge bg-danger rounded-pill">{{ $unread }}</span>
            @endif
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 {{ $isDropdownOpen ? 'show' : '' }}"
            aria-labelledby="page-header-notifications-dropdown" onclick="event.stopPropagation()"
            style="position: absolute; right: 0;">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0">Notifikasi</h6>
                    </div>
                </div>
            </div>
            <div data-simplebar style="max-height: 230px;">
                @forelse($notif as $notification)
                    <a href="#" data-bs-toggle="modal" data-bs-target="#{{ $notification->data['modal'] ?? '' }}"
                        href="{{ $notification->data['url'] ?? '#' }}" class="text-reset notification-item">
                        <div class="d-flex">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    <i class="{{ $notification->data['logo'] }}"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mt-0 mb-1">{{ $notification->data['title'] }}</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1" key="t-grammer">{{ $notification->data['message'] }}</p>
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                        {{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center p-3">
                        <p class="mb-0">Tidak ada notifikasi baru...</p>
                    </div>
                @endforelse
            </div>
            <div class="p-2 border-top d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('tugas.index') }}">
                    <i class="mdi mdi-arrow-right-circle me-1"></i>
                    <span key="t-view-more">
                        Lihat selengkapnya
                    </span>
                </a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('click', function() {
            @this.set('isDropdownOpen', false);
        });
    </script>
</div>
