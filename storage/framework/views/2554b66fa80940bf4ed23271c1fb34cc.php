<?php foreach ((['component', 'tableName','isTailwind','isBootstrap']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['column', 'index']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['column', 'index']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $attributes = $attributes->merge(['wire:key' => $tableName . '-header-col-'.$column->getSlug()]);
    $allThAttributes = $this->getAllThAttributes($column);

    $customThAttributes = $allThAttributes['customAttributes'];
    $customSortButtonAttributes = $allThAttributes['sortButtonAttributes'];
    $customSortIconAttributes = $allThAttributes['sortIconAttributes'];
    $customLabelAttributes = $allThAttributes['labelAttributes'];

    //$customThAttributes = $this->getThAttributes($column);
    //$customSortButtonAttributes = $this->getThSortButtonAttributes($column);
    //$customSortIconAttributes = $this->getThSortIconAttributes($column);

    $direction = $column->hasField() ? $this->getSort($column->getColumnSelectName()) : $this->getSort($column->getSlug()) ?? null ;
?>

<!--[if BLOCK]><![endif]--><?php if($isTailwind): ?>
    <th scope="col" <?php echo e($attributes->merge($customThAttributes)
            ->class(['text-gray-500 dark:bg-gray-800 dark:text-gray-400' => ($customThAttributes['default-colors'] ?? true || $customThAttributes['default'] ?? true)])
            ->class(['px-6 py-3 text-left text-xs font-medium whitespace-nowrap uppercase tracking-wider' => ($customThAttributes['default-styling'] ?? true || $customThAttributes['default'] ?? true)])
            ->class(['hidden' => $column->shouldCollapseAlways()])
            ->class(['hidden md:table-cell' => $column->shouldCollapseOnMobile()])
            ->class(['hidden lg:table-cell' => $column->shouldCollapseOnTablet()])
            ->except(['default', 'default-colors', 'default-styling'])); ?>

    >
        <!--[if BLOCK]><![endif]--><?php if($column->getColumnLabelStatus()): ?>
            <!--[if BLOCK]><![endif]--><?php if (! ($this->sortingIsEnabled() && ($column->isSortable() || $column->getSortCallback()))): ?>
                <span <?php echo e($customLabelAttributes->except(['default', 'default-colors', 'default-styling'])); ?>><?php echo e($column->getTitle()); ?></span>
            <?php else: ?>
                <button wire:click="sortBy('<?php echo e($column->getColumnSortKey()); ?>')"
                    <?php echo e($attributes->merge($customSortButtonAttributes)
                            ->class(['text-gray-500 dark:text-gray-400' => ($customSortButtonAttributes['default-colors'] ?? true || $customSortButtonAttributes['default'] ?? true)])    
                            ->class(['flex items-center space-x-1 text-left text-xs leading-4 font-medium uppercase tracking-wider group focus:outline-none' => ($customSortButtonAttributes['default-styling'] ?? true || $customSortButtonAttributes['default'] ?? true)])
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key'])); ?>

                >
                    <span <?php echo e($customLabelAttributes->except(['default', 'default-colors', 'default-styling'])); ?>><?php echo e($column->getTitle()); ?></span>
                    <?php if (isset($component)) { $__componentOriginald04625f556cffd8002726af5c6e9144f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald04625f556cffd8002726af5c6e9144f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'livewire-tables::components.table.th.sort-icons','data' => ['direction' => $direction,'attributes' => $attributes->merge($customSortIconAttributes)
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('livewire-tables::table.th.sort-icons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->merge($customSortIconAttributes)
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key']))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald04625f556cffd8002726af5c6e9144f)): ?>
<?php $attributes = $__attributesOriginald04625f556cffd8002726af5c6e9144f; ?>
<?php unset($__attributesOriginald04625f556cffd8002726af5c6e9144f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald04625f556cffd8002726af5c6e9144f)): ?>
<?php $component = $__componentOriginald04625f556cffd8002726af5c6e9144f; ?>
<?php unset($__componentOriginald04625f556cffd8002726af5c6e9144f); ?>
<?php endif; ?>

                </button>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </th>
<?php elseif($isBootstrap): ?>
    <th scope="col" <?php echo e($attributes->merge($customThAttributes)
            ->class(['' => $customThAttributes['default'] ?? true])
            ->class(['d-none' => $column->shouldCollapseAlways()])
            ->class(['d-none d-md-table-cell' => $column->shouldCollapseOnMobile()])
            ->class(['d-none d-lg-table-cell' => $column->shouldCollapseOnTablet()])
            ->except(['default','default-styling','default-colors'])); ?>

    >
        <!--[if BLOCK]><![endif]--><?php if($column->getColumnLabelStatus()): ?>
            <!--[if BLOCK]><![endif]--><?php if (! ($this->sortingIsEnabled() && ($column->isSortable() || $column->getSortCallback()))): ?>
                <span <?php echo e($customLabelAttributes->except(['default', 'default-colors', 'default-styling'])); ?>><?php echo e($column->getTitle()); ?></span>
            <?php else: ?>
                <div
                    class="d-flex align-items-center laravel-livewire-tables-cursor"
                    wire:click="sortBy('<?php echo e($column->getColumnSortKey()); ?>')"
                    <?php echo e($attributes->merge($customSortButtonAttributes)
                            ->class(['' => ($customSortButtonAttributes['default-styling'] ?? true || $customSortButtonAttributes['default'] ?? true)])
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key'])); ?>

                >
                    <span <?php echo e($customLabelAttributes->except(['default', 'default-colors', 'default-styling'])); ?>><?php echo e($column->getTitle()); ?></span>

                    <?php if (isset($component)) { $__componentOriginald04625f556cffd8002726af5c6e9144f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald04625f556cffd8002726af5c6e9144f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'livewire-tables::components.table.th.sort-icons','data' => ['direction' => $direction,'attributes' => $attributes->merge($customSortButtonAttributes)
                            ->class(['' => ($customSortButtonAttributes['default-colors'] ?? true || $customSortButtonAttributes['default'] ?? true)])
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('livewire-tables::table.th.sort-icons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['direction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($direction),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->merge($customSortButtonAttributes)
                            ->class(['' => ($customSortButtonAttributes['default-colors'] ?? true || $customSortButtonAttributes['default'] ?? true)])
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key']))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald04625f556cffd8002726af5c6e9144f)): ?>
<?php $attributes = $__attributesOriginald04625f556cffd8002726af5c6e9144f; ?>
<?php unset($__attributesOriginald04625f556cffd8002726af5c6e9144f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald04625f556cffd8002726af5c6e9144f)): ?>
<?php $component = $__componentOriginald04625f556cffd8002726af5c6e9144f; ?>
<?php unset($__componentOriginald04625f556cffd8002726af5c6e9144f); ?>
<?php endif; ?>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </th>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\src/../resources/views/components/table/th.blade.php ENDPATH**/ ?>