<?php foreach ((['component', 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php if($this->filtersAreEnabled() && $this->filterPillsAreEnabled() && $this->hasAppliedVisibleFiltersForPills()): ?>
    <div>
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'mb-4 px-4 md:p-0' => $isTailwind,
            'mb-3' => $isBootstrap,
        ]); ?>" x-cloak x-show="!currentlyReorderingStatus">
            <small class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'text-gray-700 dark:text-white' => $isTailwind,
                '' =>  $isBootstrap,
            ]); ?>">
                <?php echo app('translator')->get('livewire-tables::Applied Filters'); ?>:
            </small>

            <?php $__currentLoopData = $this->getAppliedFiltersWithValues(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filterSelectName => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($filter = $this->getFilterByKey($filterSelectName)); ?>

                <?php if(is_null($filter)) continue; ?>
                <?php if($filter->isHiddenFromPills()) continue; ?>

                <?php if($filter->hasCustomPillBlade()): ?>
                    <?php echo $__env->make($filter->getCustomPillBlade(), ['filter' => $filter], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                    <span
                        wire:key="<?php echo e($tableName); ?>-filter-pill-<?php echo e($filter->getKey()); ?>"
                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-indigo-100 text-indigo-800 capitalize dark:bg-indigo-200 dark:text-indigo-900' => $isTailwind,
                            'badge badge-pill badge-info d-inline-flex align-items-center' => $isBootstrap4,
                            'badge rounded-pill bg-info d-inline-flex align-items-center' => $isBootstrap5,
                        ]); ?>"
                    >
                        <?php echo e($filter->getFilterPillTitle()); ?>: 
                        <?php ( $filterPillValue = $filter->getFilterPillValue($value)); ?>
                        <?php ( $separator = method_exists($filter, 'getPillsSeparator') ? $filter->getPillsSeparator() : ', '); ?>

                        <?php if(is_array($filterPillValue) && !empty($filterPillValue)): ?>
                            <?php $__currentLoopData = $filterPillValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filterPillArrayValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($filterPillArrayValue); ?><?php echo $separator; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <?php echo e($filterPillValue); ?>

                        <?php endif; ?>

                        <?php if($isTailwind): ?>
                            <button
                                wire:click="resetFilter('<?php echo e($filter->getKey()); ?>')"
                                type="button"
                                class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white"
                            >
                                <span class="sr-only"><?php echo app('translator')->get('livewire-tables::Remove filter option'); ?></span>
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-x-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </button>
                        <?php else: ?>
                            <a
                                href="#"
                                wire:click="resetFilter('<?php echo e($filter->getKey()); ?>')"
                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'text-white ml-2' => ($isBootstrap),
                                ]); ?>"
                            >
                                <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'sr-only' => $isBootstrap4,
                                    'visually-hidden' => $isBootstrap5,
                                ]); ?>">
                                    <?php echo app('translator')->get('livewire-tables::Remove filter option'); ?>
                                </span>
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-x-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'laravel-livewire-tables-btn-tiny']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($isTailwind): ?>
                <button
                    wire:click.prevent="setFilterDefaults"
                    class="focus:outline-none active:outline-none"
                >
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-200 dark:text-gray-900">
                        <?php echo app('translator')->get('livewire-tables::Clear'); ?>
                    </span>
                </button>
            <?php else: ?>
                <a
                    href="#"
                    wire:click.prevent="setFilterDefaults"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'badge badge-pill badge-light' => $isBootstrap4,
                        'badge rounded-pill bg-light text-dark text-decoration-none' => $isBootstrap5,
                    ]); ?>"
                >
                    <?php echo app('translator')->get('livewire-tables::Clear'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\tools\filter-pills.blade.php ENDPATH**/ ?>