<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>

                <li>
                    <a href="<?php echo e(route('kanban.index')); ?>" class="waves-effect">
                        <i class="bx bx-chalkboard"></i>
                        <span key="t-dashboards"> Project</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>