<div>
    <div class="task" draggable="true" x-data=""
        @dragstart="$dispatch('dragstart', { id: <?php echo e($task->id); ?> })"
        @dragstart.window="if ($event.detail.id === <?php echo e($task->id); ?>) dragging = $event.detail.id"
        @dragend.window="if ($event.detail.id === <?php echo e($task->id); ?>) dragging = null"
        @click="$wire.toggleNestedBoard()">
        <?php echo e($task->name); ?>

    </div>
    <!--[if BLOCK]><![endif]--><?php if($showNestedBoard && $task->taskList): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('task-list', ['taskList' => $task->taskList]);

$__html = app('livewire')->mount($__name, $__params, 'nested-'.$task->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/task.blade.php ENDPATH**/ ?>