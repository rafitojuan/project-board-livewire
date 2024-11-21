

<div>
    <div class="dropdown d-inline-block">
        <button wire:poll.keep-alive='fetchNotif' wire:click="toggleDropdown" type="button"
            class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php echo e($isDropdownOpen ? 'true' : 'false'); ?>"
            onclick="event.stopPropagation()">
            <i class="bx bx-bell bx-tada"></i>
            <!--[if BLOCK]><![endif]--><?php if($unread > 0): ?>
                <span class="badge bg-danger rounded-pill"><?php echo e($unread); ?></span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 <?php echo e($isDropdownOpen ? 'show' : ''); ?>"
            aria-labelledby="page-header-notifications-dropdown">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0">Notifikasi</h6>
                    </div>
                </div>
            </div>
            <div data-simplebar style="max-height: 230px;">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $notif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="#" wire:click.prevent="markAsRead('<?php echo e($notification->id); ?>')"
                        class="text-reset notification-item">
                        <div class="d-flex">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    <i class="bx bx-bell"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mt-0 mb-1"><?php echo e($notification->data['title']); ?></h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1" key="t-grammer"><?php echo e($notification->data['message']); ?></p>
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                        <?php echo e($notification->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center p-3">
                        <p class="mb-0">Tidak ada notifikasi baru</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="p-2 border-top d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more"><?php echo app('translator')->get('translation.View_More'); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/tombol-notif.blade.php ENDPATH**/ ?>