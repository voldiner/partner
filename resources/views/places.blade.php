@extends('layouts.layout')
@section('title', 'Квитки')
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
                                <h1>Квитки</h1>
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
                        @include('partials.validation_messages')
                        {{--<div class="row">--}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-gray">
                                        <div class="card-header">
                                            <h3 class="card-title">Знайти квитки</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body" style="display: block;">
                                            <form action="{{ route('places.index') }}" method="get">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <!-- data range -->
                                                        <div class="form-group">
                                                            <div class="icheck-primary mb-1">
                                                                <input type="checkbox" id="remember" value="1" name="interval" @if($dateStart && $dateFinish) checked="" @endif>
                                                                <label for="remember">
                                                                    Період:
                                                                </label>
                                                            </div>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                                </div>
                                                                <input name="data-range" type="text" class="form-control float-right"
                                                                       id="reservation"  style="height: 35px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <!-- multiple -->
                                                        <div class="form-group">
                                                            <label>Звідки</label>
                                                            <select id="category" name="stations[]" class="select2" multiple="multiple"
                                                                    data-placeholder="Автостанцію продажу"
                                                                    style="width: 100%;">
                                                                @if($stationsFromSelect->count())
                                                                    @foreach($stationsFromSelect as $key => $station)
                                                                        @if($stationsSelected && $stationsSelected->contains($key))
                                                                            <option value="{{ $key }}" selected>{{ $station }}</option>
                                                                        @else
                                                                            <option value="{{ $key }}">{{ $station }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <option disabled>Відсутній список АС</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-1 col-sm-3">
                                                        <div class="form-group">
                                                            <label>Куди</label>
                                                            <input type="text" class="form-control @error('final') is-invalid @enderror" value="{{ old('final',$final) }}"id="final" name="final" placeholder="куди">
                                                            @error('final')
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-1 col-sm-3">
                                                        <div class="form-group">
                                                            <label>Номер</label>
                                                            <input type="text" class="form-control @error('number_place') is-invalid @enderror" value="{{ old('number_place',$numberPlace) }}"id="number_place" name="number_place" placeholder="Номер">
                                                            @error('number_place')
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-sm-4">
                                                        <div class="form-group">
                                                            <label>Пільговик</label>
                                                            <input type="text" class="form-control @error('surname') is-invalid @enderror" value="{{ old('surname',$surname) }}"id="surname" name="surname" placeholder="прізвище або номер">
                                                            @error('surname')
                                                            <div class="invalid-feedback" style="display: block;">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
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
                                    @if($stationsSelected || $numberPlace || $dateStart || $dateFinish || $final || $surname)
                                        <div class="card card-gray rounded-pill">
                                            <div class="card-header rounded-pill">
                                                <p class="card-title">
                                                    <a class="btn btn-danger btn-sm" href="{{ route('reports.index') }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Скасувати
                                                    </a>
                                                    <span class="mr-2 ml-2">Обрано {{ $countPlaces }} квитків:</span>
                                                    @if($dateStart && $dateFinish)
                                                        <span class="badge badge-warning mt-1" style="font-size: 100%;">Період: {{ $dateStart->format('d.m.Y') }} по {{ $dateFinish->format('d.m.Y') }}</span>
                                                    @endif
                                                    @if($stationsSelected)
                                                        @foreach($stationsSelected as $stationSelected)
                                                            <span class="badge badge-warning mt-1" style="font-size: 100%;">{{ $stationSelected->name }}</span>
                                                        @endforeach
                                                    @endif
                                                    @if($numberPlace)
                                                        <span class="badge badge-warning mt-1" style="font-size: 100%;">номер: {{ $numberPlace }}</span>
                                                    @endif
                                                    @if($final)
                                                        <span class="badge badge-warning mt-1" style="font-size: 100%;">куди: {{ $final }}</span>
                                                    @endif
                                                    @if($surname)
                                                        <span class="badge badge-warning mt-1" style="font-size: 100%;">пільговик: {{ $surname }}</span>
                                                    @endif
                                                </p>

                                                <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->

                                            <!-- /.card-body -->
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="row">








                            </div>
                            <div class="row">
                                <div class="col-md-9 mt-2">
                                    {{--{{ $reports->links() }}--}}
                                </div>
                            </div>

                            <!-- /.col -->
                        {{--</div>--}}
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

            if($('#remember').is(":checked")){
                $('#reservation').removeAttr('disabled');
                $('#reservation').removeAttr('disabled')
            }else{
                $('#reservation').attr('disabled', 'disabled');
                $('#reservation').attr('disabled', 'disabled');
            }

            // -- disable or enable date range
            $('#remember').click(function () {
                     if($(this).is(":checked")){
                         $('#reservation').removeAttr('disabled');
                         $('#reservation').removeAttr('disabled')
                     }else{
                         $('#reservation').attr('disabled', 'disabled');
                         $('#reservation').attr('disabled', 'disabled');
                     }
            });
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
                    "startDate": "{{ $dateStart ? $dateStart->format('d/m/Y') : $startDateDefault }}",
                    "endDate": "{{ $dateFinish ? $dateFinish->format('d/m/Y') : $endDateDefault}}",
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
