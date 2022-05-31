<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('welcome') }}" class="brand-link">
        <img src="{{ asset('dist/img/logo.png') }}"
             alt="PARTNER"
             class="brand-image-xl ml-3 mr-2 bg-white img-circle"
        >
        <span class="brand-text"><b>PARTNER</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{--<div class="image">--}}
                {{--<img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">--}}
            {{--</div>--}}
            <div class="info" style="white-space: normal">
                    <a href="#" class="d-block">@if(session()->has('atpName')) {{ session('atpName') }} @endif</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('manager.index') }}" class="nav-link @if(Route::currentRouteName()== 'manager.index') active @endif">
                        <i class="nav-icon far fa-address-card"></i>
                        <p>
                            Перевізники
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manager.reports.index') }}" class="nav-link @if(Route::currentRouteName()== 'manager.reports.index') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Відомості
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manager.invoices.index') }}" class="nav-link @if(Route::currentRouteName()== 'manager.invoices.index') active @endif">
                        <i class="nav-icon fas fa-people-arrows"></i>
                        <p>
                            Акти виконаних робіт
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                @if(auth()->user()->id === 3)
                    <li class="nav-item">
                        <a href="{{ route('manager.logs') }}" class="nav-link @if(Route::currentRouteName()== 'manager.logs') active @endif">
                            <i class="nav-icon fas fa-file-archive"></i>
                            <p>
                                Перегляд логів
                                {{--<span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>