<div>
    <h4 class="mb-3">Project Board</h4>
    <button class="btn btn-primary mb-3 text-end" wire:click="openColumnModal()">+ Add Column</button>

    <div class="modal fade modalColumn" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Project Column
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addColumn()'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kolom</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['columnName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="name" placeholder="Masukkan nama kolom" wire:model.blur='columnName' autofocus
                                required>
                            <small class="text-danger ">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['columnName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    *<?php echo e($message); ?>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </small>
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
    </div></div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/add-column.blade.php ENDPATH**/ ?>