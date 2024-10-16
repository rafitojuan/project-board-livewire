<div class="kanban-board">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('column', ['column' => $column]);

$__html = app('livewire')->mount($__name, $__params, $column->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/kanban-board.blade.php ENDPATH**/ ?>