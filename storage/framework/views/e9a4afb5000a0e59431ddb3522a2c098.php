<div class="kanban-column">
    <h2><?php echo e($column->name); ?></h2>

    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $column->tasklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tasklist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('kanban-tasklist', ['tasklist' => $tasklist]);

$__html = app('livewire')->mount($__name, $__params, $tasklist->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/column.blade.php ENDPATH**/ ?>