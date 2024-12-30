<div>
    <h4 class="mb-3">User Management</h4>
    <div class="card rounded-3">
        <div class="card-body">
            <h4 class="card-title">User Role Management Table</h4>
            <p class="card-text">Ini adalah tabel dari user-user</p>
            <button class="btn btn-primary btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="bx bx-plus-circle"></i>
                <span>Tambah Pengguna</span>
            </button>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('users-table', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-853190456-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    </div>

    
    <div class="modal fade" id="modalTambahUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Tambah Pengguna
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='closeModal' aria-label="Close"></button>
                </div>
                <form wire:submit="tambahPengguna">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="akun">Akun Pengguna</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="email" id="akun"
                                    class="form-control <?php $__errorArgs = ['akun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="contoh@gmail.com" wire:model="akun">
                            </div>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['akun'];
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click='closeModal' data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">Undang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    
    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Edit User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/user.blade.php ENDPATH**/ ?>