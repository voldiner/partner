@extends('layouts.layout')
@section('title', 'Налаштування')
@section('body_classes','hold-transition sidebar-mini')

@section('content')
    <!-- Site wrapper -->
    <div class="wrapper">
    @include('partials.navbar')

    @include('partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Налаштування</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Blank Page</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('partials.status_message')
                    <div class="row">
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                             src="../dist/img/user4-128x128.jpg" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">Nina Mcintire</h3>

                                    <p class="text-muted text-center">Software Engineer</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Followers</b> <a class="float-right">1,322</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Following</b> <a class="float-right">543</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Friends</b> <a class="float-right">13,287</a>
                                        </li>
                                    </ul>

                                    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- About Me Box -->

                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link @if($tab == 1) active @endif" href="#activity"
                                                                data-toggle="tab">Реквізити</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link @if($tab == 2) active @endif" href="#timeline"
                                                                data-toggle="tab">Змінити пароль</a></li>
                                        <li class="nav-item"><a class="nav-link @if($tab == 3) active @endif" href="#settings"
                                                                data-toggle="tab">Змінити Email</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane @if($tab == 1) active @endif" id="activity">
                                            <form class="form-horizontal" method="post" action="{{ route('users.update', $user->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="full_name">Повна назва</label>
                                                    <textarea
                                                            class="form-control @error('full_name') is-invalid @enderror"
                                                            id="full_name" name="full_name"
                                                            placeholder="Повна назва">{{ old('full_name',$user->full_name) }}</textarea>

                                                    @error('full_name')
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="short_name">Скорочена назва</label>
                                                    <input type="text" name="short_name"
                                                           class="form-control @error('short_name') is-invalid @enderror"
                                                           id="short_name" value="{{ old('short_name',$user->short_name) }}"
                                                           placeholder="Скорочена назва">
                                                    @error('short_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="edrpou">Код ЄДРПОУ</label>
                                                    <input type="text" name="edrpou"
                                                           class="form-control @error('edrpou') is-invalid @enderror"
                                                           id="edrpou" value="{{ old('edrpou', $user->edrpou) }}"
                                                           placeholder="Код ЄДРПОУ">
                                                    @error('edrpou')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="custom-control custom-checkbox mb-3 mt-2">
                                                    <input class="custom-control-input" name="is_pdv" type="checkbox" id="is_pdv"
                                                           value="checked"
                                                    @if ($errors->any())
                                                         !!! {{ old('is_pdv') ? 'checked' : '' }}
                                                    @else
                                                          {{ $user->pdv_checkbox }}
                                                    @endif
                                                    >
                                                    <label for="is_pdv" class="custom-control-label">Платник ПДВ</label>
                                                    @error('is_pdv')
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="certificate">Номер свідоцтва платника ПДВ</label>
                                                            <input type="text" name="certificate"
                                                                   class="form-control @error('certificate') is-invalid @enderror"
                                                                   id="certificate" value="{{ old('certificate', $user->certificate) }}"
                                                                   placeholder="Номер свідоцтва платника ПДВ" @if(!$user->is_pdv) disabled @endif>
                                                            @error('certificate')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="certificate_tax">Індивідуальний податковий номер</label>
                                                            <input type="text" name="certificate_tax"
                                                                   class="form-control @error('certificate') is-invalid @enderror"
                                                                   id="certificate_tax" value="{{ old('certificate_tax',$user->certificate_tax) }}"
                                                                   placeholder="Індивідуальний податковий номер" @if(!$user->is_pdv) disabled @endif>
                                                            @error('certificate_tax')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header">
                                                        <h5 class="card-title m-0">Для фізичної особи-підприємця</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="surname">Прізвище І П</label>
                                                                    <input type="text" name="surname"
                                                                           class="form-control @error('surname') is-invalid @enderror"
                                                                           id="surname" value="{{ old('surname',$user->surname) }}"
                                                                           placeholder="Прізвище І П">

                                                                    @error('surname')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="identifier">Ідентифікаційний код</label>
                                                                    <input type="text" name="identifier"
                                                                           class="form-control @error('identifier') is-invalid @enderror"
                                                                           id="identifier" value="{{ old('identifier', $user->identifier) }}"
                                                                           placeholder="Ідентифікаційний код">

                                                                    @error('identifier')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Адреса</label>
                                                    <textarea
                                                            class="form-control @error('address') is-invalid @enderror"
                                                            id="address" name="address"
                                                            placeholder="Повна назва">{{ old('address', $user->address) }}</textarea>

                                                    @error('address')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="insurer">Страховик</label>
                                                    <input type="text" name="insurer"
                                                           class="form-control @error('insurer') is-invalid @enderror"
                                                           id="insurer" value="{{ old('insurer', $user->insurer) }}"
                                                           placeholder="Страховик">

                                                    @error('insurer')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="num_contract">Номер договору</label>
                                                            <input type="text" name="num_contract"
                                                                   class="form-control @error('num_contract') is-invalid @enderror"
                                                                   id="num_contract" value="{{ $user->num_contract }}"
                                                                   placeholder="Інформація відсутня" disabled>

                                                            @error('num_contract')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="date_contract">Дата договору</label>
                                                            <input type="text" name="date_contract"
                                                                   class="form-control @error('date_contract') is-invalid @enderror"
                                                                   id="date_contract" value="{{ $user->date_contract }}" disabled
                                                                   placeholder="Інформація відсутня">
                                                            @error('date_contract')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="telephone">Телефон</label>
                                                            <input type="text" name="telephone"
                                                                   class="form-control @error('telephone') is-invalid @enderror"
                                                                   id="telephone" value="{{ old('telephone', $user->telephone) }}"
                                                                   placeholder="телефон">
                                                            @error('telephone')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="form-group">

                                                    <button type="submit" class="btn btn-danger">Зберегти зміни</button>

                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane @if($tab == 2) active @endif" id="timeline">
                                            <form class="form-horizontal" method="post" action="{{ route('changePassword') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="password" class="col-sm-3 col-form-label">Пароль</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                                               placeholder="Пароль">
                                                        @error('password')
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="new_password" class="col-sm-3 col-form-label">Новий пароль</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="new_password"
                                                               placeholder="Пароль">
                                                        @error('new_password')
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="new_password_confirmation"
                                                           class="col-sm-3 col-form-label">Новий пароль повторно</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="new_password_confirmation"
                                                               placeholder="Пароль">
                                                        @error('new_password_confirmation')
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-3 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">Змінити</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane @if($tab == 3) active @endif"  id="settings">
                                            <p> Ваша поточна адреса електронної пошти <b>{{ $user->email }}</b></p>
                                            <p>
                                                Після зміни адреси електронної пошти Вам необхідно буде авторизуватися та
                                                пройти процедуру її підтвердження
                                            </p>
                                            <form class="form-horizontal" method="post" action="{{ route('changeEmail') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="Email"
                                                           class="col-sm-2 col-form-label">Новий Email</label>
                                                    <div class="col-sm-6">
                                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                                                               placeholder="Email" value="{{ old('email') }}">

                                                        @error('email')
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="password"
                                                           class="col-sm-2 col-form-label">Пароль</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                                        @error('password')
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">Змінити</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        @include('partials.footer')
    </div>
    <!-- ./wrapper -->
@endsection

@section('my_script')
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('dist/js/url.min.js') }}"></script>
    <script>
        jQuery(function ($) {
            // ----- зміна параметрів url при зміні вкладок
            $('.nav-link').click(function () {
                var href = $(this).attr('href');
                if(href === '#activity') {
                    Url.updateSearchParam("tab", '1');
                }
                if(href === '#timeline') {
                    Url.updateSearchParam("tab", '2');
                }
                if(href === '#settings') {
                    Url.updateSearchParam("tab", '3');
                }
                //
                // if($(this).attr("href") == '#activity'){
                //         Url.updateSearchParam("tab", '1')
                //         $('#certificate').removeAttr('disabled');
                //         $('#certificate_tax').removeAttr('disabled')
                //     }else{
                //         $('#certificate').attr('disabled', 'disabled');
                //         $('#certificate_tax').attr('disabled', 'disabled');
                //     }
                 })

            // ---- платник ПДВ -----------
            // $('#is_pdv').click(function () {
            //     if($(this).is(":checked")){
            //         $('#certificate').removeAttr('disabled');
            //         $('#certificate_tax').removeAttr('disabled')
            //     }else{
            //         $('#certificate').attr('disabled', 'disabled');
            //         $('#certificate_tax').attr('disabled', 'disabled');
            //     }
            // })

            // ----- меню активне -------
            // $('.nav-link').click(function () {
            //    // if (){
            //         console.log($(this).parent().hasClass('has-treeview'));
            //    // }
            //     //$(this).addClass('active');
            // })


        })
    </script>
@endsection
