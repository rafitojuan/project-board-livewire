<div>
    <div class="nav d-flex shadow-lg rounded-4 p-2 d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center" style="cursor: pointer;"
                onclick="window.location='<?php echo e(route('tim.index')); ?>'">
                <i class="bx bx-chevron-left fs-1" style="transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateX(-7px)'; this.nextElementSibling.style.transform='translateX(-7px)'"
                    onmouseout="this.style.transform='translateX(0)'; this.nextElementSibling.style.transform='translateX(0)'"></i>
                <h4 class="mb-0 ms-2" style="transition: transform 0.3s ease;"
                    onmouseover="this.previousElementSibling.style.transform='translateX(-7px)'"
                    onmouseout="this.previousElementSibling.style.transform='translateX(0)'">
                    <?php echo e($team['nama_tim']); ?></h4>
            </div>

            <div class="d-flex align-items-center ms-4 rounded-4" data-bs-toggle="modal" data-bs-target="#modalAksesTim"
                style="cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#f0f0f0'"
                onmouseout="this.style.backgroundColor='transparent'">
                <i class='bx bxs-check-shield fs-3'></i>
                <h5 class="mb-0 ms-1">
                    Atur Akses</h5>
            </div>

        </div>
        <div>
            <div class="d-flex align-items-center">
                <div class="avatar-group">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $team['teamaccess']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="avatar">
                            <img src="<?php echo e($member['user']['avatar'] ? asset($member['user']['avatar']) : asset('build/images/users/avatar-1.jpg')); ?>"
                                class="rounded-circle" width="32" alt="foto profil">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="ms-2">
                    <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle='modal'
                        data-bs-target="#modalTambahAnggota">
                        <i class="bx bx-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" style="margin-top: 3vh">
            <div class="col-md-4">
                <div class="card text-center rounded-5 position-relative"
                    style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)';this.querySelector('.locked-overlay').style.opacity='1'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';this.querySelector('.locked-overlay').style.opacity='0'">
                        <img src="<?php echo e(URL::asset('build/images/teams/chat.svg')); ?>" class="w-75" alt="logo chat">
                        <h4 class="card-text">Chat</h4>
                        <div class="locked-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded-5"
                            style="background-color: rgba(0,0,0,0.7); opacity: 0; transition: opacity 0.3s ease;">
                            <div class="text-white">
                                <i class="bx bx-lock-alt fs-1"></i>
                                <div>Tunggu update selanjutnya hehe</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/pengumuman.svg')); ?>" class="w-75"
                            alt="logo pengumuman">
                        <h4 class="card-text">Pengumuman</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body" onclick="window.location.href='<?php echo e(route('kalendar.index')); ?>'"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/kalendar.svg')); ?>" class="w-75"
                            alt="logo kalendar">
                        <h4 class="card-text">Kalendar</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body"
                        onclick="window.location.href='<?php echo e(route('kanban.index', Crypt::encryptString($team['id']))); ?>'"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/projek.svg')); ?>" class="w-75" alt="logo tugas">
                        <h4 class="card-text">Projek</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body" onclick="window.location.href='<?php echo e(route('tugas.index')); ?>'"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/tugas.svg')); ?>" class="w-75"
                            alt="logo pertanyaan">
                        <h4 class="card-text">Tugas</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalTambahAnggota" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Undang Anggota ke <?php echo e($team['nama_tim']); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" wire:submit.prevent="undangAnggota">
                    <div class="modal-body">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('users-table', ['teamId' => ''.e($team['id']).'']);

$__html = app('livewire')->mount($__name, $__params, 'lw-2021936571-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="undangAnggota">Simpan</span>
                            <span wire:loading wire:target="undangAnggota">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal" id="modalAksesTim" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Daftar Akses di : <?php echo e($team['nama_tim']); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="simpanAksesTim">
                    <div class="modal-body">
                        <p>Anda dapat mengatur akses anggota tim. Admin
                            memiliki akses penuh untuk mengelola tim, sedangkan Anggota memiliki akses terbatas sesuai
                            dengan pengaturan tim.</p>
                        <div class="mb-3 mt-3">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tbody>
                                            <tr class="">
                                                <td scope="row" class="d-flex align-items-center">
                                                    <img src="<?php echo e(asset($member['user']['avatar'])); ?>" alt=""
                                                        width="40px" height="40px" class="rounded-circle">
                                                    <div class="ms-2">
                                                        <p class="mb-0 fw-bold d-flex align-items-center">
                                                            <?php echo e($member['user']['name']); ?> <span
                                                                class="badge <?php echo e($member['role_team'] == 1 ? 'bg-success' : ($member['role_team'] == 2 ? 'bg-primary' : 'bg-warning')); ?> ms-2 fs-6"><?php echo e($member['role_team'] == 1 ? 'Manajer' : ($member['role_team'] == 2 ? 'Kontributor' : 'Member')); ?></span>
                                                        </p> <small><?php echo e($member['user']['role']['name']); ?></small>
                                                    </div>
                                                </td>
                                                <td wire:key="anggota-<?php echo e($member['user']['id']); ?>">
                                                    <form>
                                                        <select id="roleAnggota"
                                                            class="form-select <?php $__errorArgs = ['selectPeranAnggota.' . $member['user']['id']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            wire:model='selectPeranAnggota.<?php echo e($member['user']['id']); ?>'>
                                                            <option value="1"
                                                                <?php echo e($member['role_team'] == 1 ? 'selected' : ''); ?>>
                                                                Manajer</option>
                                                            <option value="2"
                                                                <?php echo e($member['role_team'] == 2 ? 'selected' : ''); ?>>
                                                                Kontributor</option>
                                                            <option value="3"
                                                                <?php echo e($member['role_team'] == 3 ? 'selected' : ''); ?>>
                                                                Member</option>
                                                        </select>
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectPeranAnggota.' . $member['user']['id']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback">
                                                                <?php echo e($message); ?>

                                                            </div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="simpanAksesTim"
                                class="spinner-border spinner-border-sm me-1" role="status"
                                aria-hidden="true"></span>
                            <span wire:loading wire:target="simpanAksesTim">Menyimpan...</span>
                            <span wire:loading.remove wire:target="simpanAksesTim">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/tim-detail.blade.php ENDPATH**/ ?>