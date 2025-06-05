@php
use Illuminate\Support\Facades\Auth;
@endphp

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                {{ config('app.name', 'MIS Dashboard') }}
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

                {{-- Admin only --}}
                @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('departments.index') }}">
                        <p>Departments</p>
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
                @endif

                {{-- Admin, Risk Manager, Department Head --}}
                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'Risk Manager' || Auth::user()->role == 'Department Head'))
                
                <li class="nav-item">
                    <a href="{{ route('risks.index') }}">
                        <p>Risks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mitigations.index') }}">
                        <p>Mitigations</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('monitoring.index') }}">
                        <p>Monitoring</p>
                    </a>
                </li>
                @endif

                {{-- Staff --}}
                @if (Auth::check() && Auth::user()->role == 'Staff')
                <li class="nav-item">
                    <a href="{{ route('risks.index') }}">
                        <p>My Risks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mitigations.index') }}">
                        <p>Mitigations</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('monitoring.index') }}">
                        <p>Monitoring</p>
                    </a>
                </li>
                @endif

                {{-- Auditor --}}
                @if (Auth::check() && Auth::user()->role == 'Auditor')
                <li class="nav-item">
                    <a href="{{ route('risks.index') }}">
                        <p>View Risks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('monitoring.index') }}">
                        <p>Audit Logs</p>
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>