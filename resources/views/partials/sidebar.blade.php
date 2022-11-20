<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-10">
            <img src="{{asset('assets/img/header/logo/landapp-logo.png')}}" style="max-height: 60px;" alt="">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @can('cabang-list')
    <li class="nav-item {{ (request()->is('cabang*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('cabang.index') }}">
            <i class="fas fa-fw fa-code-branch"></i>
            <span>Cabang</span>
        </a>
    </li>
    @endcan

    @can('produk-list')
    <li class="nav-item {{ (request()->is('produk*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('produk.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Produk</span>
        </a>
    </li>
    @endcan

    @can('pelanggan-list')
    <li class="nav-item {{ (request()->is('pelanggan*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pelanggan.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pelanggan</span>
        </a>
    </li>
    @endcan

    @can(['role-list','user-list'])
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Setting Menu:</h6>

                <a class="collapse-item" href="{{ route('roles.index') }}">Manage Role</a>

                <a class="collapse-item" href="{{ route('users.index') }}">Manage Users</a>
            </div>
        </div>
    </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->