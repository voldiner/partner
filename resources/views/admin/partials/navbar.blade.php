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

        <form class="form-inline">
            <div class="input-group mb-md-0 mb-2">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-search"></i></button>
                </div>
                <select name="ac-name" id="mega" class="form-control select2 select2-hidden-accessible"
                        style="width: 300px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option selected="selected" data-select2-id="3">Alabama</option>
                    <option data-select2-id="31">Alaska</option>
                    <option data-select2-id="32">California</option>
                    <option data-select2-id="33">Delaware</option>
                    <option data-select2-id="34">Tennessee</option>
                    <option data-select2-id="35">Texas</option>
                    <option data-select2-id="36">Washington</option>
                </select>
            </div>
        </form>
        <ul class="navbar-nav ml-auto ">
            <li class="nav-item ">
                <a class="btn btn-default btn-flat" href="{{ route('manager.logout') }}">Вихід</a>
            </li>
        </ul>

    </div>

    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <span class="dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>

    </ul>

    <!-- Right navbar links -->

</nav>
<!-- /.navbar -->