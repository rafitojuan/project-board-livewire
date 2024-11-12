<div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('add-column', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1565212583-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('kanban', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1565212583-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <p>
        <span class="fw-bold">Keterangan:</span> <br>
        <span class="text-danger align-baseline" style="font-size: 24px;">●</span> = Projek yang melewati waktu akhir<br>
    </p>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views\livewire\kanban\index.blade.php ENDPATH**/ ?>