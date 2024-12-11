<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu shadow-lg">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="<?php echo e(route('root')); ?>" class="waves-effect">
                        <i class="bx bxs-dashboard"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title" key="t-menu">Menu Projek</li>

                <li>
                    <a href="<?php echo e(route('kanban.index')); ?>" class="waves-effect">
                        <i class="bx bx-chalkboard"></i>
                        <span key="t-dashboards"> Projek</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('tugas.index')); ?>" class="waves-effect">
                        <i class="bx bx-task"></i>
                        <span key="t-dashboards">Tugas</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('kalendar.index')); ?>" class="waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span>Kalendarku</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('logs')); ?>" class="waves-effect">
                        <i class="bx bx-history"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </li>

                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>