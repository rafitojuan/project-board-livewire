<div class="container">
    <span class="fw-semibold"><?php echo e($row->name); ?></span>
    <!--[if BLOCK]><![endif]--><?php if($row->url): ?>
        <a href="<?php echo e($row->url ?? ''); ?>"><i class="bi bi-link-45deg" title="URL"></i> </a><br>
    <?php else: ?>
        <br>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <span>PIC: <?php echo e($row->pelaksana); ?></span> <br>
    <small class="text-muted">Cttn: <?php echo e($row->keterangan ? $row->keterangan : '-'); ?></small>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/components/name-field.blade.php ENDPATH**/ ?>