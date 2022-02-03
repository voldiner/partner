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
                                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                                                data-toggle="tab">Реквізити</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline"
                                                                data-toggle="tab">Змінити Email</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#settings"
                                                                data-toggle="tab">Змінити пароль</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="activity">
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label for="full_name">Повна назва</label>
                                                    <textarea
                                                            class="form-control @error('surname') is-invalid @enderror"
                                                            id="full_name" name="full_name"
                                                            placeholder="Повна назва">{{ old('full_name') }}</textarea>

                                                    @error('full_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="short_name">Скорочена назва</label>
                                                    <input type="text" name="short_name"
                                                           class="form-control @error('short_name') is-invalid @enderror"
                                                           id="short_name" value="{{ old('short_name') }}"
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
                                                           id="edrpou" value="{{ old('edrpou') }}"
                                                           placeholder="Код ЄДРПОУ">
                                                    @error('edrpou')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="custom-control custom-checkbox mb-3 mt-2">
                                                    <input class="custom-control-input" name="is_pdv" type="checkbox" id="is_pdv" value="option1">
                                                    <label for="is_pdv" class="custom-control-label">Платник ПДВ</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="certificate">Номер свідоцтва платника ПДВ</label>
                                                    <input type="text" name="certificate"
                                                           class="form-control @error('certificate') is-invalid @enderror"
                                                           id="certificate" value="{{ old('certificate') }}"
                                                           placeholder="Номер свідоцтва платника ПДВ">
                                                    @error('certificate')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="certificate_tax">Індивідуальний податковий номер</label>
                                                    <input type="text" name="certificate_tax"
                                                           class="form-control @error('certificate') is-invalid @enderror"
                                                           id="certificate_tax" value="{{ old('certificate_tax') }}"
                                                           placeholder="Індивідуальний податковий номер">
                                                    @error('certificate_tax')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
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
                                                                           id="surname" value="{{ old('surname') }}"
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
                                                                           id="identifier" value="{{ old('identifier') }}"
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
                                                            placeholder="Повна назва">{{ old('address') }}</textarea>

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
                                                           id="insurer" value="{{ old('insurer') }}"
                                                           placeholder="Страховик">

                                                    @error('insurer')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="num_contract">Номер договору</label>
                                                            <input type="text" name="num_contract"
                                                                   class="form-control @error('num_contract') is-invalid @enderror"
                                                                   id="num_contract" value="{{ old('num_contract') }}"
                                                                   placeholder="Інформація відсутня" disabled>

                                                            @error('num_contract')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date_contract">Дата договору</label>
                                                            <input type="text" name="date_contract"
                                                                   class="form-control @error('date_contract') is-invalid @enderror"
                                                                   id="date_contract" value="{{ old('date_contract') }}" disabled
                                                                   placeholder="Інформація відсутня">

                                                            @error('date_contract')
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
                                        <div class="tab-pane" id="timeline">
                                            <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm"
                                                         src="../dist/img/user1-128x128.jpg" alt="user image">
                                                    <span class="username">
                                                     <a href="#">Jonathan Burke Jr.</a>
                                                       <a href="#" class="float-right btn-tool"><i
                                                                   class="fas fa-times"></i></a>
                                                </span>
                                                    <span class="description">Shared publicly - 7:30 PM today</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                    Lorem ipsum represents a long-held tradition for designers,
                                                    typographers and the like. Some people hate it and argue for
                                                    its demise, but others ignore the hate as they create awesome
                                                    tools to help create filler text for everyone from bacon lovers
                                                    to Charlie Sheen fans.
                                                </p>

                                                <p>
                                                    <a href="#" class="link-black text-sm mr-2"><i
                                                                class="fas fa-share mr-1"></i> Share</a>
                                                    <a href="#" class="link-black text-sm"><i
                                                                class="far fa-thumbs-up mr-1"></i> Like</a>
                                                    <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                                                </p>

                                                <input class="form-control form-control-sm" type="text"
                                                       placeholder="Type a comment">
                                            </div>
                                            <!-- /.post -->

                                            <!-- Post -->
                                            <div class="post clearfix">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm"
                                                         src="../dist/img/user7-128x128.jpg" alt="User Image">
                                                    <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                                    <span class="description">Sent you a message - 3 days ago</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                    Lorem ipsum represents a long-held tradition for designers,
                                                    typographers and the like. Some people hate it and argue for
                                                    its demise, but others ignore the hate as they create awesome
                                                    tools to help create filler text for everyone from bacon lovers
                                                    to Charlie Sheen fans.
                                                </p>

                                                <form class="form-horizontal">
                                                    <div class="input-group input-group-sm mb-0">
                                                        <input class="form-control form-control-sm"
                                                               placeholder="Response">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-danger">Send</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.post -->

                                            <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm"
                                                         src="../dist/img/user6-128x128.jpg" alt="User Image">
                                                    <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                                    <span class="description">Posted 5 photos - 5 days ago</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <div class="row mb-3">
                                                    <div class="col-sm-6">
                                                        <img class="img-fluid" src="../dist/img/photo1.png" alt="Photo">
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col-sm-6">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <img class="img-fluid mb-3" src="../dist/img/photo2.png"
                                                                     alt="Photo">
                                                                <img class="img-fluid" src="../dist/img/photo3.jpg"
                                                                     alt="Photo">
                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-sm-6">
                                                                <img class="img-fluid mb-3" src="../dist/img/photo4.jpg"
                                                                     alt="Photo">
                                                                <img class="img-fluid" src="../dist/img/photo1.png"
                                                                     alt="Photo">
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- /.row -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->

                                                <p>
                                                    <a href="#" class="link-black text-sm mr-2"><i
                                                                class="fas fa-share mr-1"></i> Share</a>
                                                    <a href="#" class="link-black text-sm"><i
                                                                class="far fa-thumbs-up mr-1"></i> Like</a>
                                                    <span class="float-right">
                                                         <a href="#" class="link-black text-sm">
                                                                  <i class="far fa-comments mr-1"></i> Comments (5)
                                                         </a>
                                                    </span>
                                                </p>

                                                <input class="form-control form-control-sm" type="text"
                                                       placeholder="Type a comment">
                                            </div>
                                            <!-- /.post -->
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="settings">
                                            <form class="form-horizontal">
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="inputName"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail"
                                                           class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="inputEmail"
                                                               placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputName2"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputExperience"
                                                           class="col-sm-2 col-form-label">Experience</label>
                                                    <div class="col-sm-10">
                                                    <textarea class="form-control" id="inputExperience"
                                                              placeholder="Experience"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputSkills"
                                                           class="col-sm-2 col-form-label">Skills</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputSkills"
                                                               placeholder="Skills">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"> I agree to the <a href="#">terms
                                                                    and
                                                                    conditions</a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">Submit</button>
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
@endsection
