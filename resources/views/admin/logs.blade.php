@extends('admin.layouts.layout')
@section('title', 'Перпегляд логів')
@section('body_classes','hold-transition sidebar-mini')
@section('my_styles')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .logs{
            background-color: #18171b;
            color: #56db3a;
        }
    </style>
@endsection
@section('content')
    <!-- Site wrapper -->
    <div class="wrapper">
    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Перегляд логів</h1>
                        </div>
                        {{--<div class="col-sm-6">--}}
                            {{--<ol class="breadcrumb float-sm-right">--}}
                                {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                                {{--<li class="breadcrumb-item active">Blank Page</li>--}}
                            {{--</ol>--}}
                        {{--</div>--}}
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('partials.status_message')
                    @include('partials.validation_messages')
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary" id="form-id">
                                <div class="info-box no-shadow bg-blue">
                                    <span class="info-box-icon bg-blue"><i rel="Для зміни АС та днів задайте відповідні значення в формі параметрів і натисніть 'Побудувати графік'" class="fas fa-info-circle info-help"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Оберіть дату та тип журналу</span>
                                    </div>

                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" action="{{ route('manager.logs') }}" method="get">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 pr-3">
                                                <div class="form-group">
                                                    <label>Дата:</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                                        </div>
                                                        <input type="text" class="form-control datetimepicker-input" name="date-day" id="reservationdate-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-3">
                                                <div class="form-group">
                                                    <div class="icheck-primary">
                                                        <input type="radio" class="radioPrimary" data-radio="success" id="radioPrimary1" name="nameLog" @if($nameLog == 'download_invoices.log') checked="" @endif value="download_invoices.log">
                                                        <label for="radioPrimary1">
                                                           Завантаження актів
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary">
                                                        <input type="radio" class="radioPrimary" data-radio="error" id="radioPrimary2" name="nameLog" @if($nameLog == 'download_reports.log') checked="" @endif value="download_reports.log">
                                                        <label for="radioPrimary2">
                                                            Завантаження відомостей
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary">
                                                        <input type="radio" class="radioPrimary" data-radio="error" id="radioPrimary3" name="nameLog" @if($nameLog == 'download_users.log') checked="" @endif value="download_users.log">
                                                        <label for="radioPrimary3">
                                                            Завантаження перевізників
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary">
                                                        <input type="radio" class="radioPrimary" data-radio="error" id="radioPrimary4" name="nameLog" @if($nameLog == 'edit_users.log') checked="" @endif value="edit_users.log">
                                                        <label for="radioPrimary4">
                                                            Редагування перевізників
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary">
                                                        <input type="radio" class="radioPrimary" data-radio="error" id="radioPrimary5" name="nameLog" @if($nameLog == 'register.log') checked="" @endif value="register.log">
                                                        <label for="radioPrimary5">
                                                            Реєстрація перевізників
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary">
                                                        <input type="radio" class="radioPrimary" data-radio="error" id="radioPrimary6" name="nameLog" @if($nameLog == 'send_invoices.log') checked="" @endif value="send_invoices.log">
                                                        <label for="radioPrimary6">
                                                            Відправка актів у ВЧАСНО
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Переглянути</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if($log)

                        <div class="row m-1 mb-3 ">
                            <div class="col-12 logs rounded shadow p-3">
                                @foreach($log as $line)
                                    {{ $line }} <br>
                                @endforeach
                            </div>
                        </div>
                    @endif


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
    <script>
        jQuery(function ($) {
            //Initialize Select2 Elements
            $('.select2').select2();
        })

        //Date range picker
        $('#reservationdate-input').daterangepicker(
            {
                singleDatePicker: true,
                showDropdowns: true,
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

            });

    </script>
@endsection