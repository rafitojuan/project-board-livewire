<div>
    <div class="modal fade {{ $isOpen ? 'show' : '' }}" id="notificationModal" tabindex="-1" role="dialog"
        style="display: {{ $isOpen ? 'block' : 'none' }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $notification['title'] ?? 'Notification Details' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="close"></button>
                </div>
                <div class="modal-body">
                    @if ($notification)
                        <div class="notification-content">
                            <p>{{ $notification['message'] ?? '' }}</p>
                            {{-- Add any additional notification details you want to display --}}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="close">Close</button>
                    @if (isset($notification['action_url']))
                        <a href="{{ $notification['url'] }}" class="btn btn-primary">
                            {{ $notification['url'] ?? 'View' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($isOpen)
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
