<div class="form-check form-check-lg">
    <input class="form-check-input form-check-input-lg" wire:model.live="selectUser" // Add .live to ensure real-time
        updates name="selectUser[]" // Use array notation type="checkbox" value="<?php echo e($row->id); ?>"
        aria-label="select user" style="width: 1.5em; height: 1.5em;" />
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/components/user-select.blade.php ENDPATH**/ ?>