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
            <select multiple
                <?php echo e($filter->getWireMethod("filterComponents.".$filter->getKey())); ?>

                wire:key="<?php echo e($filter->generateWireKey($tableName, 'multiselectdropdown')); ?>"
                id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?><?php if($filter->hasCustomPosition()): ?>-<?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
                class="block w-full transition duration-150 ease-in-out border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white dark:border-gray-600"
            >
            <?php if($filter->getFirstOption() != ""): ?>
                <option <?php if($filter->isEmpty($this)): ?> selected <?php endif; ?> value="all"><?php echo e($filter->getFirstOption()); ?></option>
            <?php endif; ?>
                <?php $__currentLoopData = $filter->getOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_iterable($value)): ?>
                        <optgroup label="<?php echo e($key); ?>">
                            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($optionKey); ?>"><?php echo e($optionValue); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </optgroup>
                    <?php else: ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    <?php elseif($isBootstrap): ?>
        <select multiple
            <?php echo e($filter->getWireMethod("filterComponents.".$filter->getKey())); ?>

            wire:key="<?php echo e($filter->generateWireKey($tableName, 'multiselectdropdown')); ?>"
            id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?><?php if($filter->hasCustomPosition()): ?>-<?php echo e($filter->getCustomPosition()); ?><?php endif; ?>"
            class="<?php echo e($isBootstrap4 ? 'form-control' : 'form-select'); ?>"
        >
        <?php if($filter->getFirstOption() != ""): ?>
            <option <?php if($filter->isEmpty($this)): ?> selected <?php endif; ?> value="all"><?php echo e($filter->getFirstOption()); ?></option>
        <?php endif; ?>
            <?php $__currentLoopData = $filter->getOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_iterable($value)): ?>
                    <optgroup label="<?php echo e($key); ?>">
                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($optionKey); ?>"><?php echo e($optionValue); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </optgroup>
                <?php else: ?>
                    <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\tools\filters\multi-select-dropdown.blade.php ENDPATH**/ ?>