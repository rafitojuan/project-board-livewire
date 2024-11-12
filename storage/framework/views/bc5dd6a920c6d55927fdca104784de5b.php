<button 
    <?php echo count($attributes) ? $column->arrayToAttributes($attributes) : ''; ?>

    <?php if($column->hasConfirmMessage()): ?>
        wire:confirm="<?php echo e($column->getConfirmMessage()); ?>"
    <?php endif; ?>
    <?php if($column->hasActionCallback()): ?>
        wire:click="<?php echo e($path); ?>"
    <?php endif; ?>
><?php echo e($title); ?></button>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\includes\columns\wire-link.blade.php ENDPATH**/ ?>