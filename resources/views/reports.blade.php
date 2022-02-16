@extends('layouts.layout')
@section('title', 'Відомості')
@section('body_classes','hold-transition sidebar-mini')
@section('my_styles')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection
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
                                <h1>Відомості</h1>
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
                            <div class="col-12">
                                <div class="card card-gray">
                                    <div class="card-header">
                                        <h3 class="card-title">Знайти відомості</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: block;">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <!-- data range -->
                                                    <div class="form-group">
                                                        <label>Період:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input name="data-range" type="text" class="form-control float-right"
                                                                   id="reservation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <!-- multiple -->
                                                    <div class="form-group">
                                                        <label>Автостанції</label>
                                                        <select id="category" name="category" class="select2" multiple="multiple"
                                                                data-placeholder="Виберіть автостанцію"
                                                                style="width: 100%;">
                                                            @if($stations->count())
                                                                @foreach($stations as $key => $station)
                                                                    <option value="{{ $key }}">{{ $station }}</option>
                                                                @endforeach
                                                            @else
                                                                <option disabled>Відсутній список АС</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3">
                                                    <div class="form-group">
                                                        <label>Номер відомості</label>
                                                        <input type="text" class="form-control" id="number_report" name="number_report" placeholder="Номер відомості">
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3">
                                                    <div class="form-group">
                                                        <label>Сума відомості</label>
                                                        <input type="text" class="form-control" id="sum_report" name="sum_report" placeholder="сума відомості">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-6">
                                                    <button id="btn-submit" class="btn btn-block btn-primary" type="submit">
                                                        Відібрати
                                                    </button>
                                                </div>

                                            </div>
                                        </form>

                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-12">
                                <div class="card card-info collapsed-card mb-1">
                                    <div class="card-header">
                                            <div class="row justify-content-between">
                                                <div class="col-xl-2 border-right text-center">
                                                    12.01.2022
                                                </div>
                                                <div class="col-xl-2 border-right text-center">
                                                        АС Луцьк
                                                </div>
                                                <div class="col-xl-3 col-sm-5 border-right text-center">
                                                    Луцьк - Володимир-Волинський ч/з Гать
                                                </div>
                                                <div class="col-xl-1 col-sm-2 border-right text-center">
                                                    15-00
                                                </div>
                                                <div class="col-xl-1 col-sm-2 border-right text-center">
                                                    #123456
                                                </div>
                                                <div class="col-sm-2 text-center">
                                                    99125,35
                                                </div>
                                                <div class="card-tools col-md-1 text-right">
                                                    <span class="badge badge-warning" style="font-size: 100%;">8</span>
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <table class="table table-sm">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 40px">#</th>
                                                        <th>Зупинка</th>
                                                        <th style="width: 80px">Місце</th>
                                                        <th style="width: 100px">Номер квитка</th>
                                                        <th style="width: 80px">Сума</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>1.</td>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing?</td>
                                                        <td>1</td>
                                                        <td>93/65879</td>
                                                        <td>99125,32</td>
                                                    </tr>
                                                    <tr style="background-color: rgba(0,0,0,.05);">
                                                        <td>2.</td>
                                                        <td>Рівне</td>
                                                        <td>1</td>
                                                        <td>93/65879</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr style="background-color: rgba(0,0,0,.05);">
                                                        <td colspan="5" style="border-top: none;"> <span class="ml-md-5">1132492 учасник бойових дій ШАФРАН</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.</td>
                                                        <td>Житомир</td>
                                                        <td>1</td>
                                                        <td>9/679</td>
                                                        <td>125,32</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4.</td>
                                                        <td>Рівне</td>
                                                        <td>1</td>
                                                        <td>93/65879</td>
                                                        <td>125,32</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <table class="table table-sm">
                                                    {{--<thead>--}}
                                                    {{--<tr>--}}
                                                        {{--<th style="width: 40px">#</th>--}}
                                                        {{--<th>Зупинка</th>--}}
                                                        {{--<th style="width: 80px">Місце</th>--}}
                                                        {{--<th style="width: 100px">Номер квитка</th>--}}
                                                        {{--<th style="width: 80px">Сума</th>--}}
                                                    {{--</tr>--}}
                                                    {{--</thead>--}}
                                                    <tbody>
                                                    <tr>
                                                        <td style="width: 40px">5.</td>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, maiores?</td>
                                                        <td style="width: 80px">1</td>
                                                        <td style="width: 100px">93/65879</td>
                                                        <td style="width: 80px">99125,32</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6.</td>
                                                        <td>Рівне</td>
                                                        <td>1</td>
                                                        <td>93/65879</td>
                                                        <td>125,32</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7.</td>
                                                        <td>Житомир</td>
                                                        <td>1</td>
                                                        <td>9/679</td>
                                                        <td>125,32</td>
                                                    </tr>
                                                    <tr>
                                                        <td>8.</td>
                                                        <td>Рівне</td>
                                                        <td>1</td>
                                                        <td>93/65879</td>
                                                        <td>125,32</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <div class="card card-info collapsed-card mb-1">
                                    <div class="card-header">
                                        <div class="row justify-content-between">
                                            <div class="col-xl-2 border-right text-center">
                                                12.01.2022
                                            </div>
                                            <div class="col-xl-2 border-right text-center">
                                                АС Луцьк
                                            </div>
                                            <div class="col-xl-3 col-sm-5 border-right text-center">
                                                Луцьк - Володимир-Волинський ч/з Гать
                                            </div>
                                            <div class="col-xl-1 col-sm-2 border-right text-center">
                                                15-00
                                            </div>
                                            <div class="col-xl-1 col-sm-2 border-right text-center">
                                                #123456
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                99125,35
                                            </div>
                                            <div class="card-tools col-md-1 text-right">
                                                <span class="badge badge-warning" style="font-size: 100%;">4</span>
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        The body of the card
                                    </div>
                                    <!-- /.card-body -->
                                </div>

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
@endsection
@section('my_script')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    {{--<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>--}}
    <!-- AdminLTE for demo purposes -->
    {{--<script src="{{ asset('dist/js/demo.js') }}"></script>--}}
    {{--<script src="{{ asset('dist/js/url.min.js') }}"></script>--}}
    <script>
        jQuery(function ($) {
            //Initialize Select2 Elements
            $('.select2').select2();
            //Date range picker
            $('#reservation').daterangepicker(
                {
                    "locale": {
                        "format": "DD/MM/YYYY",
                        "separator": " - ",
                        "applyLabel": "Ok",
                        "cancelLabel": "Cancel",
                        "fromLabel": "From",
                        "toLabel": "To",
                        "customRangeLabel": "Custom",
                        "weekLabel": "W",
                        "daysOfWeek": [
                            "Нд",
                            "По",
                            "Вт",
                            "Ср",
                            "Чт",
                            "Пт",
                            "Сб"
                        ],
                        "monthNames": [
                            "Січень",
                            "Лютий",
                            "Березень",
                            "Квітень",
                            "Травень",
                            "Червень",
                            "Липень",
                            "Серпень",
                            "Вересень",
                            "Жовтень",
                            "Листопад",
                            "Грудень"
                        ],
                        "firstDay": 1
                    },
                    "startDate": "{{ $startDate }}",
                    "endDate": "{{ $endDate }}",
                    "maxDate": "{{ $maxDate }}"
                }, function (start, end, label) {
                    // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                    // var u = new Url();
                    // u.query.from = start.format('YYYY-MM-DD');
                    // u.query.to = end.format('YYYY-MM-DD');
                    // history.pushState({}, '', u);
                }
            );
        })
    </script>
@endsection
