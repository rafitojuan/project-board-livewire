<style>
    .card-hover:hover {
        transform: translate(-5px, -5px);
        cursor: pointer;
    }
</style>
<div>
    <div class="mb-3 btn btn-outline-secondary btn-sm"
        onclick="window.location.href='<?php echo e(route('tim.detail', ['id' => $idTim])); ?>'">
        <i class="bx bx-chevron-left" style="transition: transform 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateX(-5px)'" onmouseout="this.style.transform='translateX(0)'">
        </i>
        <span>kembali</span>
    </div> <br>
    <button class="btn btn-primary btn-sm mb-3" onclick="window.location.href='<?php echo e(route('pengumuman.create', $idTim)); ?>'">
        <i class="bx bx-plus-circle"></i>
        <span>Buat Pengumuman</span>
    </button>

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <!--[if BLOCK]><![endif]--><?php if($announcement->isEmpty()): ?>
                <p class="text-center text-muted" style="font-size: 1.5rem;">Belum ada pengumuman</p>
            <?php else: ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $announcement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengumuman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card shadow-sm rounded-4 card-hover border border-1"
                        onclick="window.location.href='<?php echo e(route('pengumuman.view', ['id' => Crypt::encryptString($pengumuman['id'])])); ?>'"
                        style="transition: transform 0.3s;">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo e(URL::asset($pengumuman['user']['avatar'])); ?>" class="rounded-circle"
                                    height="42px" width="42px" alt="foto profil">
                                <i
                                    class="bx <?php echo e($pengumuman['post_status'] === 'draft' ? 'bxs-timer' : ($pengumuman['post_status'] === 'post' ? 'bxs-check-circle' : 'bxs-x-circle')); ?> bx-sm ms-3"></i>
                                <span class="h3 mb-0 ms-1"><?php echo e($pengumuman['title']); ?></span> <span
                                    class="badge rounded-pill text-bg-primary ms-2"><?php echo e($pengumuman['category']); ?></span>

                            </div>
                            <div class="mt-1 ms-5">
                                <span class="badge bg-primary me-2">
                                    <i class="bx bx-calendar"></i>
                                    <?php echo e(\Carbon\Carbon::parse($pengumuman['created_at'])->format('M d')); ?>

                                </span>
                                <span class="badge bg-danger">
                                    <i class="bx bx-timer"></i>
                                    <?php echo e(\Carbon\Carbon::parse($pengumuman['end_at'])->format('M d')); ?>

                                </span>
                            </div>
                            <div class="mt-1 ms-5">
                                <span class="fw-semibold text-muted">
                                    <?php echo e($pengumuman['user']['name']); ?>

                                </span>
                            </div>
                            <div class="mt-4 ms-5">
                                <span class="fw-semibold" style="display: inline-block; transition: transform 0.3s;">
                                    <?php echo e(Str::words($pengumuman['title'], 2, '...')); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        </div>
    </div>


</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/pengumuman.blade.php ENDPATH**/ ?>