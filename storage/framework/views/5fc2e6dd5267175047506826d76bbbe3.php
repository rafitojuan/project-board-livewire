<div class="btn-group">
    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSubtaskModal"
        wire:click="edit(<?php echo e($row->id); ?>)">
        <i class="bi bi-pencil-square"></i>
    </button>
    <button class="btn btn-sm btn-danger" wire:click="delete(<?php echo e($row->id); ?>)">
        <i class="bi bi-trash-fill"></i>
    </button>
</div>


<div class="modal fade" id="editSubtaskModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Update Jobdesk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit='updateSubtask'>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Masukkan nama"
                            wire:model='name' autofocus required>
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
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/components/action-buttons.blade.php ENDPATH**/ ?>