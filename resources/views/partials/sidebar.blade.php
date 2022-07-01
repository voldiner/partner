<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
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
                    <a href="#" class="d-block">{{ auth()->user()->short_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                {{--<li class="nav-header">EXAMPLES</li>--}}
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link @if(Route::currentRouteName()== 'home') active @endif">
                        <i class="nav-icon fas fa-house-user"></i>
                        <p>
                            Домашня
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.edit', ['tab' => 1]) }}" class="nav-link @if(Route::currentRouteName()== 'users.edit') active @endif">
                        <i class="nav-icon far fa-address-card"></i>
                        <p>
                            Налаштування
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}" class="nav-link @if(Route::currentRouteName()== 'reports.index') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Відомості
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('invoices.index') }}" class="nav-link @if(Route::currentRouteName()== 'invoices.index') active @endif">
                        <i class="nav-icon fas fa-people-arrows"></i>
                        <p>
                            Акти виконаних робіт
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('places.index') }}" class="nav-link @if(Route::currentRouteName()== 'places.index') active @endif">
                        <i class="nav-icon fas fa-bus"></i>
                        <p>
                            Квитки
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('chat') }}" class="nav-link @if(Route::currentRouteName()== 'chat') active @endif">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Чат
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>