@extends('layouts.layout')
@section('title', 'Акти виконаних робіт')
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
                            <h1>Акти виконаних робіт</h1>
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
                                    <h3 class="card-title">Знайти відомості</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="display: block;">
                                    <form action="{{ route('invoices.index') }}" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <!-- multiple -->
                                                <div class="form-group">
                                                    <label>Місяць</label>
                                                    <select id="category" name="months[]" class="select2" multiple="multiple"
                                                            data-placeholder="Виберіть місяць"
                                                            style="width: 100%;">
                                                            @foreach($monthsFromSelect as $key => $month)
                                                                @if(array_key_exists($key, $monthsSelected))
                                                                    <option value="{{ $key }}" selected>{{ $month }}</option>
                                                                @else
                                                                    <option value="{{ $key }}">{{ $month }}</option>
                                                                @endif
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-sm-3">
                                                <div class="form-group">
                                                    <label>Рік </label>
                                                    <input type="text" class="form-control @error('year') is-invalid @enderror" value="{{ old('year',$year) }}"id="year" name="year" placeholder="Рік документу">
                                                    @error('year')
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
                            @if($monthsSelected || $year )
                                <div class="card card-gray rounded-pill">
                                    <div class="card-header rounded-pill">
                                        <p class="card-title">
                                            <a class="btn btn-danger btn-sm" href="{{ route('invoices.index') }}">
                                                <i class="fas fa-trash">
                                                </i>
                                                Скасувати
                                            </a>
                                            <span class="mr-2 ml-2">Обрано {{ $countInvoices }} документів:</span>
                                            @if($monthsSelected)
                                                @foreach($monthsSelected as $month)
                                                    <span class="badge badge-warning mt-1" style="font-size: 100%;">{{ $month }}</span>
                                                @endforeach
                                            @endif
                                            @if($year)
                                                <span class="badge badge-warning mt-1" style="font-size: 100%;">рік: {{ $year }}</span>
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
                        <div class="col-12">
                            @forelse ($invoices as $invoice)
                                <div class="card card-info collapsed-card mb-1">
                                    <div class="card-header">
                                        <div class="row justify-content-start">
                                            <div class="col-xl-2 text-xl-left text-center ">
                                                <span style="margin-right: 15px;">{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}.</span>
                                                Акт виконаних робіт
                                            </div>
                                            <div class="col-xl-auto text-left">
                                                # {{ $invoice->number }}
                                            </div>
                                            <div class="col-xl-auto text-left">
                                                від {{ $invoice->date_invoice->format('d.m.Y') }}
                                            </div>
                                            <div class="col-xl-auto text-center">
                                                на суму
                                            </div>
                                            <div class="col-xl-2 border-right text-right">
                                                 {{ number_format($invoice->sum_for_transfer, 2, '.', ' ') }}
                                            </div>
                                            {{--<div class="col-sm-2 text-center">--}}
                                                {{--{{ $report->sum_tariff }}--}}
                                            {{--</div>--}}
                                            <div class="card-tools col text-right">
                                                {{--<span class="badge badge-warning" style="font-size: 100%;">{{ $report->places_count }}</span>--}}
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        <div class="row">
                                            {{--@if($report->places_count > 0)--}}
                                                {{--@php--}}
                                                    {{--$countCol1 = $report->places_count < 5 ? $report->places_count : (int) ($report->places_count / 2);--}}
                                                    {{--$countCol2 = $report->places_count < 5 ? 0 :$report->places_count - $countCol1;--}}
                                                {{--@endphp--}}
                                                {{--<div class="col-lg-6">--}}
                                                    {{--<table class="table table-sm">--}}
                                                        {{--<thead>--}}
                                                        {{--<tr>--}}
                                                            {{--<th style="width: 40px">#</th>--}}
                                                            {{--<th>Зупинка</th>--}}
                                                            {{--<th style="width: 80px">Місце</th>--}}
                                                            {{--<th style="width: 100px">Номер квитка</th>--}}
                                                            {{--<th style="width: 80px">Сума</th>--}}
                                                        {{--</tr>--}}
                                                        {{--</thead>--}}
                                                        {{--<tbody>--}}
                                                        {{--@for($i = 0; $i < $countCol1; $i++)--}}
                                                            {{--<tr style="background-color: rgba(0,0,0,.05);">--}}
                                                                {{--<td>{{ $i+1 }}.</td>--}}
                                                                {{--<td>{{ $report->places[$i]->name_stop }}</td>--}}
                                                                {{--<td>{{ $report->places[$i]->number_place }}</td>--}}
                                                                {{--<td>{{ $report->places[$i]->ticket_id }}</td>--}}
                                                                {{--<td>{{ $report->places[$i]->sum }}</td>--}}
                                                            {{--</tr>--}}
                                                            {{--@if($report->places[$i]->name_benefit)--}}
                                                                {{--<tr style="background-color: rgba(0,0,0,.05);">--}}
                                                                    {{--<td colspan="5" style="border-top: none;"> <span class="ml-md-5">{{ $report->places[$i]->num_certificate}}/{{ $report->places[$i]->name_benefit }}/{{ $report->places[$i]->name_passenger }} </span></td>--}}
                                                                {{--</tr>--}}
                                                            {{--@endif--}}
                                                        {{--@endfor--}}

                                                        {{--</tbody>--}}
                                                    {{--</table>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-lg-6">--}}
                                                    {{--@if($countCol2 > 0)--}}
                                                        {{--<table class="table table-sm">--}}
                                                            {{--<tbody>--}}
                                                            {{--@for($i = $countCol1; $i < $countCol1 + $countCol2; $i++)--}}
                                                                {{--<tr style="background-color: rgba(0,0,0,.05);">--}}
                                                                    {{--<td style="width: 40px">{{ $i+1 }}.</td>--}}
                                                                    {{--<td>{{ $report->places[$i]->name_stop }}</td>--}}
                                                                    {{--<td style="width: 80px">{{ $report->places[$i]->number_place }}</td>--}}
                                                                    {{--<td style="width: 100px">{{ $report->places[$i]->ticket_id }}</td>--}}
                                                                    {{--<td style="width: 80px">{{ $report->places[$i]->sum }}</td>--}}
                                                                {{--</tr>--}}
                                                                {{--@if($report->places[$i]->name_benefit)--}}
                                                                    {{--<tr style="background-color: rgba(0,0,0,.05);">--}}
                                                                        {{--<td colspan="5" style="border-top: none;"> <span class="ml-md-5">{{ $report->places[$i]->num_certificate}}/{{ $report->places[$i]->name_benefit }}/{{ $report->places[$i]->name_passenger }} </span></td>--}}
                                                                    {{--</tr>--}}
                                                                {{--@endif--}}
                                                            {{--@endfor--}}

                                                            {{--</tbody>--}}
                                                        {{--</table>--}}
                                                    {{--@endif--}}
                                                    {{--<a class="btn btn-success" id="pdf-list" href="{{ route('reports.show', $report->id) }}">--}}
                                                        {{--<i class="fas fa-download">--}}
                                                        {{--</i>--}}
                                                        {{--Друк PDF--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--@else--}}
                                                {{--Оопс! В цій відомості пасажирів не виявлено ...--}}
                                            {{--@endif--}}
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @empty
                                <p>Відомостей не знайдено...</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 mt-2">
                            {{ $invoices->links() }}
                        </div>
                        {{--<div class="col-md-3 mt-2 text-md-right">--}}
                            {{--<a class="btn btn-success" id="pdf-list" href="{{ $urlCreatePdfList }}">--}}
                                {{--<i class="fas fa-download">--}}
                                {{--</i>--}}
                                {{--Create PDF--}}
                            {{--</a>--}}
                        {{--</div>--}}
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
    {{--<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>--}}
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

        })
    </script>
@endsection