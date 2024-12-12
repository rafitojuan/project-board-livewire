<div>
    <div class="row">
        <!--[if BLOCK]><![endif]--><?php if($tugasUser->isEmpty()): ?>
            <div class="d-flex justify-content-center align-items-center" style="height: 65vh;">
                <div class="text-center">
                    <i class="fas fa-tasks fa-3x mb-3"></i>
                    <p class="h5">Belum ada tugas.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-3">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-body">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tugasUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!--[if BLOCK]><![endif]--><?php if($tugas->nama_projek_aktif): ?>
                                <h4 class="card-title"><?php echo e($loop->iteration); ?>. <?php echo e($tugas->nama_projek_aktif); ?></h4>
                                <!--[if BLOCK]><![endif]--><?php if($tugas->kegiatan_list): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = json_decode($tugas->kegiatan_list); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kegiatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <!--[if BLOCK]><![endif]--><?php if($kegiatan->subtasks): ?>
                                            <div class="card-text mt-1">
                                                <span class="fw-bold">• <?php echo e($kegiatan->nama_kegiatan); ?> :</span>
                                                <!--[if BLOCK]><![endif]--><?php if($kegiatan->subtasks): ?>
                                                    <ul>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $kegiatan->subtasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <!--[if BLOCK]><![endif]--><?php if($tugas->rap != null && Auth::user()->role_id <= 2): ?>
                                                                <li>
                                                                    <?php echo e($tugas->nama_tugas); ?>

                                                                    <span class="ms-2" style="cursor: pointer"
                                                                        x-data="{ isOpen: false, lastClicked: null }"
                                                                        @click=" if (lastClicked === <?php echo e($tugas->id_tugas); ?>) {
                                                                            console.log('nutup');
                                                                            isOpen = false;
                                                                            lastClicked = null;
                                                                            $refs.detailTugas.classList.add('d-none');
                                                                        } else {
                                                                            console.log('buka');
                                                                            $dispatch('close-others');
                                                                            isOpen = true;
                                                                            lastClicked = <?php echo e($tugas->id_tugas); ?>;
                                                                            $refs.detailTugas.classList.remove('d-none');
                                                                            $refs.detailTugas.classList.add('fade-left');
                                                                            $wire.showTugasUser(<?php echo e($tugas->id_tugas); ?>)
                                                                        }
                                                                    ">
                                                                        <i class="fas"
                                                                            :class="{
                                                                                'fa-eye': !isOpen,
                                                                                'fa-eye-slash': isOpen
                                                                            }"
                                                                            @close-others.window="if (!$el.isSameNode($event.target)) { isOpen = false; lastClicked = null; }">
                                                                        </i>
                                                                    </span>
                                                                </li>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            <!--[if BLOCK]><![endif]--><?php if($tugas->nama_tugas && $tugas->pelaksana_id == Auth::user()->id): ?>
                                                                <li>
                                                                    <?php echo e($tugas->nama_tugas); ?>

                                                                    <span class="ms-2" style="cursor: pointer"
                                                                        x-data="{ isOpen: false, lastClicked: null }"
                                                                        @click=" if (lastClicked == <?php echo e($tugas->id_tugas); ?>) {
                                                                                    console.log('nutup');
                                                                                    isOpen = false;
                                                                                    lastClicked = null;
                                                                                    $refs.detailTugas.classList.add('d-none');
                                                                                } else {
                                                                                    console.log('buka');
                                                                                    $dispatch('close-others');
                                                                                    isOpen = true;
                                                                                    lastClicked = <?php echo e($tugas->id_tugas); ?>;
                                                                                    $refs.detailTugas.classList.remove('d-none');
                                                                                    $refs.detailTugas.classList.add('fade-left');
                                                                                    $wire.showTugasUser(<?php echo e($tugas->id_tugas); ?>);
                                                                                }
                                                                            ">
                                                                        <i class="fas"
                                                                            :class="{
                                                                                'fa-eye': !isOpen,
                                                                                'fa-eye-slash': isOpen
                                                                            }"
                                                                            @close-others.window="if (!$el.isSameNode($event.target)) { isOpen = false; lastClicked = null; }">
                                                                        </i>
                                                                    </span>
                                                                </li>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </ul>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="row">
                        <div class="col-4">
                            <div class="card rounded-4 mini-stats-wid shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Potential</p>
                                            <h4 class="mb-0"><?php echo e($userData->jlh_tasklists_potential_user); ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-bulb font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card rounded-4 mini-stats-wid shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">In Progress</p>
                                            <h4 class="mb-0"><?php echo e($userData->jlh_tasklists_onprogress_user); ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bxs-hourglass font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card rounded-4 mini-stats-wid shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Completed</p>
                                            <h4 class="mb-0"><?php echo e($userData->jlh_tasklists_completed_user); ?></h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-list-check font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-4 shadow-sm" x-ref="detailTugas" id="detail-tugas">
                    <style>
                        .fade-left {
                            animation: fadeLeft 0.5s ease-in;
                        }

                        @keyframes fadeLeft {
                            from {
                                opacity: 0;
                                transform: translateX(20px);
                            }

                            to {
                                opacity: 1;
                                transform: translateX(0);
                            }
                        }
                    </style>
                    <div class="card-body">
                        <h4 class="card-title">Detail Pekerjaan</h4>
                        <p class="card-text">
                        <form wire:submit.prevent="updateTugas">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" x-ref='namaTugas' wire:model='namaTugas'
                                    class="form-control rounded-3 <?php $__errorArgs = ['namaTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="name">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['namaTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-3">
                                <label for="pelaksana" class="form-label">Pelaksana</label>
                                <select wire:model='namaPelaksana'
                                    class="form-select rounded-3 <?php $__errorArgs = ['namaPelaksana'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="pelaksana">
                                    <option value="" disabled>Pilih Pelaksana</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $pelaksanaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelaksana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($pelaksana->id); ?>"><?php echo e($pelaksana->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['namaPelaksana'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" wire:model='mulaiTugas'
                                            class="form-control rounded-3 <?php $__errorArgs = ['mulaiTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="tanggal_mulai">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['mulaiTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="col">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                        <input type="date" wire:model='akhirTugas'
                                            class="form-control rounded-3 <?php $__errorArgs = ['akhirTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="tanggal_akhir">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['akhirTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="biaya" class="form-label">Biaya</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" wire:model='biayaTugas'
                                        class="form-control <?php $__errorArgs = ['biayaTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="biaya">
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['biayaTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-3">
                                <label for="statusa" class="form-label">Status</label>
                                <select id="statusa"
                                    class="form-select rounded-3 <?php $__errorArgs = ['statusTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    wire:model='statusTugas'>
                                    <option disabled>Pilih Status</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->id); ?>"><?php echo e($status->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['statusTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" wire:model='keteranganTugas'
                                    class="form-control rounded-3 <?php $__errorArgs = ['keteranganTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" cols="10" rows="3"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['keteranganTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-3">
                                <label for="url">URL <span class="text-sm">(Lampiran)</span></label>
                                <input type="url" wire:model='urlTugas'
                                    class="form-control rounded-3 <?php $__errorArgs = ['urlTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="url"
                                    placeholder="<?php echo e(empty($urlTugas) ? 'Tidak ada lampiran' : 'https://example.com'); ?>">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['urlTugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="text-end mb-3">
                                <button class="btn btn-primary btn-sm rounded-4">Simpan</button>
                            </div>
                        </form>
                        </p>
                    </div>
                </div>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <?php $__env->startSection('script'); ?>
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/tugas.blade.php ENDPATH**/ ?>