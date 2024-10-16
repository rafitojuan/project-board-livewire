<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <title><?php echo e($title ?? 'Page Title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard EPI" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/favicon.ico')); ?>">
    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<?php $__env->startSection('body'); ?>

    <body data-sidebar="dark" data-layout-mode="light">
    <?php echo $__env->yieldSection(); ?>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo e($slot); ?>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <?php echo $__env->make('layouts.right-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /Right-bar -->

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($component)) { $__componentOriginal8344cca362e924d63cb0780eb5ae3ae6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8344cca362e924d63cb0780eb5ae3ae6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'livewire-alert::components.scripts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('livewire-alert::scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8344cca362e924d63cb0780eb5ae3ae6)): ?>
<?php $attributes = $__attributesOriginal8344cca362e924d63cb0780eb5ae3ae6; ?>
<?php unset($__attributesOriginal8344cca362e924d63cb0780eb5ae3ae6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8344cca362e924d63cb0780eb5ae3ae6)): ?>
<?php $component = $__componentOriginal8344cca362e924d63cb0780eb5ae3ae6; ?>
<?php unset($__componentOriginal8344cca362e924d63cb0780eb5ae3ae6); ?>
<?php endif; ?>
    <!-- JAVASCRIPT -->
</body>

</html>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>