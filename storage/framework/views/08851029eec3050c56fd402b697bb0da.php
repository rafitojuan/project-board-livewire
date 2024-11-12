<div>
    <?php if($this->debugIsEnabled()): ?>
        <p><strong><?php echo app('translator')->get('livewire-tables::Debugging Values'); ?>:</strong></p>

        <?php if(! app()->runningInConsole()): ?>
            <div class="mb-4"><?php dump((new \Rappasoft\LaravelLivewireTables\DataTransferObjects\DebuggableData($this))->toArray()); ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\includes\debug.blade.php ENDPATH**/ ?>