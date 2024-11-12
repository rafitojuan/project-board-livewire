<?php foreach ((['component', 'tableName','isTailwind','isBootstrap']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php if($this->collapsingColumnsAreEnabled() && $this->hasCollapsedColumns()): ?>
    <?php if($isTailwind): ?>
        <th
            scope="col"
            <?php echo e($attributes
                    ->merge(['class' => 'table-cell dark:bg-gray-800 laravel-livewire-tables-reorderingMinimised'])
                    ->class(['sm:hidden' => !$this->shouldCollapseOnTablet() && !$this->shouldCollapseAlways()])
                    ->class(['md:hidden' => !$this->shouldCollapseOnMobile() && !$this->shouldCollapseOnTablet() && !$this->shouldCollapseAlways()])
                    ->class(['lg:hidden' => !$this->shouldCollapseAlways()])); ?>

            :class="{ 'laravel-livewire-tables-reorderingMinimised': ! currentlyReorderingStatus }"
        ></th>
    <?php elseif($isBootstrap): ?>
        <th
            scope="col"
            <?php echo e($attributes
                    ->merge(['class' => 'd-table-cell laravel-livewire-tables-reorderingMinimised'])
                    ->class(['d-sm-none' => !$this->shouldCollapseOnTablet() && !$this->shouldCollapseAlways()])
                    ->class(['d-md-none' => !$this->shouldCollapseOnMobile() && !$this->shouldCollapseOnTablet() && !$this->shouldCollapseAlways()])
                    ->class(['d-lg-none' => !$this->shouldCollapseAlways()])); ?>                    
            :class="{ 'laravel-livewire-tables-reorderingMinimised': ! currentlyReorderingStatus }"
        ></th>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\table\th\collapsed-columns.blade.php ENDPATH**/ ?>