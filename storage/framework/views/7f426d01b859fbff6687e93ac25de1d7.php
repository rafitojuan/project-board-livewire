<div>
    <div class="row">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4">
                <div class="card rounded-4">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#updateColumnModal"
                                    wire:click="openEditColumnModal(<?php echo e($column); ?>)">Edit</a>
                                <a class="dropdown-item" href="#"
                                    wire:click="deleteTasklistColumn(<?php echo e($column->id); ?>)">Delete</a>
                            </div>
                        </div>

                        <h4 class="card-title mb-4"><?php echo e($column->name); ?></h4>
                        <div class="task-list" data-column-id="<?php echo e($column->id); ?>" x-data="{ dropzone: null }"
                            x-init="dropzone = new Sortable($el, {
                                group: 'tasklists',
                                animation: 150,
                                onEnd: function(evt) {
                                    let columnId = evt.to.dataset.columnId;
                                    let tasklistOrder = Array.from(evt.to.children).map(el => el.dataset.tasklistId);
                                    $wire.updateTasklistOrder(columnId, tasklistOrder);
                                }
                            })">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $column->tasklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tasklist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="card task-box mb-3 rounded-4" data-tasklist-id="<?php echo e($tasklist->id); ?>"
                                    style="cursor: pointer">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#updateModal"
                                                    wire:click="openEditTasklistModal(<?php echo e($tasklist); ?>)">Edit</a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click="deleteTasklist(<?php echo e($tasklist->id); ?>)">Delete</a>
                                            </div>
                                        </div>
                                        <div class="float-end ml-2">
                                            <span class="badge rounded-pill font-size-12"
                                                style="background-color: <?php echo e(isset($tasklist->status->color) ? $tasklist->status->color : 'tomato'); ?>; opacity: 65%"><?php echo e($tasklist->status->name ?? 'No Status'); ?></span>
                                        </div>
                                        <div>
                                            <h5 class="font-size-15"><a
                                                    href="<?php echo e(route('tasklist.detail', ['encryptedId' => Crypt::encryptString($tasklist->id)])); ?>"
                                                    class="text-dark"><?php echo e(Str::limit($tasklist->name, 60) . (strlen($tasklist->name) > 60 ? '...' : '')); ?></a>
                                            </h5>
                                            <p class="text-muted">
                                                <?php echo e(\Carbon\Carbon::parse($tasklist->started_at)->format('d F Y')); ?>

                                                <span class="fw-bold mx-3">-</span>
                                                <?php echo e($tasklist->end_at ? \Carbon\Carbon::parse($tasklist->end_at)->format('d F Y') : 'N/A'); ?>

                                            </p>
                                        </div>

                                        <ul class="ps-3 mb-4 text-muted">
                                            <li class="py-1"><?php echo e($tasklist->company); ?></li>
                                            <li class="py-1"><?php echo e($tasklist->location); ?></li>
                                        </ul>

                                        <!--[if BLOCK]><![endif]--><?php if($tasklist->url): ?>
                                            <a href="<?php echo e($tasklist->url); ?>" target="_blank"
                                                class="float-start d-flex align-items-center text-decoration-none">
                                                <i class="bi bi-link-45deg fs-4 me-1"></i>
                                                <span>lampiran</span>
                                            </a>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <div class="text-end">
                                            <h5 class="font-size-15 mb-1">Rp <?php echo e(number_format($tasklist->value, 2)); ?>

                                            </h5>
                                            <p class="mb-0 text-muted">Nilai Kontrak</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted">Tidak ada project saat ini.</p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($loop->index == 0): ?>
                            <div class="text-center d-grid">
                                <a href="javascript: void(0);"
                                    class="btn btn-primary waves-effect waves-light addtask-btn"
                                    wire:click="openAddTasklistModal(<?php echo e($column->id); ?>)">
                                    <i class="mdi mdi-plus me-1"></i> Add New
                                </a>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>


    <!-- Update Tasklist Modal -->
    <div class="modal fade updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        id="updateModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Projek
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='closeEditTasklistModal'
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTasklist'>
                        <div class="mb-3">
                            <label for="company" class="form-label">Perusahaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['newTasklistCompany'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="company" placeholder="Masukkan nama perusahaan" wire:model='newTasklistCompany'>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistCompany'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Projek <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['newTasklistName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama projek" wire:model='newTasklistName'>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="contract" class="form-label">NO Kontrak <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control <?php $__errorArgs = ['newTasklistContract'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="contract"
                                placeholder="Masukkan nomor kontrak" wire:model='newTasklistContract'>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistContract'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="pengadaan" class="form-label">Pengadaan </label> <span
                                class="text-danger">*</span>
                            <select name="pengadaan" id="pengadaan"
                                class="form-select <?php $__errorArgs = ['tasklistPengadaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                wire:model='tasklistPengadaan'>
                                <option disabled selected>Pilih Pengadaan</option>
                                <option value="pl">PL</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tasklistPengadaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi <span
                                    class="text-danger">*</span></label>
                            <textarea name="location" id="location" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                onkeyup="auto_grow(this)" placeholder="Masukkan lokasi" wire:model='location' rows="3"></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="contract_date" class="form-label">TTD Kontrak <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php $__errorArgs = ['contractSignDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                wire:model='contractSignDate' value="<?php echo e(date('Y-m-d')); ?>" id="contract_date">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['contractSignDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">TGL Mulai Kontrak <span
                                        class="text-danger">*</span></label>
                                <input type="date"
                                    class="form-control <?php $__errorArgs = ['newTasklistStartDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    wire:model='newTasklistStartDate' value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                                    id="start_date">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistStartDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">TGL Akhir Kontrak <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" wire:model='newTasklistEndDate'
                                    value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>" id="end_date">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="value">Nilai Kontrak <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="number" class="form-control" id="value"
                                    placeholder="Masukkan nilai kontrak" wire:model='newTasklistValue'>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='newTasklistUrl'>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='closeEditTasklistModal'
                        data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Tasklist Modal -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Tambah Projek
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addTasklist'>
                        <div class="mb-3">
                            <label for="company" class="form-label">Perusahaan <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control <?php $__errorArgs = ['newTasklistCompany'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="company"
                                placeholder="Masukkan nama perusahaan" wire:model='newTasklistCompany'>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistCompany'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Projek <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['newTasklistName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama projek" wire:model='newTasklistName'>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="contract" class="form-label">NO Kontrak <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control <?php $__errorArgs = ['newTasklistContract'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="contract"
                                placeholder="Masukkan nomor kontrak" wire:model='newTasklistContract'>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistContract'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="pengadaan" class="form-label">Pengadaan </label> <span
                                class="text-danger">*</span>
                            <select name="pengadaan" id="pengadaan"
                                class="form-select <?php $__errorArgs = ['tasklistPengadaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                wire:model='tasklistPengadaan'>
                                <option disabled selected>Pilih Pengadaan</option>
                                <option value="pl">PL</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tasklistPengadaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi <span
                                    class="text-danger">*</span></label>
                            <textarea name="location" id="location" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                onkeyup="auto_grow(this)" placeholder="Masukkan lokasi" wire:model='location' rows="3"></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">TGL Mulai Kontrak <span
                                        class="text-danger">*</span></label>
                                <input type="date"
                                    class="form-control <?php $__errorArgs = ['newTasklistStartDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    wire:model='newTasklistStartDate' value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                                    id="start_date">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newTasklistStartDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">TGL Akhir Kontrak <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" wire:model='newTasklistEndDate'
                                    value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>" id="end_date">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="value">Nilai Kontrak <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="number" class="form-control" id="value"
                                    placeholder="Masukkan nilai kontrak" wire:model='newTasklistValue'>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='newTasklistUrl'>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Update Tasklist Column Modal -->
    <div class="modal fade updateColumnModal" tabindex="-1" id="updateColumnModal" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Kolom Projek
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTasklistColumn'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama"
                                wire:model='tasklistColumnName' required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/kanban.blade.php ENDPATH**/ ?>