<div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 btn btn-outline-secondary btn-sm"
                    onclick="window.location.href='<?php echo e(route('pengumuman.index', ['id' => $idTim])); ?>'">
                    <i class="bx bx-chevron-left" style="transition: transform 0.3s ease; cursor: pointer;"
                        onmouseover="this.style.transform='translateX(-5px)'"
                        onmouseout="this.style.transform='translateX(0)'">
                    </i>
                    <span>kembali</span>
                </div>
                <div class="pt-3">
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <a href="#" class="badge bg-primary font-size-12">
                                            <i class="bx bx-purchase-tag-alt align-middle text-light me-1"></i>
                                            <?php echo e($announcement['category']); ?>

                                        </a>
                                    </div>
                                    <h4><?php echo e($announcement['title']); ?></h4>
                                    <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i>
                                        <?php echo e(\Carbon\Carbon::parse($announcement['created_at'])->format('d M, Y')); ?></p>
                                </div>

                                <hr>
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div>
                                                <p class="text-muted mb-2">Kategori</p>
                                                <h5 class="font-size-15"><?php echo e($announcement['category']); ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Tanggal</p>
                                                <h5 class="font-size-15">
                                                    <?php echo e(\Carbon\Carbon::parse($announcement['created_at'])->format('d M, Y')); ?>

                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Di publish oleh</p>
                                                <h5 class="font-size-15"><?php echo e($announcement['user']['name']); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                

                                

                                <div class="mt-4">
                                    <div class="text-muted font-size-14">
                                        <?php echo $announcement['content']; ?>


                                    </div>

                                    <hr>

                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('komentar', ['announcementId' => $announcement['id']]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2003629594-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/detail-pengumuman.blade.php ENDPATH**/ ?>