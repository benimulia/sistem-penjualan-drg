<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-10">
            <img src="{{ asset('assets/img/header/logo/landapp-logo.png') }}" style="max-height: 60px;" alt="">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ request()->is('home*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>


    @can('produk-list')
        <li class="nav-item {{ request()->is('produk*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('produk.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Produk</span>
            </a>
        </li>
    @endcan

    @can('pelanggan-list')
        <li class="nav-item {{ request()->is('pelanggan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pelanggan.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>
    @endcan

    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>

    @can('pembelian-list')
        <li class="nav-item {{ request()->is('pembelian*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pembelian.index') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Pembelian</span>
            </a>
        </li>
    @endcan

    @can('penjualan-create')
        <li class="nav-item {{ request()->is('penjualan/create*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penjualan.create') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>Buat Transaksi Baru</span>
            </a>
        </li>
    @endcan

    @can('penjualan-list')
        <li class="nav-item {{ request()->is('penjualan', 'penjualan/edit*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penjualan.index') }}">
                <i class="fas fa-fw fa-cash-register"></i>
                <span>Transaksi Jual</span>
            </a>
        </li>
    @endcan

    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        Bon
    </div>

    @can('rekapbon-list')
        <li class="nav-item {{ request()->is('rekapbon*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('rekapbon.index') }}">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Rekap Bon</span>
            </a>
        </li>
    @endcan

    {{-- @can(['role-list', 'user-list', 'cabang-list']) --}}
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item {{ request()->is('setting*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu Setting:</h6>
                @can('role-list')
                    <a class="collapse-item" href="{{ route('roles.index') }}">Kelola Role</a>
                @endcan
                @can('user-list')
                    <a class="collapse-item" href="{{ route('users.index') }}">Kelola Users</a>
                @endcan
                @can('cabang-list')
                    <a class="collapse-item" href="{{ route('cabang.index') }}">Cabang</a>
                @endcan

                <a class="collapse-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </div>
    </li>
    {{-- @endcan --}}
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
