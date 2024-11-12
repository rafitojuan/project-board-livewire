<?php foreach ((['component','isTailwind','isBootstrap','isBootstrap4','isBootstrap5']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php echo $__env->renderWhen(
    $this->hasConfigurableAreaFor('before-pagination'), 
    $this->getConfigurableAreaFor('before-pagination'), 
    $this->getParametersForConfigurableArea('before-pagination')
, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

<?php if($this->isTailwind): ?>
    <div <?php echo e($this->getPaginationWrapperAttributesBag()); ?>>
        <?php if($this->paginationVisibilityIsEnabled()): ?>
            <div class="mt-4 px-4 md:p-0 sm:flex justify-between items-center space-y-4 sm:space-y-0">
                <div>
                    <?php if($this->paginationIsEnabled() && $this->isPaginationMethod('standard') && $this->getRows->lastPage() > 1): ?>
                        <p class="paged-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                            <?php if($this->showPaginationDetails()): ?>
                                <span><?php echo app('translator')->get('livewire-tables::Showing'); ?></span>
                                <span class="font-medium"><?php echo e($this->getRows->firstItem()); ?></span>
                                <span><?php echo app('translator')->get('livewire-tables::to'); ?></span>
                                <span class="font-medium"><?php echo e($this->getRows->lastItem()); ?></span>
                                <span><?php echo app('translator')->get('livewire-tables::of'); ?></span>
                                <span class="font-medium"><span x-text="paginationTotalItemCount"></span></span>
                                <span><?php echo app('translator')->get('livewire-tables::results'); ?></span>
                            <?php endif; ?>
                        </p>
                    <?php elseif($this->paginationIsEnabled() && $this->isPaginationMethod('simple')): ?>
                        <p class="paged-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                            <?php if($this->showPaginationDetails()): ?>
                                <span><?php echo app('translator')->get('livewire-tables::Showing'); ?></span>
                                <span class="font-medium"><?php echo e($this->getRows->firstItem()); ?></span>
                                <span><?php echo app('translator')->get('livewire-tables::to'); ?></span>
                                <span class="font-medium"><?php echo e($this->getRows->lastItem()); ?></span>
                            <?php endif; ?>
                        </p>
                    <?php elseif($this->paginationIsEnabled() && $this->isPaginationMethod('cursor')): ?>
                    <?php else: ?>
                        <p class="total-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                            <?php echo app('translator')->get('livewire-tables::Showing'); ?>
                            <span class="font-medium"><?php echo e($this->getRows->count()); ?></span>
                            <?php echo app('translator')->get('livewire-tables::results'); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <?php if($this->paginationIsEnabled()): ?>
                    <?php echo e($this->getRows->links('livewire-tables::specific.tailwind.'.(!$this->isPaginationMethod('standard') ? 'simple-' : '').'pagination')); ?>

                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php elseif($this->isBootstrap4): ?>
    <div <?php echo e($this->getPaginationWrapperAttributesBag()); ?>>
        <?php if($this->paginationVisibilityIsEnabled()): ?>
            <?php if($this->paginationIsEnabled() && $this->isPaginationMethod('standard') && $this->getRows->lastPage() > 1): ?>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 overflow-auto">
                        <?php echo e($this->getRows->links('livewire-tables::specific.bootstrap-4.pagination')); ?>

                    </div>

                    <div class="col-12 col-md-6 text-center text-md-right text-muted">
                        <?php if($this->showPaginationDetails()): ?>
                            <span><?php echo app('translator')->get('livewire-tables::Showing'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->firstItem() : 0); ?></strong>
                            <span><?php echo app('translator')->get('livewire-tables::to'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->lastItem() : 0); ?></strong>
                            <span><?php echo app('translator')->get('livewire-tables::of'); ?></span>
                            <strong><span x-text="paginationTotalItemCount"></span></strong>
                            <span><?php echo app('translator')->get('livewire-tables::results'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif($this->paginationIsEnabled() && $this->isPaginationMethod('simple')): ?>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 overflow-auto">
                        <?php echo e($this->getRows->links('livewire-tables::specific.bootstrap-4.simple-pagination')); ?>

                    </div>

                    <div class="col-12 col-md-6 text-center text-md-right text-muted">
                        <?php if($this->showPaginationDetails()): ?>
                            <span><?php echo app('translator')->get('livewire-tables::Showing'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->firstItem() : 0); ?></strong>
                            <span><?php echo app('translator')->get('livewire-tables::to'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->lastItem() : 0); ?></strong>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif($this->paginationIsEnabled() && $this->isPaginationMethod('cursor')): ?>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 overflow-auto">
                        <?php echo e($this->getRows->links('livewire-tables::specific.bootstrap-4.simple-pagination')); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="row mt-3">
                    <div class="col-12 text-muted">
                        <?php echo app('translator')->get('livewire-tables::Showing'); ?>
                        <strong><?php echo e($this->getRows->count()); ?></strong>
                        <?php echo app('translator')->get('livewire-tables::results'); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php elseif($this->isBootstrap5): ?>
    <div <?php echo e($this->getPaginationWrapperAttributesBag()); ?> >
        <?php if($this->paginationVisibilityIsEnabled()): ?>
            <?php if($this->paginationIsEnabled() && $this->isPaginationMethod('standard') && $this->getRows->lastPage() > 1): ?>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 overflow-auto">
                        <?php echo e($this->getRows->links('livewire-tables::specific.bootstrap-4.pagination')); ?>

                    </div>
                    <div class="col-12 col-md-6 text-center text-md-end text-muted">
                        <?php if($this->showPaginationDetails()): ?>
                            <span><?php echo app('translator')->get('livewire-tables::Showing'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->firstItem() : 0); ?></strong>
                            <span><?php echo app('translator')->get('livewire-tables::to'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->lastItem() : 0); ?></strong>
                            <span><?php echo app('translator')->get('livewire-tables::of'); ?></span>
                            <strong><span x-text="paginationTotalItemCount"></span></strong>
                            <span><?php echo app('translator')->get('livewire-tables::results'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif($this->paginationIsEnabled() && $this->isPaginationMethod('simple')): ?>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 overflow-auto">
                        <?php echo e($this->getRows->links('livewire-tables::specific.bootstrap-4.simple-pagination')); ?>

                    </div>
                    <div class="col-12 col-md-6 text-center text-md-end text-muted">
                        <?php if($this->showPaginationDetails()): ?>
                            <span><?php echo app('translator')->get('livewire-tables::Showing'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->firstItem() : 0); ?></strong>
                            <span><?php echo app('translator')->get('livewire-tables::to'); ?></span>
                            <strong><?php echo e($this->getRows->count() ? $this->getRows->lastItem() : 0); ?></strong>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif($this->paginationIsEnabled() && $this->isPaginationMethod('cursor')): ?>
                <div class="row mt-3">
                    <div class="col-12 col-md-6 overflow-auto">
                        <?php echo e($this->getRows->links('livewire-tables::specific.bootstrap-4.simple-pagination')); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="row mt-3">
                    <div class="col-12 text-muted">
                        <?php echo app('translator')->get('livewire-tables::Showing'); ?>
                        <strong><?php echo e($this->getRows->count()); ?></strong>
                        <?php echo app('translator')->get('livewire-tables::results'); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php echo $__env->renderWhen(
    $this->hasConfigurableAreaFor('after-pagination'), 
    $this->getConfigurableAreaFor('after-pagination'), 
    $this->getParametersForConfigurableArea('after-pagination')
, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\pagination.blade.php ENDPATH**/ ?>