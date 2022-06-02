<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="{{ route('welcome') }}">
        <img src="{{ asset('dist/img/logo.png') }}" width="35" height="35"
             class="d-inline-block align-top bg-white rounded-circle ml-3 mr-3" alt="">
        <span style="letter-spacing: 3px;"><b>PARTNER</b></span>

    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('welcome') }}#about">Про серіс</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('welcome') }}#help">Допомога</a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/home') }}">Кабінет</a>
                </li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Вихід</button>
                </form>
            @else
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Вхід</a>
                    </li>
                @endif
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Реєстрація</a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>