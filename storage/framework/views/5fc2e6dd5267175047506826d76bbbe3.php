<div class="btn-group">
    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSubtaskModal"
        wire:click="edit(<?php echo e($row->id); ?>)">
        <i class="bi bi-pencil-square"></i>
    </button>
    <button class="btn btn-sm btn-danger" wire:click="delete(<?php echo e($row->id); ?>)">
        <i class="bi bi-trash-fill"></i>
    </button>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/components/action-buttons.blade.php ENDPATH**/ ?>