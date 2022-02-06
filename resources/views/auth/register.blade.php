@extends('layouts.layout')
@section('title', 'Регістрація')
@section('body_classes','hold-transition register-page')
@section('content')
@include('partials.status_message')

<div class="register-box">
    <div class="register-logo">
        <a href="{{ route('welcome') }}"><b>{{ env('APP_NAME') }}</b></a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Реєстрація нового користувача</p>

            <form action="{{ route('register') }}" method="post">
                {{--@dump($errors)--}}
                @csrf
                <div class="form-group">
                    <label for="password_fxp">Реєстраційний ключ</label>
                    <input type="text" id="password_fxp" name="password_fxp" class="form-control @error('password_fxp') is-invalid @enderror" value="{{ old('password_fxp') }}" placeholder="Реєстраційний ключ">
                    @error('password_fxp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
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
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль">
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
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Повторно пароль">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <div class="icheck-primary mb-3">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                Я погоджуюсь з <a href="#">правилами використання</a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block">Реєстрація</button>
                    </div>
                    <!-- /.col -->
                </div>
                @error('terms')
                <div class="alert alert-danger mt-2">
                    Необхідно встановити відмітку про згоду
                </div>
                @enderror
            </form>

            <p class="mt-3">
                <a href="{{ route('login') }}" class="text-center">Я вже зареєстрований</a>
            </p>

        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->
@endsection
