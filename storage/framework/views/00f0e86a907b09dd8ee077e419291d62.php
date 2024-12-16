

<?php $__env->startSection('title'); ?>
    Log Aktivitas
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Semua Log</h5>
                <a href="<?php echo e(route('kanban.index')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Project</th>
                                <th>Keterangan</th>
                                <th>Pengguna</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($log->created_at->setTimezone('Asia/Jakarta')); ?></td>
                                    <td><?php echo e($log->subject->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($log->description); ?></td>
                                    <td><?php echo e($log->causer ? $log->causer->name : 'System'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-secondary">
                                        <p>- Belum ada aktivitas -</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/log.blade.php ENDPATH**/ ?>