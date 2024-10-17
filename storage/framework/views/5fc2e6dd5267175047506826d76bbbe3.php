<div class="btn-group">
    <!-- Tombol Edit -->
    <button class="btn btn-sm btn-primary" wire:click="edit(<?php echo e($row->id); ?>)">
        Edit
    </button>

    <!-- Tombol Delete -->
    <button class="btn btn-sm btn-danger" wire:click="delete(<?php echo e($row->id); ?>)">
        Delete
    </button>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/components/action-buttons.blade.php ENDPATH**/ ?>