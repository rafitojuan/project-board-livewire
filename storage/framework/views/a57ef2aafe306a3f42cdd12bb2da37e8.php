<div class="container d-flex float-start">
    <div class="">
        <img src="<?php echo e(asset($row->avatar)); ?>" alt="Profile Photo" class="rounded-circle" style="width: 40px; height: 40px;">
    </div>
    <div class="ms-2">
        <p class="mb-0 fw-bold"><?php echo e($row->name); ?></p>
        <small class="text-muted"><?php echo e($row->{'role.name'}); ?></small>
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/components/user-field.blade.php ENDPATH**/ ?>