<div class="kanban-tasklist">
    <h3><?php echo e($tasklist->name); ?></h3>
    <ul>
        <?php if($tasklist->tasks && $tasklist->tasks->count()): ?>
            <?php $__currentLoopData = $tasklist->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($task->name); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <li>Tidak ada tugas.</li> <!-- Pesan jika tidak ada tugas -->
        <?php endif; ?>
    </ul>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views\livewire\task-list.blade.php ENDPATH**/ ?>