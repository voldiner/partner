@extends('layouts.layout')
@section('title', 'Авторизація')
@section('body_classes','hold-transition login-page')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('welcome') }}"><b>{{ env('APP_NAME') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Увійти до системи</p>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="icheck-primary mb-3">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">
                                Запам'ятати мене
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-block">Вхід</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3">
                <a href="{{ route('password.request') }}">Забув пароль?</a>
            </p>
            <p class="mb-2">
                <a href="{{ route('register') }}" class="text-center">Реєстрація</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>

<!-- /.login-box -->
@endsection

