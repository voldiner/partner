<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        .nomer {
            background-color: #fff200;
            font-size: 150%;
            border-radius: 40px;
        }

        #video12 {
            position: relative;
            margin-bottom: 110px;
            padding-bottom: 75%;
        }

        #video12 iframe {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        #video12 div {
            position: absolute;
            bottom: -110px;
            width: 100%;
            height: 100px;
            padding: 0;
            overflow-x: auto;
            white-space: nowrap;
            text-align: center;
        }

        #video12 img {
            height: calc(100% - (5px + 1px) * 2 - 10px);
            margin: 0 5px 0 0;
            padding: 5px;
            border: 1px solid #555;
            border-radius: 5px;
            opacity: .7;
        }

        #video12 img:hover {
            opacity: 1;
            cursor: pointer;
        }

        #video12 img:focus {
            opacity: .2;
        }
        .footer a{
        text-decoration: none;
        color: #fff;
        }
        .footer a:hover {
            text-decoration: none; color: #fff200;
        }
        .footer b{
            font-family: 'Roboto', sans-serif;
            font-weight: normal;
            font-size: 85%;
        }

    </style>
    <title>Привет, мир!</title>
</head>
<body>
<div class="container-fluid" style="padding-left: 0px; padding-right: 0px">
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
                    <a class="nav-link" href="#about">Про серіс</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#help">Допомога</a>
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

    <div class="row">
        <div class="col-md-3 d-none d-md-block" style="padding: 3rem ;background-color: #f7e236;">
            <img src="{{ asset('dist/img/logostart.png') }}" class="img-fluid" alt="logo">
        </div>
        <div class="col-md-9 text-center pt-2 pt-md-5" style="background-color: #f7e236">
            <h1 class="mt-2 mt-md-5 font-weight-bold" style="color: #333;">Електронний кабінет перевізника</h1>
            <p class="mt-4" style="font-size: 120%;">ПрАТ "Волинське обласне підприємство автобусних станцій"</p>
            <p><a href="#about" class="btn btn-primary btn-lg" tabindex="-1" role="button">Про сервіс</a></p>
        </div>
    </div>
    <div class="row" style="background-color: #f3f6f8">
        <div class="col-md-6">
            <div class="callout callout-info m-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="{{ asset('dist/img/24-7.png') }}" class="img-fluid" alt="logo">
                    </div>
                    <div class="col-10">
                        <p>Доступ до документів 24/7</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-info m-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="{{ asset('dist/img/smart.png') }}" class="img-fluid" alt="logo">
                    </div>
                    <div class="col-10">
                        <p>Можливість працювати з будь-якого пристрою</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pb-4" style="background-color: #f3f6f8">
        <div class="col-md-6">
            <div class="callout callout-info m-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="{{ asset('dist/img/seek.png') }}" class="img-fluid" alt="logo">
                    </div>
                    <div class="col-10">
                        <p>Швідкий пошук документів</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-info m-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="{{ asset('dist/img/dollar.png') }}" class="img-fluid" alt="logo">
                    </div>
                    <div class="col-10">
                        <p>Безкоштовний</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




    {{-- початок роботи з сервісом--}}

    <div class="row">
        <div class="col text-center">
            <h2 class="mt-3 mb-3" style="font-size: 200%"><strong>Робота з сервісом</strong></h2>
            <p class="mb-5"><strong>4 простих кроки для початку</strong></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 offset-lg-2 p-2 mb-3 mt-3">
            <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="pb-3 pt-3 pl-4 pr-4 text-center m-3 nomer">1</span>
                </div>
                <div class="col-9">
                    Отримайте тимчасовий пароль для реєстрації в ПрАТ "ВОПАС"
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-2 mb-3 mt-3">
            <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="pb-3 pt-3 pl-4 pr-4 text-center m-3 nomer">2</span>
                </div>
                <div class="col-9">
                    Зареєструйтеся на сервісі "Partner"
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 offset-lg-2 p-2 mb-3 mt-3">
            <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="pb-3 pt-3 pl-4 pr-4 text-center m-3 nomer">3</span>
                </div>
                <div class="col-9">
                    Підтвердіть адресу електронної пошти
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-2 mb-3 mt-3">
            <div class="row align-items-center">
                <div class="col-3 text-center">
                    <span class="pb-3 pt-3 pl-4 pr-4 text-center m-3 nomer">4</span>
                </div>
                <div class="col-9">
                    Зайдіть на сторінку НАЛАШТУВАННЯ та звірте ваші реквізити
                </div>
            </div>
        </div>
    </div>
    {{-- додаткова інформація--}}
    <div class="row pt-5 pb-5" style="background-color: #f3f6f8">
        <div class="col-lg-4 p-5 offset-lg-1 shadow-sm mb-5" style="background-color: #ffffff; border-radius: 10px">
            <h3 class="text-center"><strong>Для кого створений сервіс PARTNER</strong></h3>
            Якщо ви:
            <ul>
                <li>здійснюєте регулярні пасажирські перевезення автомобільним транспортом</li>
                <li>ваші автобуси курсують від автостанцій Волинської області, що належать ПрАТ "ВОПАС"</li>
                <li>на ваші автобуси здійснюється продаж квитків на цих автостанціях</li>
                <li>у вас укладена угода про надання послуг з ПрАТ "ВОПАС"</li>
            </ul>
            В такому разі сервіс PARTNER для вас.

        </div>
        <div class="col-lg-4 p-5 offset-lg-2 shadow-sm mb-5" style="background-color: #ffffff; border-radius: 10px">
            <a name="about"></a>
            <h3 class="text-center"><strong> Про сервіс PARTNER</strong></h3>
            Електронний кабінет перевізника надає доступ зареєстрованим користувачам до наступних документів:
            <ul>
                <li>Акти виконаних робіт</li>
                <li>Відомості проданих квитків на автостанціях ПрАТ "ВОПАС"</li>
            </ul>
            Сервіс дає можливість пошуку необхідних документів та їх роздруку.
            Долучайтеся до сервісу "Електронний кабінет перевізника"!
        </div>
    </div>
    {{-- відеоролики --}}
    <div class="row">
        <div class="col text-center">
            <h2 class="mt-3 mb-3" style="font-size: 200%"><strong>Довідка</strong></h2>
            <p class="mb-5"><strong>Як працювати з сервісом</strong></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3 pb-4">
            <a name="help"></a>
            <div id="video12">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/6F2Pd1RdPPs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <div>
                    <img src="http://img.youtube.com/vi/6F2Pd1RdPPs/0.jpg"
                         data-src="https://www.youtube.com/embed/6F2Pd1RdPPs"/>
                    <img src="http://img.youtube.com/vi/tkyBM-LIc5U/0.jpg"
                         data-src="https://www.youtube.com/embed/tkyBM-LIc5U"/>
                    <img src="http://img.youtube.com/vi/wS7fYSiPb5E/0.jpg"
                         data-src="https://www.youtube.com/embed/wS7fYSiPb5E"/>

                </div>
            </div>
        </div>
    </div>
    {{-- footer--}}
    <div class="row footer" style="background-color: #007bff; color: #fff; font-size: 90%">
        <div class="col-md-5 offset-md-1 p-4">
            <p class="mb-2">
                Приватне акціонерне товариство "Волинське обласне підприємство автобусних станцій"
            </p>
            <p class="mb-2">
                43018 Волинська область, м.Луцьк, вул. Львівська, 148
            </p>
        </div>
        <div class="col-md-5 p-4">
            <p class="mb-2">Є питання? Зв'яжіться з нами за телефоном чи e-mail</p>
            <p class="mb-2">Відділ перевізень: <i class="fas fa-lg fa-phone"></i> +38 050 403 53 56 <i class="fas fa-lg fa-envelope"><b>&nbsp;vpim1@ukr.net</b></i></p>
            <p class="mb-2">Бухгалтерія: <i class="fas fa-lg fa-phone"></i> 0332 26 37 10 <i class="fas fa-lg fa-envelope"><b>&nbsp;vatvopas@ukr.net</b></i></p>
            <p class="mb-2">Приймальня: 03322 </p>
            <p class="mb-2">Тех.підтримка: <i class="fas fa-lg fa-phone"></i> +38 099 111 11 11 <i class="fas fa-lg fa-envelope"><b>&nbsp;info@vopas.com.ua</b></i> </p>
            <p class="mb-2"><small>пн-пт з 08:30 - 17:30</small></p>
            <p><a href="#help">Допомога</a></p>
        </div>
    </div>
</div>


<!-- Вариант 1: пакет jQuery и Bootstrap (включает Popper) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
<script>

    var IMG = document.querySelectorAll('#video12 img'),
    IFRAME = document.querySelector('#video12 iframe');
    for (var i = 0; i < IMG.length; i++) {
        IMG[i].onclick = function () {
            let dataSrc = this.dataset.src;
            IFRAME.src = dataSrc;
            this.style.backgroundColor = '#555';
        }
    }
</script>

</body>
</html>
