<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                {{ config('app.name', 'Dashboard') }}
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <li class="nav-item active">
                    <a href="{{ route('admin.dashboard') }}">
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Components</h4>
                </li>


                <li class="nav-item">
                    <a href="{{ route('regions.index') }}">
                        <p>Regions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}">
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}">
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff.index') }}">
                        <p>Staff</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('risks.index') }}">
                        <p>Incidents</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('resources.index') }}">
                        <p>Resources</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('requests.index') }}">
                        <p>Resource Requests</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('allocations.index') }}">
                        <p>Resource Allocations</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('shipments.index') }}">
                        <p>Resource Shipments</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('beneficiaries.index') }}">
                        <p>Beneficiaries</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('distribution_points.index') }}">
                        <p>Distribution Points</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('distributions.index') }}">
                        <p>Distributions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}">
                        <p>Reports</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>