

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Colored_Header'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <body data-topbar="colored" data-layout="horizontal">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Layouts <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Colored Header <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <!-- dashboard init -->
    <script src="<?php echo e(URL::asset('build/js/pages/dashboard.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\epi-dasbor\resources\views\layouts-hori-colored-header.blade.php ENDPATH**/ ?>