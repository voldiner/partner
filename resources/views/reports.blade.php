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
                        @include('partials.validation_messages')
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
                                        <form action="{{ route('reports.index') }}" method="get">
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
                                                        {{--<label>Період:</label>--}}
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
                                                <div class="col-md-4">
                                                    <!-- multiple -->
                                                    <div class="form-group">
                                                        <label>Автостанції</label>
                                                        <select id="category" name="stations[]" class="select2" multiple="multiple"
                                                                data-placeholder="Виберіть автостанцію"
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
                                                <div class="col-xl-2 col-sm-3">
                                                    <div class="form-group">
                                                        <label>Номер відомості</label>
                                                        <input type="text" class="form-control @error('number_report') is-invalid @enderror" value="{{ old('number_report',$numberReport) }}"id="number_report" name="number_report" placeholder="Номер відомості">
                                                        @error('number_report')
                                                        <div class="invalid-feedback" style="display: block;">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3">
                                                    <div class="form-group">
                                                        <label>Сума відомості</label>
                                                        <input type="text" class="form-control @error('sum_report') is-invalid @enderror" value="{{ old('sum_report',$sum_report) }}" id="sum_report" name="sum_report" placeholder="сума відомості">
                                                        @error('sum_report')
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
                                                        Відібрати
                                                    </button>
                                                </div>

                                            </div>
                                        </form>

                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </div>
                            <div class="col-12">
                                @if($stationsSelected || $numberReport || $sum_report || $dateStart || $dateFinish|| $stationsSelected)
                                <div class="card card-gray rounded-pill">
                                    <div class="card-header rounded-pill">
                                        <p class="card-title">
                                            <a class="btn btn-danger btn-sm" href="{{ route('reports.index') }}">
                                                <i class="fas fa-trash">
                                                </i>
                                                Скасувати
                                            </a>
                                            <span class="mr-2 ml-2">Обрано {{ $countReports }} відомостей:</span>
                                            @if($dateStart && $dateFinish)
                                                <span class="badge badge-warning mt-1" style="font-size: 100%;">Період: {{ $dateStart->format('d.m.Y') }} по {{ $dateFinish->format('d.m.Y') }}</span>
                                            @endif
                                            @if($stationsSelected)
                                                @foreach($stationsSelected as $stationSelected)
                                                    <span class="badge badge-warning mt-1" style="font-size: 100%;">{{ $stationSelected->name }}</span>
                                                @endforeach
                                            @endif
                                            @if($numberReport)
                                                <span class="badge badge-warning mt-1" style="font-size: 100%;">номер: {{ $numberReport }}</span>
                                            @endif
                                            @if($sum_report)
                                                <span class="badge badge-warning mt-1" style="font-size: 100%;">сума: {{ $sum_report }}</span>
                                            @endif
                                        </p>

                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- /.card-body -->
                                </div>
                                @endif
                            </div>
                            <!-- /.col -->
                            <div class="col-12">
                                @forelse ($reports as $report)
                                    <div class="card card-info collapsed-card mb-1">
                                        <div class="card-header">
                                            <div class="row justify-content-between">
                                                <div class="col-xl-2 border-right text-xl-left text-center ">
                                                    <span style="margin-right: 15px;">{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}.</span>
                                                    {{ $report->date_flight->format('d-m-Y') }}
                                                </div>
                                                <div class="col-xl-2 border-right text-center">
                                                    {{ $report->station->name }}
                                                </div>
                                                <div class="col-xl-3 col-sm-5 border-right text-center">
                                                    {{ $report->name_flight }}
                                                </div>
                                                <div class="col-xl-1 col-sm-2 border-right text-center">
                                                    {{ $report->time_flight }}
                                                </div>
                                                <div class="col-xl-1 col-sm-2 border-right text-center">
                                                    {{ $report->num_report }}
                                                </div>
                                                <div class="col-sm-2 text-center">
                                                    {{ $report->sum_tariff }}
                                                </div>
                                                <div class="card-tools col-md-1 text-right">
                                                    <span class="badge badge-warning" style="font-size: 100%;">{{ $report->places_count }}</span>
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body" style="display: none;">
                                            <div class="row">
                                                @if($report->places_count > 0)
                                                    @php
                                                        $countCol1 = $report->places_count < 5 ? $report->places_count : (int) ($report->places_count / 2);
                                                        $countCol2 = $report->places_count < 5 ? 0 :$report->places_count - $countCol1;
                                                    @endphp
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
                                                            @for($i = 0; $i < $countCol1; $i++)
                                                                    <tr style="background-color: rgba(0,0,0,.05);">
                                                                        <td>{{ $i+1 }}.</td>
                                                                        <td>{{ $report->places[$i]->name_stop }}</td>
                                                                        <td>{{ $report->places[$i]->number_place }}</td>
                                                                        <td>{{ $report->places[$i]->ticket_id }}</td>
                                                                        <td>{{ $report->places[$i]->sum }}</td>
                                                                    </tr>
                                                                    @if($report->places[$i]->name_benefit)
                                                                        <tr style="background-color: rgba(0,0,0,.05);">
                                                                            <td colspan="5" style="border-top: none;"> <span class="ml-md-5">{{ $report->places[$i]->num_certificate}}/{{ $report->places[$i]->name_benefit }}/{{ $report->places[$i]->name_passenger }} </span></td>
                                                                        </tr>
                                                                    @endif
                                                            @endfor

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @if($countCol2 > 0)
                                                        <div class="col-lg-6">
                                                        <table class="table table-sm">
                                                        <tbody>
                                                        @for($i = $countCol1; $i < $countCol1 + $countCol2; $i++)
                                                                <tr style="background-color: rgba(0,0,0,.05);">
                                                                    <td style="width: 40px">{{ $i }}.</td>
                                                                    <td>{{ $report->places[$i]->name_stop }}</td>
                                                                    <td style="width: 80px">{{ $report->places[$i]->number_place }}</td>
                                                                    <td style="width: 100px">{{ $report->places[$i]->ticket_id }}</td>
                                                                    <td style="width: 80px">{{ $report->places[$i]->sum }}</td>
                                                                </tr>
                                                                @if($report->places[$i]->name_benefit)
                                                                    <tr style="background-color: rgba(0,0,0,.05);">
                                                                        <td colspan="5" style="border-top: none;"> <span class="ml-md-5">{{ $report->places[$i]->num_certificate}}/{{ $report->places[$i]->name_benefit }}/{{ $report->places[$i]->name_passenger }} </span></td>
                                                                    </tr>
                                                                @endif
                                                        @endfor

                                                        </tbody>
                                                        </table>
                                                        </div>
                                                    @endif
                                                @else
                                                   Оопс! В цій відомості пасажирів не виявлено ...
                                                @endif
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                @empty
                                    <p>Відомостей не знайдено...</p>
                                @endforelse
                            </div>
                            <div class="col-12 mt-2">
                                {{ $reports->links() }}
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
