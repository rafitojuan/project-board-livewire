<div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card rounded-4 overflow-hidden shadow-sm">
                <div class="bg-primary-subtle">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Halo !</h5>
                                <p>Glide Dashboard</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="<?php echo e(URL::asset('build/images/profile-img.png')); ?>" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#imagePreviewModal" onclick="showPreview(this)">
                                <img src="<?php echo e(isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('build/images/users/avatar-1.jpg')); ?>"
                                    alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate"><?php echo e(Str::ucfirst(Auth::user()->name)); ?></h5>
                            <p class="text-muted mb-0 text-truncate"><?php echo e(Str::ucfirst(Auth::user()->role->name)); ?></p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15"><?php echo e($dashboard[0]->jlh_tasklists_aktif); ?></h5>
                                        <p class="text-muted mb-0">Projek</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">
                                            Rp<?php echo e(number_format($dashboard[0]->total_nilai, 0, ',', '.')); ?></h5>
                                        <p class="text-muted mb-0">Nilai</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded-4 shadow-sm" style="max-height: calc(81vh - 300px); overflow-y: auto;">
                <div class="card-body">
                    <h4 class="card-title mb-4">Semua Projek Aktif</h4>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tasklistsRekapActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tasklists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4 d-flex align-items-center">
                            <h5 class="font-size-14 mb-0 flex-grow-1"><?php echo e(Str::limit($tasklists->tasklists_name, 31)); ?>

                            </h5>
                            <div class="progress w-50 ms-3">
                                <!--[if BLOCK]><![endif]--><?php if($tasklists->progress !== null): ?>
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar"
                                        style="width: <?php echo e($tasklists->progress); ?>%; background-color: <?php echo e($tasklists->warna_status); ?>;"
                                        aria-valuenow="<?php echo e($tasklists->progress); ?>" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?php echo e($tasklists->progress); ?>%
                                    </div>
                                <?php else: ?>
                                    <div class="progress-bar" role="progressbar"
                                        style="width: 100%; background-color: #e9ecef;">
                                        <span class="text-dark">Belum ada progress</span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="text-end">
                        <a href="<?php echo e(route('kanban.index')); ?>" class="btn btn-primary waves-effect waves-light btn-sm">
                            Lihat Projek
                            <i class="mdi mdi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="card rounded-4 mini-stats-wid shadow-sm">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Nilai</p>
                                    <h4 class="mb-0">Rp
                                        <?php echo e(number_format($dashboard[0]->total_nilai, 0, ',', '.')); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-dollar font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-4 mini-stats-wid shadow-sm">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Biaya</p>
                                    <h4 class="mb-0">Rp
                                        <?php echo e(number_format($dashboard[0]->total_keseluruhan_biaya, 0, ',', '.')); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-transfer-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-4 mini-stats-wid shadow-sm">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">On Progress</p>
                                    <h4 class="mb-0">
                                        <?php echo e($dashboard[0]->jlh_tasklists_progress ? $dashboard[0]->jlh_tasklists_progress : '-'); ?>

                                    </h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-4 mini-stats-wid shadow-sm">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Completed</p>
                                    <h4 class="mb-0">
                                        <?php echo e($dashboard[0]->jlh_tasklists_selesai ? $dashboard[0]->jlh_tasklists_selesai : '-'); ?>

                                    </h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-list-check font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Email Sent</h4>
                        <div class="ms-auto">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Year</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="stacked-column-chart" data-colors='["--bs-primary", "--bs-warning", "--bs-success"]'
                        class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center p-0">
                    <img id="previewImage" src="" class="img-fluid rounded" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('script'); ?>
        <!-- apexcharts -->
        <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>

        <!-- dashboard init -->
        <script src="<?php echo e(URL::asset('build/js/pages/dashboard.init.js')); ?>"></script>
        <script>
            function showPreview(element) {
                const imgSrc = element.querySelector('img').src;
                document.getElementById('previewImage').src = imgSrc;
            }
        </script>
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/dashboard.blade.php ENDPATH**/ ?>