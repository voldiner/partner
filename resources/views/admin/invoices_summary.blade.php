@extends('admin.layouts.layout')
@section('title', 'Загальний свод')
@section('body_classes','hold-transition sidebar-mini')
@section('my_styles')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .total {
            background-color: rgba(0, 0, 0, .05);
            font-weight: bold;
        }

        .display-alert {
            display: block;
        }

        .no-display-alert {
            display: none !important;
        }
        #send-messages{
            height: 200px;
            overflow: auto;
            /*background-color: #0c5460;*/
            border-radius: 5px;
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
            <!-- ajax -->
            <div id="ajax"></div>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Оборотна відомість за місяць</h1>
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
                    {{--<div class="row">--}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-gray">
                                <div class="card-header">
                                    <h3 class="card-title">Оберіть місяць та рік. Сформована таблиця Excel буде завантажена на ваш комп'ютер.</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                    class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="display: block;">
                                    <form action="{{ route('manager.invoices.createSummary') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <!-- multiple -->
                                                <div class="form-group">
                                                    <label>Місяць</label>
                                                    <select id="category" name="month" class="select2" style="width: 100%;">
                                                        @foreach($monthsFromSelect as $key => $month)
                                                            @if(array_key_exists($key, $monthsSelected))
                                                                <option value="{{ $key }}"
                                                                        selected>{{ $month }}</option>
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
                                                    <input type="text"
                                                           class="form-control @error('year') is-invalid @enderror"
                                                           value="{{ old('year',$year) }}" id="year" name="year"
                                                           placeholder="Рік документу">
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
                                                    Створити
                                                </button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
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


        })
    </script>
@endsection