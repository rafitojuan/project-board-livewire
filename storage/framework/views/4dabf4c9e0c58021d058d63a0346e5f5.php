<div>

    <div class="mb-3">
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <style>
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="row">
        <div class="col-3">
            <div class="card rounded-4 shadow-lg">
                <div class="card-header rounded-top-4" style="background-color: white; border-bottom: 1px solid #dee2e6;">
                    <nav aria-label="breadcrumb" style="margin-bottom: -0.9rem; margin-left: -0.4rem;">
                        <ol class="breadcrumb" style="font-size: 0.8rem;">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('kanban.index')); ?>"
                                    style="color:#007bff;">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('kanban.index')); ?>"
                                    style="color:#007bff;">Project</a></li>
                            <li class="breadcrumb-item active" aria-current="page">#<?php echo e($tasklist->id); ?></li>
                        </ol>
                    </nav>
                    <h4 class="card-title fs-4 ms-2"><?php echo e($tasklist->name); ?></h4>
                    <p class="card-text ms-2 mt-3 mb-3">
                        <?php echo e(\Carbon\Carbon::parse($tasklist->started_at)->format('d F Y')); ?> <span
                            class="fw-bold mx-2">-</span>
                        <?php echo e($tasklist->end_at ? \Carbon\Carbon::parse($tasklist->end_at)->format('d F Y') : 'N/A'); ?>

                    </p>
                </div>
                <div class="card-body">
                    <table class="table align-middle table-borderless" style="margin-top: -1rem;">
                        <tr>
                            <th scope="col" style="width: 40%;">Tentang Projek </th>
                            <th scope="col" class="text-end">
                                <!--[if BLOCK]><![endif]--><?php if(Auth::user()->role_id <= 2 || Auth::user()->role_id === 5): ?>
                                    <i class="bi bi-pencil-fill me-2" id="edit-detail" style="cursor: pointer"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>
                        </tr>
                        <tr>
                            <td style="width: 3%">Perusahaan</td>
                            <td><strong><?php echo e($tasklist->company); ?></strong></td>
                        </tr>
                        <tr>
                            <td style="width: 3%">ID Pekerjaan</td>
                            <td><strong><?php echo e($tasklist->work_id); ?></strong></td>
                        </tr>
                        <tr>
                            <td style="width: 3%">NO Kontrak</td>
                            <td><strong><?php echo e($tasklist->contract_number); ?></strong></td>
                        </tr>
                        <tr>
                            <td style="width: 3%">Pengadaan</td>
                            <td><strong><?php echo e(strtoupper($tasklist->pengadaan)); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td><strong><?php echo e($tasklist->location); ?></strong></td>
                        </tr>
                        <tr x-data="{
                            isEditing: false,
                            isLoading: false,
                            statusColor: '<?php echo e($tasklist->status->color); ?>',
                            saveStatus() {
                                this.isLoading = true;
                                this.isEditing = false;
                                $wire.saveTasklistStatus()
                                    .then(color => {
                                        this.statusColor = color;
                                        return new Promise(resolve => setTimeout(resolve, 8000));
                                    })
                                    .finally(() => {
                                        this.isLoading = false;
                                    });
                            }
                        }" @click.away="isEditing = false">
                            <td>Status</td>
                            <td>
                                <template x-if="!isEditing">
                                    <div class="d-flex align-items-center">
                                        <span class="badge text-capitalize"
                                            :style="`background-color: ${statusColor}; font-size: 0.7rem`"><?php echo e($tasklist->status->name ?? 'No Status'); ?></span>

                                        <!--[if BLOCK]><![endif]--><?php if(Auth::user()->role_id <= 2 || Auth::user()->role_id === 5): ?>
                                            <i class="bi bi-pencil-fill ms-2" :class="{ 'opacity-50': isLoading }"
                                                style="cursor: pointer;"
                                                @click.stop="!isLoading && (isEditing = true)"></i>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                        <i class="bi bi-arrow-repeat ms-1 spin" x-show="isLoading"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"></i>
                                    </div>
                                </template>

                                <template x-if="isEditing">
                                    <div class="d-flex">
                                        <select class="form-select" wire:model="tasklistStatus" :disabled="isLoading">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($status->id); ?>"
                                                    <?php echo e($tasklist->status->id == $status->id ? 'selected' : ''); ?>>
                                                    <?php echo e($status->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>

                                        <button class="btn btn-primary btn-sm ms-2 py-0 px-1" @click.stop="saveStatus()"
                                            :disabled="isLoading">
                                            Save
                                        </button>
                                    </div>
                                </template>
                            </td>
                        </tr>
                        <tr>
                            <td>Dibuat</td>
                            <td>
                                <span class="badge text-capitalize"
                                    style="background-color: <?php echo e($tasklist->user->role->color); ?>; font-size: 0.7rem">
                                    <?php echo e($tasklist->user->division->divisi); ?>

                                </span>
                            </td>
                        </tr>
                        <!--[if BLOCK]><![endif]--><?php if($tasklist->url): ?>
                            <tr>
                                <td>Url <small class="text-sm">(Lampiran)</small></td>
                                <td><a
                                        href="<?php echo e($tasklist->url ?? '-'); ?>"><?php echo e(Str::limit($tasklist->url ?? '-', 25, '...')); ?></a>
                                </td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <tr>
                            <td>Nilai</td>
                            <td><strong>Rp<?php echo e(number_format($tasklist->value, 0)); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Biaya (RAPP)</td>
                            <td><strong
                                    class="<?php echo e($this->getTotalBiaya() > $tasklist->value ? 'text-danger' : ($this->getTotalBiaya() < $tasklist->value ? 'text-success' : 'text-dark')); ?>">Rp<?php echo e(number_format($this->getTotalBiaya(), 0, ',', '.')); ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Akumulasi</td>
                            <td><strong
                                    class="<?php echo e($this->getTotalBiaya() > $tasklist->value ? 'text-danger' : ($this->getTotalBiaya() < $tasklist->value ? 'text-success' : 'text-dark')); ?>"><?php echo e($this->getSelisihBiaya()['prefix']); ?><?php echo e($this->getSelisihBiaya()['value']); ?>

                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="btn-group">
                            <button class="btn btn-secondary" id="btn-card" onclick="switchToCard()"><i
                                    class="bx bx-notepad"></i></button>
                            <button class="btn btn-outline-secondary" id="btn-calendar" onclick="switchToCalendar()"><i
                                    class="bx bx-calendar"></i></button>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm <?php echo e($tasklist->role_id != 2 ? 'd-none' : ''); ?>"
                                data-bs-toggle="modal" data-bs-target="#addColumnModal">Add Column</button>
                        </div>
                    </div>

                    <div id="card-view">
                        <div class="row">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tasklistColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-4">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <div
                                                class="dropdown float-end <?php echo e(Auth::user()->role_id > 3 ? 'd-none' : ''); ?>">
                                                <a href="#" class="dropdown-toggle arrow-none"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#updateTasklistColumnModal"
                                                        wire:click="openEditTasklistColumnModal(<?php echo e($column); ?>)">Edit</a>
                                                    <a class="dropdown-item" href="#"
                                                        wire:click="deleteTasklistColumn(<?php echo e($column->id); ?>)">Delete</a>
                                                </div>
                                            </div>

                                            <h4 class="card-title mb-4"><?php echo e($column->name); ?></h4>
                                            <div class="task-list" data-column-id="<?php echo e($column->id); ?>"
                                                x-data="{ dropzone: null }" x-init="dropzone = new Sortable($el, {
                                                    group: 'task',
                                                    animation: 150,
                                                    onEnd: function(evt) {
                                                        let columnId = evt.to.dataset.columnId;
                                                        let taskOrder = Array.from(evt.to.children).map(el => el.dataset.taskId);
                                                        $wire.updateTaskOrder(columnId, taskOrder);
                                                    }
                                                })">
                                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $column->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <div class="card task-box mb-3 rounded-4 shadow-lg"
                                                        data-task-id="<?php echo e($task->id); ?>"
                                                        style="cursor: grab; height: 13rem;">
                                                        <div class="card-body">
                                                            <div
                                                                class="dropdown float-end <?php echo e(Auth::user()->role_id > 3 ? 'd-none' : ''); ?>">
                                                                <a href="#" class="dropdown-toggle arrow-none"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i
                                                                        class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#updateModal"
                                                                        wire:click="openEditTaskModal(<?php echo e($task); ?>)">Edit</a>
                                                                    <a class="dropdown-item" href="#"
                                                                        wire:click="deleteTask(<?php echo e($task->id); ?>)">Delete</a>
                                                                </div>
                                                            </div>
                                                            <div class="float-end ml-2">
                                                                <span class="badge rounded-pill font-size-12"
                                                                    style="background-color: <?php echo e(isset($task->user->role->color) ? $task->user->role->color : 'tomato'); ?>;"><?php echo e($task->user->role->name); ?></span>
                                                                <span class="badge rounded-pill font-size-12"
                                                                    style="background-color: tomato; opacity: 100%"><?php echo e($task->user->division->divisi); ?></span>
                                                            </div>
                                                            <div>
                                                                <h5 class="font-size-15" style="cursor: pointer"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#subTaskModal"
                                                                    wire:click="openSubTaskModal(<?php echo e($task); ?>)">
                                                                    <?php echo e(Str::limit($task->name, 14) . (strlen($task->name) > 14 ? '...' : '')); ?>

                                                                </h5>
                                                                <small>Divisi:
                                                                    <?php echo e($task->user->division->divisi ?? '-'); ?></small><br>
                                                                <small class="text-muted mb-2">
                                                                    <?php echo e(\Carbon\Carbon::parse($task->started_at)->format('d M Y')); ?><span
                                                                        class="mx-1">-</span><?php echo e($task->end_at ? \Carbon\Carbon::parse($task->end_at)->format('d M Y') : 'N/A'); ?>

                                                                </small>
                                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $detil->where('id_tasks', $task->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="progress mt-2" style="height: 15px;">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: <?php echo e($detail->jlh_score); ?>%; background-color: <?php echo e($detail->warna_status); ?>"
                                                                            aria-valuenow="<?php echo e($detail->jlh_score); ?>"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                            <?php echo e($detail->jlh_score); ?>%
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </div>

                                                            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                                                                <!--[if BLOCK]><![endif]--><?php if($task->url): ?>
                                                                    <a href="<?php echo e($task->url); ?>" target="_blank"
                                                                        class="float-start d-flex align-items-center text-decoration-none">
                                                                        <i class="bi bi-link-45deg fs-4 me-1"></i>
                                                                        <span>lampiran</span>
                                                                    </a>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                <div class="text-end">
                                                                    <h5 class="font-size-15 mb-1">
                                                                        Rp
                                                                        <?php echo e(number_format($this->getSubtotal($task->id), 0, ',', '.')); ?>

                                                                    </h5>
                                                                    <p class="mb-0 text-muted">Biaya (RAPP)</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <p class="text-muted">Tidak ada task saat ini.</p>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                            <!--[if BLOCK]><![endif]--><?php if($loop->index == 0): ?>
                                                <div
                                                    class="text-center d-grid <?php echo e(Auth::user()->role_id === 7 ? 'd-none' : ''); ?>">
                                                    <a href="javascript: void(0);"
                                                        class="btn btn-primary waves-effect waves-light addtask-btn"
                                                        wire:click="openTaskModal(<?php echo e($column->id); ?>)">
                                                        <i class="mdi mdi-plus me-1"></i> Add New
                                                    </a>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    <div id="calendar-view" class="d-none">
                        <div wire:ignore id='calendar-tasklist'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Kegiatan Modal -->
    <div class="modal fade addTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addTask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['taskName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama" wire:model='taskName' required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['taskName'];
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
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date"
                                    class="form-control <?php $__errorArgs = ['taskStartDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    wire:model='taskStartDate' value="<?php echo e(now()->format('Y-m-d')); ?>" id="start_date">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['taskStartDate'];
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
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control <?php $__errorArgs = ['taskEndDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    wire:model='taskEndDate' id="end_date">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['taskEndDate'];
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
                        </div>
                        
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='taskUrl'>
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

    
    <div class="modal fade updateTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" id="updateModal"
        tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='closeTaskModal'
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['taskName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama" wire:model='taskName' required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['taskName'];
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
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date"
                                    class="form-control <?php $__errorArgs = ['taskStartDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    wire:model='taskStartDate' id="start_date">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['taskStartDate'];
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
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control <?php $__errorArgs = ['taskEndDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    wire:model='taskEndDate' id="end_date">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['taskEndDate'];
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
                        </div>
                        
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='taskUrl'>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='closeTaskModal'
                        data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade addColumnModal" id="addColumnModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Tasklist Column
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addTasklistColumn'>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['taskName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama" wire:model='tasklistColumnName' required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tasklistColumnName'];
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

    
    <div class="modal fade updateTasklistColumnModal" id="updateTasklistColumnModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Kegiatan Column
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTasklistColumn'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['taskName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama" wire:model='tasklistColumnName' required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tasklistColumnName'];
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


    
    <div class="modal fade" id="subTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self
        aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">
                        Form Detail Pekerjaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        wire:click='closeSubtaskModal(<?php echo e($kode); ?>)' aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="float-start">
                        <h5><?php echo e($uraian); ?></h5>
                    </div>
                    <div class="text-end mb-3">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addSubtaskModal">+ Add Detail Pekerjaan</button>
                    </div>
                    <div>
                        <!--[if BLOCK]><![endif]--><?php if($kode): ?>
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('subtasks-table', ['kode' => ''.e($kode).'']);

$__html = app('livewire')->mount($__name, $__params, 'lw-3583511551-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click='closeSubtaskModal(<?php echo e($kode); ?>)'
                        data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="addSubtaskModal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Detail Pekerjaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addSubtask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['subtaskName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama" wire:model='subtaskName' required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskName'];
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
                            <label for="name" class="form-label">Pelaksana <span
                                    class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['subtaskJob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                wire:model='subtaskJob' required>
                                <option value="">Pilih Pelaksana</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $userList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskJob'];
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
                            <label for="rab" class="form-label">RAB</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input id="rab" type="number" class="form-control"
                                    placeholder="Masukkan nominal" x-data="{ subtaskRAB: '' }"
                                    x-on:keypress="if (!/[0-9]/.test($event.key)) $event.preventDefault()"
                                    x-on:keydown="if(subtaskRAB.length >= 13 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()"
                                    wire:model="subtaskRAB" x-model="subtaskRAB" maxlength="13">
                            </div> <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskRAB'];
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
                            <label for="sap" class="form-label">Administrasi SAP </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" wire:model='subtaskSAP' type="checkbox"
                                    id="sap" role="switch" />
                                <label class="form-check-label" for="sap">Tidak/Ya</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" wire:model='subTaskKeterangan' class="form-control" cols="10" rows="3"></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subTaskKeterangan'];
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
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label">Tanggal Mulai</label>
                                    <input type="date"
                                        class="form-control <?php $__errorArgs = ['subTaskStarted'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="name" placeholder="Masukkan tanngal mulai"
                                        wire:model='subTaskStarted'>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subTaskStarted'];
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
                                    <label for="name" class="form-label">Tanggal Akhir</label>
                                    <input type="date"
                                        class="form-control <?php $__errorArgs = ['subTaskEnd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                        placeholder="Masukkan tanngal akhir" wire:model='subTaskEnd'>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subTaskEnd'];
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
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='subtaskUrl'>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#subTaskModal">
                        Back
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    

    
    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Detail Pekerjaan
                    </h5>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateSubtask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['subtaskName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama" wire:model='subtaskName' required>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskName'];
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
                            <label for="name" class="form-label">Pelaksana <span
                                    class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['subtaskJob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                wire:model='subtaskJob' required>
                                <option value="">Pilih Pelaksana</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $userList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskJob'];
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
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label">Tanggal Mulai</label> <small
                                        class="text-danger">*</small>
                                    <input type="date"
                                        class="form-control <?php $__errorArgs = ['subTaskStarted'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="name" placeholder="Masukkan tanngal mulai"
                                        wire:model='subTaskStarted'>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subTaskStarted'];
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
                                    <label for="name" class="form-label">Tanggal Akhir</label>
                                    <input type="date"
                                        class="form-control <?php $__errorArgs = ['subTaskEnd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                                        placeholder="Masukkan tanngal akhir" wire:model='subTaskEnd'>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subTaskEnd'];
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
                            </div>
                        </div>
                        <div x-data="{ subtaskRAB: <?php if ((object) ('subtaskRAB') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('subtaskRAB'->value()); ?>')<?php echo e('subtaskRAB'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('subtaskRAB'); ?>')<?php endif; ?>.defer }" class="mb-3">
                            <label for="rab" class="form-label">RAB</label> <small class="text-danger">*</small>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number"
                                    class="form-control
                                    <?php $__errorArgs = ['subtaskRAB'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="rab" placeholder="Masukkan nominal" wire:model.defer='subtaskRAB'
                                    x-model="subtaskRAB"
                                    x-on:keydown="if(subtaskRAB.length >= 10 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()"
                                    <?php echo e($subtaskRAP && Auth::user()->role_id > 2 ? 'readonly' : ''); ?>>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskRAB'];
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
                            <label for="sap" class="form-label">Administrasi SAP </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" wire:model='subtaskSAP' type="checkbox"
                                    id="sap" role="switch" />
                                <label class="form-check-label" for="sap">Tidak/Ya</label>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($subtaskSAP && Auth::user()->role_id <= 2): ?>
                            <div class='mb-3' x-data="{
                                subtaskRAP: <?php echo e($subtaskRAP ?? 'null'); ?>,
                                init() {
                                    this.subtaskRAP = <?php echo e($subtaskRAP ?? 'null'); ?>;
                                    $watch('subtaskRAP', value => {
                                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('subtaskRAP', value)
                                    })
                                }
                            }">
                                <label for="rap" class="form-label">RAP <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                        class="form-control <?php $__errorArgs = ['subtaskRAP'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        :class="{ 'is-invalid': parseInt(subtaskRAP) >= <?php echo e($subtaskRAB); ?> }"
                                        id="rap" placeholder="Masukkan nominal" x-model.number="subtaskRAP"
                                        wire:model.defer='subtaskRAP'
                                        x-on:keydown="if(!['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight','ArrowUp','ArrowDown', 'Tab'].includes($event.key) && (!$event.key.match(/^\d$/) || subtaskRAP.length >= 13 || parseInt(subtaskRAP + $event.key) > <?php echo e($subtaskRAB); ?>)) $event.preventDefault()"
                                        min="1" :max="<?php echo e($subtaskRAB - 1); ?>"
                                        oninvalid="this.setCustomValidity('RAP tidak bisa lebih atau sama dengan RAB')"
                                        oninput="this.setCustomValidity('')"
                                        <?php echo e(Auth::user()->role_id > 2 ? 'readonly' : ''); ?>>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskRAP'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <template x-if="parseInt(subtaskRAP) >= <?php echo e($subtaskRAB); ?>">
                                    <small class="text-danger">RAP tidak bisa sama dengan atau melewati RAB (RAB:
                                        <?php echo e($subtaskRAB); ?>)</small>
                                </template>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($subtaskRAP && Auth::user()->role_id != 7): ?>
                            <div x-data="{ subtaskRAPP: <?php if ((object) ('subtaskRAPP') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('subtaskRAPP'->value()); ?>')<?php echo e('subtaskRAPP'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('subtaskRAPP'); ?>')<?php endif; ?>.defer }" class="mb-3">
                                <label for="RAPP" class="form-label">RAPP <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                        class="form-control <?php $__errorArgs = ['subtaskRAPP'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        :class="{ 'is-invalid': parseInt(subtaskRAPP) >= <?php echo e($subtaskRAP); ?> }"
                                        id="RAPP" placeholder="Masukkan nominal" wire:model.defer='subtaskRAPP'
                                        x-model="subtaskRAPP"
                                        x-on:keydown="if(!['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight','ArrowUp','ArrowDown', 'Tab'].includes($event.key) && (!$event.key.match(/^\d$/) || subtaskRAPP.length >= 13 || parseInt(subtaskRAPP + $event.key) > <?php echo e($subtaskRAP); ?>)) $event.preventDefault()"
                                        min="0" :max="<?php echo e($subtaskRAP - 1); ?>"
                                        oninvalid="this.setCustomValidity('RAPP tidak bisa lebih atau sama dengan RAP')"
                                        oninput="this.setCustomValidity('')"
                                        <?php echo e(Auth::user()->role_id > 2 ? 'readonly' : ''); ?>>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtaskRAPP'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <template x-if="parseInt(subtaskRAPP) >= <?php echo e($subtaskRAP); ?>">
                                    <small class="text-danger">RAPP tidak bisa melebihi RAP (RAP:
                                        <?php echo e($subtaskRAP); ?>)</small>
                                </template>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="mb-3">
                            <label for="statusa" class="form-label">Status</label>
                            <select id="statusa" class="form-select" wire:model='subTaskStatus'>
                                <option value="" disabled>Pilih Status</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statusSubtask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option class="text-capitalize" value="<?php echo e($status->id); ?>">
                                        <?php echo e($status->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" wire:model='subTaskKeterangan' class="form-control" cols="10" rows="3"></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subTaskKeterangan'];
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
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com" wire:model='subtaskUrl'>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeSubtaskAddModal"
                                data-bs-toggle="modal" data-bs-target="#subTaskModal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalJadwal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Ubah Jadwal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="updateDetailJadwal">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Acara: <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" wire:model='namaAcaraTask'
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal Acara: <span
                                    class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="start" id="date" class="form-control"
                                        wire:model='tanggalMulaiTask'>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="end" id="date" class="form-control"
                                        wire:model='tanggalSelesaiTask'>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="finished" class="form-label">Tandai sebagai selesai?</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" wire:model='statusJadwalTask' type="checkbox"
                                    id="finished" data-on-value="6" data-off-value="1" />
                                <label class="form-check-label ms-1" for="finished">Tidak/Ya</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // CALENDARNYA
        document.addEventListener('livewire:initialized', function() {
            const jadwal = <?php echo json_encode($events, 15, 512) ?>;
            var calendarEl = document.getElementById('calendar-tasklist');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: localStorage.getItem('calendarView') || 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: 'id',
                buttonText: {
                    today: 'Hari ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari',
                    list: 'List'
                },
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'
                ],
                monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                    'Nov', 'Des'
                ],
                dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                nextDayThreshold: '00:00',
                events: jadwal,
                editable: <?php echo e(Auth::user()->role_id <= 2 ? 'true' : 'false'); ?>,
                eventResizableFromStart: <?php echo e(Auth::user()->role_id <= 2 ? 'true' : 'false'); ?>,
                selectable: <?php echo e(Auth::user()->role_id <= 2 ? 'true' : 'false'); ?>,
                eventResize: function(data) {
                    console.log('Event berhasil Diubah');
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('updateJadwal', data.event.id, data.event.start, data.event.end)
                        .then(() => {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Jadwal berhasil diperbarui',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        })
                        .catch(() => {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Gagal memperbarui jadwal',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        });
                },
                eventDrop: function(data) {
                    console.log('Event berhasil Dipindahkan');
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('updateJadwal', data.event.id, data.event.start, data.event.end)
                        .then(() => {
                            location.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Jadwal berhasil diperbarui',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        })
                        .catch(() => {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Gagal memperbarui jadwal',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        });
                },
                eventClick: function(data) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('detailJadwal', data.event.id)
                        .then(() => {
                            $('#modalJadwal').modal('show');
                        });
                },
                eventMouseEnter: function(info) {
                    if (!<?php echo e(Auth::user()->role_id <= 2 ? 'true' : 'false'); ?>) {
                        info.el.style.cursor = 'pointer';
                    }
                },
                datesSet: function(info) {
                    localStorage.setItem('calendarView', info.view.type);
                    localStorage.setItem('calendarDate', calendar.getDate().toISOString());
                },
                businessHours: [{
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '08:00',
                    endTime: '17:00',
                }]
            });

            const savedDate = localStorage.getItem('calendarDate');
            if (savedDate) {
                calendar.gotoDate(new Date(savedDate));
            }

            calendar.render();

            window.Livewire.find('<?php echo e($_instance->getId()); ?>').on('refreshCalendar', function() {
                console.log('Refresh Calendar event received');
                const currentView = localStorage.getItem('tasklistView') || 'card';

                calendar.removeAllEvents();
                calendar.addEventSource(<?php echo json_encode($events, 15, 512) ?>);

                if (currentView === 'calendar') {
                    switchToCalendar();
                } else {
                    switchToCard();
                }
            });

        })

        window.addEventListener('close-modal', event => {
            $('#modalJadwal').modal('hide');
        })




        // TABNYA
        function switchToCard() {
            localStorage.setItem('tasklistView', 'card');
            document.getElementById('btn-card').classList.remove('btn-outline-secondary');
            document.getElementById('btn-card').classList.add('btn-secondary');
            document.getElementById('btn-calendar').classList.remove('btn-secondary');
            document.getElementById('btn-calendar').classList.add('btn-outline-secondary');

            document.getElementById('card-view').classList.remove('d-none');
            document.getElementById('calendar-view').classList.add('d-none');
        }

        function switchToCalendar() {
            localStorage.setItem('tasklistView', 'calendar');
            document.getElementById('btn-calendar').classList.remove('btn-outline-secondary');
            document.getElementById('btn-calendar').classList.add('btn-secondary');
            document.getElementById('btn-card').classList.remove('btn-secondary');
            document.getElementById('btn-card').classList.add('btn-outline-secondary');

            document.getElementById('calendar-view').classList.remove('d-none');
            document.getElementById('card-view').classList.add('d-none');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const viewPreference = localStorage.getItem('tasklistView') || 'card';
            if (viewPreference === 'calendar') {
                switchToCalendar();
            } else {
                switchToCard();
            }
        });
    </script>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/tasklist-detail.blade.php ENDPATH**/ ?>