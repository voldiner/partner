<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }
        .footer-widget {
            height: 100%;
            width: 100%;
        }
    </style>
    <title>Привет, мир!</title>
</head>
<body>
<div class="container-fluid" style="padding-left: 0px; padding-right: 0px">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('dist/img/logo.png') }}" width="35" height="35" class="d-inline-block align-top bg-white rounded-circle ml-3 mr-3" alt="">
                    <span style="letter-spacing: 3px;"><b>PARTNER</b></span>

                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Про серіс</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Допомога</a>
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
            <p><a href="#" class="btn btn-primary btn-lg" tabindex="-1" role="button">Про сервіс</a> </p>
        </div>
    </div>
    <div class="row equal" style="background-color: #f3f6f8">
        <div class="col-md-6" >
            <div class="callout callout-info m-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="{{ asset('dist/img/24-7.png') }}" class="img-fluid"  alt="logo">
                    </div>
                    <div class="col-10">
                        <p>Доступ до документів 24/7</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" >
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


</div>



<!-- Вариант 1: пакет jQuery и Bootstrap (включает Popper) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
