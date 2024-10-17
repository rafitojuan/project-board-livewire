<?php foreach ((['component','isTailwind','isBootstrap']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<?php ($toolsAttributes = $this->getToolsAttributesBag()); ?>

<div <?php echo e($toolsAttributes->merge()
        ->class(['flex-col' => $isTailwind && ($toolsAttributes['default-styling'] ?? true)])
        ->class(['d-flex flex-column' => $isBootstrap && ($toolsAttributes['default-styling'] ?? true)])
        ->except(['default','default-styling','default-colors'])); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\src/../resources/views/components/tools.blade.php ENDPATH**/ ?>