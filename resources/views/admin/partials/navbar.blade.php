<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <button class="navbar-toggler order-2 collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse order-1 collapse" id="navbarCollapse" style="">
        <form class="form-inline" action="{{ route('manager.set_carrier') }}" method="post">
            @csrf
            <div class="input-group mb-md-0 mb-2">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-search"></i></button>
                </div>
                <select name="atp" id="atp" class="form-control select2 select2-hidden-accessible"
                        style="width: 300px;" data-select2-id="1" tabindex="-1" aria-hidden="true" data-placeholder="Вкажіть перевізника">
                    @if($users && $users->count())
                        {{--<option  value="0">не вказано</option>--}}
                        @foreach($users as $key => $value)
                            @if(session('atpId') == $value)
                                <option value="{{ $value }}" selected>{{ $key }}</option>
                            @else
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endif

                        @endforeach
                    @else
                        <option selected="selected" value="0">вкажіть перевізника</option>
                    @endif
                    @if(\Request::route()->getName() === 'manager.index')
                            <input type="hidden" value="1" name="carrier">
                    @endif
                </select>
            </div>
        </form>

    </div>

    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fas fa-user" style="font-size: 26px;"></i>
                {{--<span class="badge badge-warning navbar-badge">15</span>--}}
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <span class="dropdown-header">{{ auth()->user()->name }}</span>
                <div class="dropdown-divider"></div>
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fas fa-envelope mr-2"></i> 4 new messages--}}
                    {{--<span class="float-right text-muted text-sm">3 mins</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fas fa-users mr-2"></i> 8 friend requests--}}
                    {{--<span class="float-right text-muted text-sm">12 hours</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fas fa-file mr-2"></i> 3 new reports--}}
                    {{--<span class="float-right text-muted text-sm">2 days</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
                <a href="{{ route('manager.logout') }}" class="dropdown-item dropdown-footer">Вихід</a>

            </div>
        </li>

    </ul>

    <!-- Right navbar links -->

</nav>
<!-- /.navbar -->