<?php foreach ((['component', 'tableName', 'primaryKey','isTailwind','isBootstrap']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['row', 'rowIndex']));

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

foreach (array_filter((['row', 'rowIndex']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $customAttributes = $this->getTrAttributes($row, $rowIndex);
?>

<?php if($this->collapsingColumnsAreEnabled() && $this->hasCollapsedColumns()): ?>
    <?php
        $colspan = $this->getColspanCount();
        $columns = collect();

        if($this->shouldCollapseAlways())
        {
            $columns->push($this->getCollapsedAlwaysColumns());
        }
        if ($this->shouldCollapseOnMobile() && $this->shouldCollapseOnTablet()) {
            $columns->push($this->getCollapsedMobileColumns());
            $columns->push($this->getCollapsedTabletColumns());
        } elseif ($this->shouldCollapseOnTablet() && ! $this->shouldCollapseOnMobile()) {
            $columns->push($this->getCollapsedTabletColumns());
        } elseif ($this->shouldCollapseOnMobile() && ! $this->shouldCollapseOnTablet()) {
            $columns->push($this->getCollapsedMobileColumns());
        }

        $columns = $columns->collapse();
    ?>

    <tr
        x-data
        @toggle-row-content.window="($event.detail.tableName === '<?php echo e($tableName); ?>' && $event.detail.row === <?php echo e($rowIndex); ?>) ? $el.classList.toggle('<?php echo e($isBootstrap ? 'd-none' : 'hidden'); ?>') : null"

        wire:key="<?php echo e($tableName); ?>-row-<?php echo e($row->{$primaryKey}); ?>-collapsed-contents"
        wire:loading.class.delay="opacity-50 dark:bg-gray-900 dark:opacity-60"
        <?php echo e($attributes->merge($customAttributes)
                ->class(['hidden bg-white dark:bg-gray-700 dark:text-white rappasoft-striped-row' => ($isTailwind && ($customAttributes['default'] ?? true) && $rowIndex % 2 === 0)])
                ->class(['hidden bg-gray-50 dark:bg-gray-800 dark:text-white rappasoft-striped-row' => ($isTailwind && ($customAttributes['default'] ?? true) && $rowIndex % 2 !== 0)])
                ->class(['d-none bg-light rappasoft-striped-row' => ($isBootstrap && $rowIndex % 2 === 0 && ($customAttributes['default'] ?? true))])
                ->class(['d-none bg-white rappasoft-striped-row' => ($isBootstrap && $rowIndex % 2 !== 0 && ($customAttributes['default'] ?? true))])
                ->except(['default','default-styling','default-colors'])); ?>


    >
        <td
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'text-left pt-4 pb-2 px-4' => $isTailwind,
                'text-start pt-3 p-2' => $isBootstrap,
            ]); ?>"
            colspan="<?php echo e($colspan); ?>"
        >
            <div>
                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colIndex => $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($column->isHidden()) continue; ?>
                    <?php if($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column)) continue; ?>

                    <p wire:key="<?php echo e($tableName); ?>-row-<?php echo e($row->{$primaryKey}); ?>-collapsed-contents-<?php echo e($colIndex); ?>"
                    
                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'block mb-2' => $isTailwind && $column->shouldCollapseAlways(),
                            'block mb-2 sm:hidden' => $isTailwind && !$column->shouldCollapseAlways() && !$column->shouldCollapseOnTablet() && !$column->shouldCollapseOnMobile(),
                            'block mb-2 md:hidden' => $isTailwind && !$column->shouldCollapseAlways() && !$column->shouldCollapseOnTablet() && $column->shouldCollapseOnMobile(),
                            'block mb-2 lg:hidden' => $isTailwind && !$column->shouldCollapseAlways() && ($column->shouldCollapseOnTablet() || $column->shouldCollapseOnMobile()),
                            
                            'd-block mb-2' => $isBootstrap && $column->shouldCollapseAlways(),
                            'd-block mb-2 d-sm-none' => $isBootstrap && !$column->shouldCollapseAlways() && !$column->shouldCollapseOnTablet() && !$column->shouldCollapseOnMobile(),
                            'd-block mb-2 d-md-none' => $isBootstrap && !$column->shouldCollapseAlways() && !$column->shouldCollapseOnTablet() && $column->shouldCollapseOnMobile(),
                            'd-block mb-2 d-lg-none' => $isBootstrap && !$column->shouldCollapseAlways() && ($column->shouldCollapseOnTablet() || $column->shouldCollapseOnMobile()),

                        ]); ?>"
                    >
                        <strong><?php echo e($column->getTitle()); ?></strong>: <?php echo e($column->renderContents($row)); ?>

                    </p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </td>
    </tr>
<?php endif; ?>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\table\collapsed-columns.blade.php ENDPATH**/ ?>