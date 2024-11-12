<div>
    <?php if (isset($component)) { $__componentOriginal3d520986b3faee512e1fc7aea1837396 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d520986b3faee512e1fc7aea1837396 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'livewire-tables::components.tools.filter-label','data' => ['filter' => $filter,'filterLayout' => $filterLayout,'tableName' => $tableName,'isTailwind' => $isTailwind,'isBootstrap4' => $isBootstrap4,'isBootstrap5' => $isBootstrap5,'isBootstrap' => $isBootstrap]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('livewire-tables::tools.filter-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['filter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filter),'filterLayout' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterLayout),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableName),'isTailwind' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isTailwind),'isBootstrap4' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isBootstrap4),'isBootstrap5' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isBootstrap5),'isBootstrap' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isBootstrap)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d520986b3faee512e1fc7aea1837396)): ?>
<?php $attributes = $__attributesOriginal3d520986b3faee512e1fc7aea1837396; ?>
<?php unset($__attributesOriginal3d520986b3faee512e1fc7aea1837396); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d520986b3faee512e1fc7aea1837396)): ?>
<?php $component = $__componentOriginal3d520986b3faee512e1fc7aea1837396; ?>
<?php unset($__componentOriginal3d520986b3faee512e1fc7aea1837396); ?>
<?php endif; ?>


    <?php if($isTailwind): ?>
        <div class="rounded-md shadow-sm">
            <div>
                <input
                    type="checkbox"
                    id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-select-all-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
                    wire:input="selectAllFilterOptions('<?php echo e($filter->getKey()); ?>')"
                    class="text-indigo-600 rounded border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600 disabled:opacity-50 disabled:cursor-wait"
                >
                <label for="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-select-all-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>" class="dark:text-white">
                <?php if($filter->getFirstOption() != ""): ?>
                    <?php echo e($filter->getFirstOption()); ?>

                <?php else: ?>
                    <?php echo app('translator')->get('livewire-tables::All'); ?>
                <?php endif; ?>
                </label>
            </div>

            <?php $__currentLoopData = $filter->getOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div wire:key="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-multiselect-<?php echo e($key); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>">
                    <input
                        type="checkbox"
                        id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-<?php echo e($loop->index); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
                        value="<?php echo e($key); ?>"
                        wire:key="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-<?php echo e($loop->index); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
                        <?php echo e($filter->getWireMethod("filterComponents.".$filter->getKey())); ?>

                        class="text-indigo-600 rounded border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600 disabled:opacity-50 disabled:cursor-wait"
                    >
                    <label for="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-<?php echo e($loop->index); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>" class="dark:text-white"><?php echo e($value); ?></label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php elseif($isBootstrap): ?>
        <div class="form-check">
            <input
                type="checkbox"
                id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-select-all-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
                wire:input="selectAllFilterOptions('<?php echo e($filter->getKey()); ?>')"
                class="form-check-input"
            >
            <label class="form-check-label" for="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>-select-all"><?php echo app('translator')->get('livewire-tables::All'); ?></label>
        </div>

        <?php $__currentLoopData = $filter->getOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-check" wire:key="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-multiselect-<?php echo e($key); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>">
                <input
                    class="form-check-input"
                    type="checkbox"
                    id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-<?php echo e($loop->index); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
                    value="<?php echo e($key); ?>"
                    wire:key="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-<?php echo e($loop->index); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
                    <?php echo e($filter->getWireMethod("filterComponents.".$filter->getKey())); ?>


                >
                <label class="form-check-label" for="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-<?php echo e($loop->index); ?>-<?php if($filter->hasCustomPosition()): ?><?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"><?php echo e($value); ?></label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\tools\filters\multi-select.blade.php ENDPATH**/ ?>