<nav class="sidebar">
    <div class="sidebar-header">
        <a style="font-size:20px;" href="{{ route('dashboard') }}" class="sidebar-brand">
            Software<span style="font-size:18px;"> Inventory</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Projects</li>
            {{-- @if (auth()->user()->hasPermissionTo(1))
                <li class="nav-item {{ request()->is('samples') || request()->is('samples/*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('samples.index') }}">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Sample</span>
                    </a>
                </li>
            @endif --}}

            @if (auth()->user()->hasPermissionTo(4))
                <li class="nav-item {{ request()->is('projects') || request()->is('projects/*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('projects.index') }}">
                        <i class="link-icon" data-feather="slack"></i>
                        <span class="link-title">Projects</span>
                    </a>
                </li>

                <li
                    class="nav-item {{ request()->is('developers_profile') || request()->is('developers_profile/*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('developers_profile.index') }}">
                        <i class="link-icon" data-feather="bookmark"></i>
                        <span class="link-title">Developers Profile</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasPermissionTo(5))
                <li
                    class="nav-item {{ request()->is('my_project') || request()->is('my_project/*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('my_project.index') }}">
                        <i class="link-icon" data-feather="aperture"></i>
                        <span class="link-title">My Projects</span>
                    </a>
                </li>

                {{-- <li class="nav-item {{ request()->is('create') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('projects.create') }}">
                        <i class="link-icon" data-feather="plus-square"></i>
                        <span class="link-title">Project Entry</span>
                    </a>
                </li> --}}
            @endif


            @if (auth()->user()->hasPermissionTo(3))
                <li class="nav-item nav-category">Settings</li>
                <li
                    class="nav-item {{ request()->is('usermanager') || request()->is('usermanager/*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('usermanager.index') }}">
                        <i class="link-icon" data-feather="settings"></i>
                        <span class="link-title">User Manager</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasPermissionTo(2))
                <li
                    class="nav-item {{ request()->is('permissions') || request()->is('permissions/*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('permissions.index') }}">
                        <i class="link-icon" data-feather="settings"></i>
                        <span class="link-title">Permissions</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</nav>
