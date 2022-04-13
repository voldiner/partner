@extends('admin.layouts.layout')
@section('title', 'Кабінет менеджера')
@section('body_classes','hold-transition sidebar-mini')
@section('my_styles')
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <style>

    </style>
@endsection

@section('content')
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('partials.status_message')
        @include('admin.partials.navbar')

        @include('admin.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Перевізники</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Blank Page</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @include('partials.status_message')
                    @include('partials.validation_messages')
                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="info-box bg-info mb-2" style="height: 100%">
                                <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <p class="mb-0">Акти виконаних робіт за:</p>
                                    <span class="info-box-number">
                                        @if(isset($statistic['dateLastInvoice'])) {{ $statistic['dateLastInvoice']['month'] }} {{ $statistic['dateLastInvoice']['year'] }} @else Не визначено @endif
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="info-box bg-danger mb-2" style="height: 100%">
                                <span class="info-box-icon"><i class="fas fa-clipboard-check"></i></span>
                                <div class="info-box-content">
                                    <p class="mb-0">Зареєструвалося</p>
                                    <span class="info-box-number"> {{ $statistic['registeredUsers']['count'] }} </span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{  number_format($statistic['registeredUsers']['percent'], 0, '.', '') }}%"></div>
                                    </div>
                                    <span class="progress-description">{{ number_format($statistic['registeredUsers']['percent'], 0, '.', '') }}% всіх перевізників</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        {{--<div class="clearfix hidden-md-up"></div>--}}

                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="info-box bg-gradient-maroon mb-2" style="height: 100%">
                                <span class="info-box-icon"><i class="fas fa-envelope-open"></i></span>
                                <div class="info-box-content">
                                    <p class="mb-0">Підтверджено email</p>
                                    <span class="info-box-number"> {{ $statistic['confirmEmailUsers']['count'] }} </span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{  number_format($statistic['confirmEmailUsers']['percent'] , 0, '.', '') }}%"></div>
                                    </div>
                                    <span class="progress-description">{{number_format($statistic['confirmEmailUsers']['percent'], 0, '.', '') }}% всіх перевізників</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="info-box bg-success mb-2" style="height: 100%">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <p class="mb-0">Всього перевізників</p>
                                    <span class="info-box-number"> {{ $statistic['allUsers'] }} </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-gray">
                                <div class="card-header">
                                    <h3 class="card-title">Знайти перевізника</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                    class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="display: block;">
                                    <form action="{{ route('manager.index') }}" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Критерій пошуку</label>
                                                    <select class="form-control" name="parameter" id="parameter">
                                                        @if(!$paramSelected)
                                                            <option value="0" selected>Виберіть критерій пошуку</option>
                                                        @endif
                                                            @foreach($parametersForSelect as $key => $value)
                                                                @if($key === $paramSelected)
                                                                    <option value="{{ $key }}"
                                                                            selected>{{ $value }}</option>
                                                                @elseif($key == old('parameter'))
                                                                    <option value="{{ $key }}"
                                                                            selected>{{ $value }}</option>
                                                                @else
                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                @endif
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-sm-3">
                                                <div class="form-group">
                                                    <label>Значення</label>
                                                    <input type="text"
                                                           class="form-control @error('signature') is-invalid @enderror"
                                                           value="{{ old('signature',$signature) }}" id="signature" name="signature"
                                                           placeholder="що шукати">
                                                    @error('signature')
                                                    <div class="invalid-feedback" style="display: block;">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                @if($paramSelected && $signature )
                                                    <div class="card card-gray rounded-pill mb-0 mt-3">
                                                        <div class="card-header rounded-pill">
                                                            <p class="card-title">
                                                                <a class="btn btn-danger btn-sm"
                                                                   href="{{ route('manager.index') }}">
                                                                    <i class="fas fa-trash">
                                                                    </i>
                                                                    Скасувати
                                                                </a>
                                                                <span class="mr-2 ml-2">Знайдено {{ $countUsers }} перевізників.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 col-6">
                                                <button id="btn-submit" class="btn btn-block btn-primary" type="submit">
                                                    Пошук
                                                </button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @forelse ($usersForList as $user)
                                <div class="card card-info collapsed-card mb-1">
                                    <div class="card-header">
                                        <div class="row justify-content-start">
                                            <div class="col-auto text-xl-left">
                                                <span style="margin-right: 15px;">{{ ($usersForList->currentPage() - 1) * $usersForList->perPage() + $loop->iteration }}
                                                    .</span>
                                                Акт виконаних робіт
                                            </div>
                                            <div class="col-auto text-left">
                                                # {{ $invoice->number }}
                                            </div>
                                            <div class="col-md-auto text-left">
                                                від {{ $invoice->date_invoice->format('d.m.Y') }}
                                            </div>
                                            <div class="col-auto text-left">
                                                на суму
                                            </div>
                                            <div class="col-auto">
                                                {{ number_format($invoice->sum_for_transfer, 2, '.', ' ') }}
                                            </div>
                                            <div class="col-auto">
                                                <b>{{ $invoice->user->full_name }}</b>
                                            </div>

                                            <div class="card-tools col text-right" id="divcounter{{  $invoice->id  }}">
                                                @if($invoice->counter_sending > 0)
                                                    <span class="badge badge-warning mt-1 mr-3" id="counter{{ $invoice->id }}" style="font-size: 100%;">{{ $invoice->counter_sending }}</span>
                                                @endif
                                                <span class="icheck-primary">
                                                    <input type="checkbox" value="{{ $invoice->id }}"
                                                           id="check{{ $loop->iteration }}" class="check-send">
                                                    <label for="check{{ $loop->iteration }}" class="mt-1"></label>
                                                 </span>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        <div class="row">
                                           text
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @empty
                                <p>Перевізників не знайдено...</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
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

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script>
        jQuery(function ($) {

            //Initialize Select2 Elements
            $('.select2').select2();
            // ---критерій пошуку
            //$( "#parameter" ).change(function() {
           //     $(this).attr("name", this.value);
           // });

        })

    </script>
@endsection