<div>
    <div class="modal fade <?php echo e($isOpen ? 'show' : ''); ?>" id="notificationModal" tabindex="-1" role="dialog"
        style="display: <?php echo e($isOpen ? 'block' : 'none'); ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php echo e($notification['title'] ?? 'Notification Details'); ?>

                    </h5>
                    <button type="button" class="btn-close" wire:click="close"></button>
                </div>
                <div class="modal-body">
                    <!--[if BLOCK]><![endif]--><?php if($notification): ?>
                        <div class="notification-content">
                            <p><?php echo e($notification['message'] ?? ''); ?></p>
                            
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="close">Close</button>
                    <!--[if BLOCK]><![endif]--><?php if(isset($notification['action_url'])): ?>
                        <a href="<?php echo e($notification['url']); ?>" class="btn btn-primary">
                            <?php echo e($notification['url'] ?? 'View'); ?>

                        </a>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
    <!--[if BLOCK]><![endif]--><?php if($isOpen): ?>
        <div class="modal-backdrop fade show"></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/tugas-modal.blade.php ENDPATH**/ ?>