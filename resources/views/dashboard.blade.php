@extends('layouts.layout')
@section('title', 'Кабінет користувача')
@section('body_classes','hold-transition sidebar-mini')
@section('my_styles')
    <style type="text/css">
        /* Chart.js */
        @keyframes chartjs-render-animation {
            from {
                opacity: .99
            }
            to {
                opacity: 1
            }
        }

        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms
        }

        .chartjs-size-monitor, .chartjs-size-monitor-expand, .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1
        }

        .chartjs-size-monitor-expand > div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0
        }

        .chartjs-size-monitor-shrink > div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0
        }
    </style>
@endsection

@section('content')
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('partials.status_message')
        @include('partials.navbar')

        @include('partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Домашня</h1>
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

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <p class="mb-0">Інформація з відомостей станом на</p>
                                    <span class="info-box-number">@if(isset($statistic['dateInfo'])) {{ $statistic['dateInfo'] }} @else Не визначено @endif</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                                <div class="info-box-content">
                                    <p class="mb-0">Всього завантажено відомостей</p>
                                    <span class="info-box-number">@if(isset($statistic['numberReportsAll'])) {{ $statistic['numberReportsAll'] }} @else Не визначено @endif</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bus"></i></span>
                                <div class="info-box-content">
                                    <p class="mb-0">Інформація про квитки</p>
                                    <span class="info-box-number">@if(isset($statistic['numberPlacesAll'])) {{ $statistic['numberPlacesAll'] }} @else Не визначено @endif</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <p class="mb-0">Інформація про пільгові квитки</p>
                                    <span class="info-box-number">@if(isset($statistic['numberPlacesBenefit'])) {{ $statistic['numberPlacesBenefit'] }} @else Не визначено @endif</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Останні завантажені відомості</h3>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                            <tr style="background-color: rgba(0,0,0,.05);">
                                                <th>Дата</th>
                                                <th >Рейс</th>
                                                <th>Пасажири</th>
                                                <th>Сума</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($reports as $report)
                                                <tr>
                                                    <td>{{ $report->date_flight->format('d-m-Y') }}</td>
                                                    <td><a href="{{ route('reports.index', ['number_report'=>$report->num_report, 'sum_report' => $report->sum_tariff])}}">
                                                            {{ $report->name_flight }}  {{ number_format($report->time_flight, 2, '-', ' ') }}</a>
                                                    </td>
                                                    <td><span class="badge badge-success" style="font-size: 100%;">{{ $report->places_count }}</span></td>
                                                    <td>
                                                        {{ number_format($report->sum_tariff, 2, '.', ' ') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <a href="{{ route('reports.index') }}" class="btn btn-sm btn-secondary float-right">Всі відомості</a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Квитки з останніх відомостей</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                            <tr style="background-color: rgba(0,0,0,.05);">
                                                <th>Дата</th>
                                                <th>Маршрут</th>
                                                <th>Номер</th>
                                                <th>Сума</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $counter = 0; @endphp
                                            @foreach($reports as $report)
                                                @foreach($report->places as $place)
                                                    <tr>
                                                        <td>{{ $report->date_flight->format('d-m-Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('places.index', ['number_place'=>$place->ticket_id, 'final' => $place->name_stop])}}">
                                                                <small>від:</small> {{ $report->station->name }} <small>до:</small> {{ $place->name_stop }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $place->ticket_id }}</td>
                                                        <td>
                                                            {{ $place->sum }}
                                                        </td>
                                                    </tr>
                                                    @php $counter ++; @endphp
                                                    @break($counter === 10)
                                                @endforeach
                                                @break($counter === 10)
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <a href="{{ route('places.index') }}" class="btn btn-sm btn-secondary float-right">Всі квитки</a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
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
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <script>
        $(function () {


        })

    </script>
@endsection