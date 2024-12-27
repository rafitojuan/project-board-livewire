<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu shadow-lg">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('root') }}" class="waves-effect">
                        <i class="bx bxs-dashboard"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title" key="t-menu">Menu Projek</li>

                <li>
                    <a href="{{ route('tim.index') }}" class="waves-effect">
                        <i class='bx bx-sitemap'></i>
                        <span key="t-dashboards">Tim</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('kanban.index') }}" class="waves-effect">
                        <i class="bx bx-chalkboard"></i>
                        <span key="t-dashboards">Projek</span>
                    </a>
                </li> --}}

                {{-- <li>
                    <a href="{{ route('tugas.index') }}" class="waves-effect">
                        <i class="bx bx-task"></i>
                        <span key="t-dashboards">Tugas</span>
                    </a>
                </li> --}}

                {{-- <li>
                    <a href="{{ route('kalendar.index') }}" class="waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span>Kalendarku</span>
                    </a>
                </li> --}}

                <li>
                    <a href="{{ route('logs') }}" class="waves-effect">
                        <i class="bx bx-history"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class='bx bx-group'></i>
                        <span>User Management</span>
                    </a>
                    <ul class="sub-menu navbar-collapse" aria-expanded="true">
                        <li><a href="{{ route('user.index') }}">User</a></li>
                        <li><a href="">Roles</a></li>
                        <li><a href="">Divisi</a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
