@extends('layouts.layout')
@section('title', 'Підтвердження email')
@section('body_classes','hold-transition login-page')
@section('content')

@if ($errors->any())
    <div class="alert alert-info">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status') == 'verification-link-sent')
    <div class="alert alert-info">
        <p> Вам відправлене посилання для підтвердження адреси електронної пошти!</p>
        <p><b>{{ auth()->user()->email }}</b></p>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-sm-8">

        <div class="login-box" style="width: 100%;">
            <div class="login-logo">
                <a href="{{ route('welcome') }}"><b>{{ env('APP_NAME') }}</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">
                        Увага! Для продовження роботи необхідно підтвердити Ваш Email <b>{{ auth()->user()->email }}</b>. Перейдіть по
                        посиланню, яке знаходиться в листі направленому на Вашу пошту.
                    </p>

                    <form action="{{ route('logout') }}" method="post" style="display: inline;">
                        @csrf
                        Якщо лист не знайшовся, то спробуйте пошукати в папці 'Спам' Вашого поштового клієнту, або послати
                        його повторно з цієї сторінки. Якщо Ваш Email введений помилково, його можна виправити
                        через повторну реєстрацію. Для цього натисніть
                        <button type="submit" class="btn btn-link" style="padding: 0px 0px 5px 0px">Вихід</button>
                    </form>
                    <form action="{{ route('verification.send') }}" method="post">
                        @csrf

                        <div class="row justify-content-center">
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-block">Відіслати</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->



    </div>
</div>


@endsection