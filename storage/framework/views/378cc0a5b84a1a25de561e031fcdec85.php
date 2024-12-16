<div>
    <style>
        .search-container {
            position: relative;
        }

        .search-input {
            height: 40px;
            border-radius: 30px;
            padding-left: 35px;
            border: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #888;
        }
    </style>


    <!--[if BLOCK]><![endif]--><?php if($teams->count() === 0): ?>
        <div class="row">
            <div class="col-md-3">
                <div class="search-container">
                    <input type="text" class="form-control search-input" placeholder="Cari Tim..."
                        wire:model.live="search">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
        </div>
        <div class="container">
            <!--[if BLOCK]><![endif]--><?php if(!empty($search)): ?>
                <div class="text-center mt-4">
                    <h4 class="text-muted">Tidak ada tim yang ditemukan</h4>
                    <p class="text-muted">Silakan coba dengan kata kunci pencarian yang berbeda</p>
                </div>
            <?php else: ?>
                <div class="row" style="margin-top: 10vh">
                    <div class="col-md-3">
                        <img src="<?php echo e(URL::asset('build/images/logo-tim.png')); ?>" alt="Logo Tim" width="320rem">
                    </div>
                    <div class="col-md-8 mt-4 ms-5">
                        <h2 class="mb-4">Bergeraklah, Mari mulai membuat tim!</h2>
                        <h5 class="fw-normal lh-base">Sebagai langkah pertama, Anda perlu membuat
                            tim terlebih dahulu sebelum dapat mengundang anggota untuk bergabung. Tim adalah fondasi
                            awal
                            untuk
                            berkolaborasi dan mencapai tujuan bersama.Mari mulai perjalanan
                            kolaborasi dengan membuat tim Anda sekarang!</h5>
                        <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalTambahTim"
                            style="background-color: #2A3042; border-color: #2A3042; transition: opacity 0.3s;"
                            onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Buat
                            Tim</button>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-3">
                <div class="search-container">
                    <input type="text" class="form-control search-input" placeholder="Cari Tim..."
                        wire:model.live="search">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
        </div>
        <!--[if BLOCK]><![endif]--><?php if(count($teamPusat) > 0): ?>
            
            <div class="row mt-4 ms-3">
                <div class="opacity-75">
                    <h3><i class='bx bx-building'></i> Kantor Pusat</h3>
                    <div class="d-flex align-items-center">
                        <div class="border border-1 border-secondary w-75"></div>
                        <i data-bs-toggle="modal" data-bs-target="#modalTambahTim" class='bx bxs-plus-circle ms-0'
                            style="color: #0547d3; font-size: 3rem; cursor: pointer; transition: opacity 0.3s"
                            onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'"></i>
                    </div>
                </div>
                <div class="row mt-1">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $teamPusat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--[if BLOCK]><![endif]--><?php if(empty($search) ||
                                str_contains(strtolower($team['nama_tim']), strtolower($search)) ||
                                str_contains(strtolower($team['deskripsi']), strtolower($search))): ?>
                            <div class="col-md-3">
                                <div class="card rounded-4 shadow-sm kartuTim"
                                    style="height: 13rem; transition: transform 0.3s, box-shadow 0.3s;"
                                    onclick="window.location.href='<?php echo e(route('tim.detail', ['id' => Crypt::encryptString($team['id'])])); ?>'"
                                    onmouseover="this.style.transform='translate(-5px, -5px)';  this.style.cursor='pointer'; this.style.backgroundColor='<?php echo e($team['warna_tim']); ?>'; this.style.color='#fff';"
                                    onmouseout="this.style.transform='none'; this.style.backgroundColor=''; this.style.color=''">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-text"><?php echo e($team['nama_tim']); ?></h4>
                                            <div class="dropdown">
                                                <button class="btn btn-link p-0 rounded" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="background-color: white; width: 30px; height: 30px;">
                                                    <i class="bx bx-dots-vertical-rounded fs-4 text-dark"></i>
                                                </button>
                                                <ul class="dropdown-menu rounded-3">
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='fetchTeamToEdit(<?php echo e($team); ?>)'
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalUbahWarnaTim"><i class='bx bxs-circle'
                                                                style="color: <?php echo e($team['warna_tim']); ?>"></i>
                                                            Warna</a></li>
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='fetchTeamToEdit(<?php echo e($team); ?>)'
                                                            data-bs-toggle="modal" data-bs-target="#modalEditTim"><i
                                                                class='bx bx-edit'></i>
                                                            Ubah</a></li>
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='teamArchive(<?php echo e($team['id']); ?>)'><i
                                                                class='bx bx-archive'></i>
                                                            Arsipkan</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text mt-2 small"><?php echo e($team['deskripsi']); ?></p>
                                    </div>
                                    <div class="card-footer rounded-bottom-4"
                                        style="height: 1px; background-color: <?php echo e($team['warna_tim']); ?>;">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 


        
        <!--[if BLOCK]><![endif]--><?php if(count($teamDivision) > 0): ?>
            <div class="row mt-4 ms-3">
                <div class="opacity-75">
                    <h3><i class='bx bx-group'></i> Divisi</h3>
                    <div class="d-flex align-items-center">
                        <div class="border border-1 border-secondary w-75"></div>
                        <i data-bs-toggle="modal" data-bs-target="#modalTambahTim" class='bx bxs-plus-circle ms-0'
                            style="color: #0547d3; font-size: 3rem; cursor: pointer; transition: opacity 0.3s"
                            onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'"></i>
                    </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $teamDivision; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(empty($search) ||
                            str_contains(strtolower($team['nama_tim']), strtolower($search)) ||
                            str_contains(strtolower($team['deskripsi']), strtolower($search))): ?>
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <div class="card rounded-4 shadow-sm kartuTim"
                                    style="height: 13rem; transition: transform 0.3s, box-shadow 0.3s;"
                                    onclick="window.location.href='<?php echo e(route('tim.detail', ['id' => Crypt::encryptString($team['id'])])); ?>'"
                                    onmouseover="this.style.transform='translate(-5px, -5px)';  this.style.cursor='pointer'; this.style.backgroundColor='<?php echo e($team['warna_tim']); ?>'; this.style.color='#fff';"
                                    onmouseout="this.style.transform='none'; this.style.backgroundColor=''; this.style.color=''">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-text"><?php echo e($team['nama_tim']); ?></h4>
                                            <div class="dropdown">
                                                <button class="btn btn-link p-0 rounded" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="background-color: white; width: 30px; height: 30px;">
                                                    <i class="bx bx-dots-vertical-rounded fs-4 text-dark"></i>
                                                </button>
                                                <ul class="dropdown-menu rounded-3">
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='fetchTeamToEdit(<?php echo e($team); ?>)'
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalUbahWarnaTim"><i
                                                                class='bx bxs-circle'
                                                                style="color: <?php echo e($team['warna_tim']); ?>"></i>
                                                            Warna</a></li>
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='fetchTeamToEdit(<?php echo e($team); ?>)'
                                                            data-bs-toggle="modal" data-bs-target="#modalEditTim"><i
                                                                class='bx bx-edit'></i>
                                                            Ubah</a></li>
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='teamArchive(<?php echo e($team['id']); ?>)'><i
                                                                class='bx bx-archive'></i>
                                                            Arsipkan</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text mt-2 small"><?php echo e($team['deskripsi']); ?></p>
                                    </div>
                                    <div class="card-footer rounded-bottom-4"
                                        style="height: 1px; background-color: <?php echo e($team['warna_tim']); ?>;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        

        
        <!--[if BLOCK]><![endif]--><?php if(count($teamProject) > 0): ?>
            <div class="row mt-4 ms-3">
                <div class="opacity-75">
                    <h3><i class='bx bx-spreadsheet'></i> Proyek</h3>
                    <div class="d-flex align-items-center">
                        <div class="border border-1 border-secondary w-75"></div>
                        <i data-bs-toggle="modal" data-bs-target="#modalTambahTim" class='bx bxs-plus-circle ms-0'
                            style="color: #0547d3; font-size: 3rem; cursor: pointer; transition: opacity 0.3s"
                            onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'"></i>
                    </div>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $teamProject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(empty($search) ||
                            str_contains(strtolower($team['nama_tim']), strtolower($search)) ||
                            str_contains(strtolower($team['deskripsi']), strtolower($search))): ?>
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <div class="card rounded-4 shadow-sm kartuTim"
                                    style="height: 13rem; transition: transform 0.3s, box-shadow 0.3s;"
                                    onclick="window.location.href='<?php echo e(route('tim.detail', ['id' => Crypt::encryptString($team['id'])])); ?>'"
                                    onmouseover="this.style.transform='translate(-5px, -5px)';  this.style.cursor='pointer'; this.style.backgroundColor='<?php echo e($team['warna_tim']); ?>'; this.style.color='#fff';"
                                    onmouseout="this.style.transform='none'; this.style.backgroundColor=''; this.style.color=''">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-text"><?php echo e($team['nama_tim']); ?></h4>
                                            <div class="dropdown">
                                                <button class="btn btn-link p-0 rounded" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="background-color: white; width: 30px; height: 30px;">
                                                    <i class="bx bx-dots-vertical-rounded fs-4 text-dark"></i>
                                                </button>
                                                <ul class="dropdown-menu rounded-3">
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='fetchTeamToEdit(<?php echo e($team); ?>)'
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalUbahWarnaTim"><i
                                                                class='bx bxs-circle'
                                                                style="color: <?php echo e($team['warna_tim']); ?>"></i>
                                                            Warna</a></li>
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='fetchTeamToEdit(<?php echo e($team); ?>)'
                                                            data-bs-toggle="modal" data-bs-target="#modalEditTim"><i
                                                                class='bx bx-edit'></i>
                                                            Ubah</a></li>
                                                    <li><a class="dropdown-item"
                                                            wire:click.prevent='teamArchive(<?php echo e($team['id']); ?>)'><i
                                                                class='bx bx-archive'></i>
                                                            Arsipkan</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text mt-2 small"><?php echo e($team['deskripsi']); ?></p>
                                    </div>
                                    <div class="card-footer rounded-bottom-4"
                                        style="height: 1px; background-color: <?php echo e($team['warna_tim']); ?>;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        


    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    
    <div class="modal fade" id="modalTambahTim" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Buat Tim
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storeTeam">
                        <div class="form-group mb-3">
                            <label for="namaTim">Nama Tim</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['namaTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="namaTim" wire:model='namaTim' placeholder="Div keu, Direksi, Tek ops"
                                style="transition: box-shadow 0.3s;"
                                onfocus="this.style.boxShadow='0 0 5px rgba(42, 48, 66, 0.5)'"
                                onblur="this.style.boxShadow='none'">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['namaTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="form-group mb-3">
                            <label for="deskripsiTim">Deskripsi</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['deskripsiTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="deskripsiTim" wire:model='deskripsiTim'
                                placeholder="Tim IT yang menangani permasalahan software dan hardware sekitar kantor"
                                style="transition: box-shadow 0.3s;"
                                onfocus="this.style.boxShadow='0 0 5px rgba(42, 48, 66, 0.5)'"
                                onblur="this.style.boxShadow='none'">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['deskripsiTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="form-group mb-3">
                            <label for="namaTim">Peruntukan Tim</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input <?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    type="radio" value="1" wire:model='kategoriTim' id="kantorPusat" />
                                <label class="form-check-label" for="kantorPusat">Kantor Pusat</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input <?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    type="radio" value="2" wire:model='kategoriTim' id="divisi" />
                                <label class="form-check-label" for="divisi">Divisi/Departemen Utama</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input <?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    type="radio" value="3" wire:model='kategoriTim' id="proyek" />
                                <label class="form-check-label" for="proyek">Proyek Multi Divisi</label>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                        wire:target="storeTeam">
                        <span wire:loading.remove wire:target="storeTeam">Simpan</span>
                        <span wire:loading wire:target="storeTeam">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditTim" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Ubah Tim
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateTeam">
                        <div class="form-group mb-3">
                            <label for="namaTim">Nama Tim</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['namaTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="namaTim" wire:model='namaTim' placeholder="Div keu, Direksi, Tek ops"
                                style="transition: box-shadow 0.3s;"
                                onfocus="this.style.boxShadow='0 0 5px rgba(42, 48, 66, 0.5)'"
                                onblur="this.style.boxShadow='none'">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['namaTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="form-group mb-3">
                            <label for="deskripsiTim">Deskripsi</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['deskripsiTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="deskripsiTim" wire:model='deskripsiTim'
                                placeholder="Tim IT yang menangani permasalahan software dan hardware sekitar kantor"
                                style="transition: box-shadow 0.3s;"
                                onfocus="this.style.boxShadow='0 0 5px rgba(42, 48, 66, 0.5)'"
                                onblur="this.style.boxShadow='none'">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['deskripsiTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="form-group mb-3">
                            <label for="namaTim">Peruntukan Tim</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input <?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    type="radio" value="1" wire:model='kategoriTim' id="kantorPusat" />
                                <label class="form-check-label" for="kantorPusat">Kantor Pusat</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input <?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    type="radio" value="2" wire:model='kategoriTim' id="divisi" />
                                <label class="form-check-label" for="divisi">Divisi/Departemen Utama</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input <?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    type="radio" value="3" wire:model='kategoriTim' id="proyek" />
                                <label class="form-check-label" for="proyek">Proyek Multi Divisi</label>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['kategoriTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                        wire:target="updateTeam">
                        <span wire:loading.remove wire:target="updateTeam">Simpan</span>
                        <span wire:loading wire:target="updateTeam">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalUbahWarnaTim" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Ubah Warna Tim Kamu!
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="changeTeamColor">
                        <label for="warnaTim" class="form-label">Warna Tim</label>
                        <input type="color" class="form-control <?php $__errorArgs = ['warnaTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> mb-4"
                            id="warnaTim" wire:model.live='warnaTim' style="height: 2rem">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['warnaTim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <i class="fw-bold"><?php echo e($warnaTim); ?></i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                        wire:target="changeTeamColor">
                        <span wire:loading.remove wire:target="changeTeamColor">Simpan</span>
                        <span wire:loading wire:target="changeTeamColor">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/tim.blade.php ENDPATH**/ ?>