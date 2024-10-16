<div class="kanban-tasklist">
    <h3><?php echo e($tasklist->name); ?></h3>
    <ul>
        <!--[if BLOCK]><![endif]--><?php if($tasklist->tasks && $tasklist->tasks->count()): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tasklist->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($task->name); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php else: ?>
            <li>Tidak ada tugas.</li> <!-- Pesan jika tidak ada tugas -->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </ul>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/task-list.blade.php ENDPATH**/ ?>